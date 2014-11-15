<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\controller;

/**
 * Main controller
 */
class main_controller
{
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\controller\helper */
	protected $helper;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user */
	protected $user;
	/** @var string phpBB root path */
	protected $root_path;
	/** @var string phpEx */
	protected $php_ext;

	/** @var \phpbb\request\request */
	private $request;

	/** @var \phpbb\db\driver\driver_interface */
	private $db;

	/** @var \phpbb\auth\auth */
	private $auth;

	/** @var  string */
	private $table;

	/** @var string */
	private $usertable;

	/**
	 * @param \phpbb\config\config              $config
	 * @param \phpbb\controller\helper          $helper
	 * @param \phpbb\template\template          $template
	 * @param \phpbb\user                       $user
	 * @param \phpbb\request\request            $request
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\auth\auth                  $auth
	 * @param string                            $root_path
	 * @param string                            $php_ext
	 * @param string                            $table
	 * @param string                            $usertable
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper,
								\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request,
								\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, $root_path, $php_ext,
								$table, $usertable)
	{
		$this->config    = $config;
		$this->helper    = $helper;
		$this->template  = $template;
		$this->user      = $user;
		$this->request   = $request;
		$this->db        = $db;
		$this->auth      = $auth;
		$this->root_path = $root_path;
		$this->php_ext   = $php_ext;
		$this->table     = $table;
		$this->usertable = $usertable;
	}

	/**
	 *
	 */
	public function post()
	{
		// We always disallow guests to post in the shoutbox.
		if (!$this->auth->acl_get('u_shoutbox_post') || $this->user->data['user_id'] == ANONYMOUS)
		{
			$this->helper->error('AJAX_SHOUTBOX_NO_PERMISSION');
		}

		if ($this->request->is_ajax())
		{
			$message      = utf8_normalize_nfc($this->request->variable('text_shoutbox', '', true));
			$uid          = $bitfield = $options = '';
			$allow_bbcode = $this->auth->acl_get('u_shoutbox_bbcode');
			$allow_urls   = $allow_smilies = true;

			if (!function_exists('generate_text_for_storage'))
			{
				include($this->root_path . 'includes/functions_content.' . $this->php_ext);
			}

			generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

			$insert = array(
				'post_message'    => $message,
				'post_time'       => time(),
				'user_id'         => $this->user->data['user_id'],
				'bbcode_options'  => $options,
				'bbcode_bitfield' => $bitfield,
				'bbcode_uid'      => $uid,
			);
			$sql    = 'INSERT INTO ' . $this->table . ' ' . $this->db->sql_build_array('INSERT', $insert);
			$this->db->sql_query($sql);

			$json_response = new \phpbb\json_response();
			$json_response->send(array('OK'));
		} else
		{
			$this->helper->error($this->user->lang('ONLY_AJAX'), 500);
		}
	}

	/**
	 * Get the last 10 shouts
	 */
	public function getAll()
	{
		if (!$this->auth->acl_get('u_shoutbox_view'))
		{
			$this->helper->error('AJAX_SHOUTBOX_NO_PERMISSION');
		}

		$sql    = 'SELECT c.*, u.username, u.user_colour FROM
					' . $this->table . ' c,
					' . $this->usertable . ' u
					WHERE
						u.user_id = c.user_id
					ORDER BY post_time DESC';
		$result = $this->db->sql_query_limit($sql, 10);

		$this->returnPosts($result);
	}

	/**
	 * Get all shouts since a specific shout ID.
	 *
	 * @param int $id Last selected ID.
	 */
	public function getAfter($id)
	{
		if (!$this->auth->acl_get('u_shoutbox_view'))
		{
			$this->helper->error('AJAX_SHOUTBOX_NO_PERMISSION');
		}

		$sql    = 'SELECT c.*, u.username, u.user_colour FROM
				' . $this->table . ' c,
				' . $this->usertable . ' u
				WHERE post_time >= (
						SELECT post_time FROM ' . $this->table . '
						WHERE shout_id = ' . (int) $id . '
					)
					AND c.shout_id != ' . (int) $id . '
					AND u.user_id = c.user_id
				ORDER BY post_time DESC';
		$result = $this->db->sql_query($sql);

		$this->returnPosts($result);
	}

	/**
	 * Get 10 shouts before the current shout ID.
	 *
	 * @param $id
	 */
	public function getBefore($id)
	{
		if (!$this->auth->acl_get('u_shoutbox_view'))
		{
			$this->helper->error('AJAX_SHOUTBOX_NO_PERMISSION');
		}

		$sql    = 'SELECT c.*, u.username, u.user_colour FROM
				' . $this->table . ' c,
				' . $this->usertable . ' u
				WHERE post_time <= (
						SELECT post_time FROM ' . $this->table . '
						WHERE shout_id = ' . (int) $id . '
					)
					AND c.shout_id != ' . (int) $id . '
					AND u.user_id = c.user_id
				ORDER BY post_time DESC'; 
		$result = $this->db->sql_query_limit($sql, 10);

		$this->returnPosts($result);
	}

	/**
	 * Loop over a SQL result set, and generate a JSON array based on the post data.
	 *
	 * @param mixed $result return the data for the posts
	 */
	private function returnPosts($result)
	{
		$posts = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$posts[] = $this->getPost($row);
		}
		$this->db->sql_freeresult($result);

		$json_response = new \phpbb\json_response();
		$json_response->send(
			array_reverse($posts)
		);
	}

	/**
	 * Generate a array with the specific post for this shout.
	 *
	 * @param array $row Input row
	 *
	 * @return array output
	 */
	private function getPost($row)
	{
		$text = generate_text_for_display(
			$row['post_message'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']
		);

		return array(
			'id'      => $row['shout_id'],
			'user'    => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
			'date'    => $this->user->format_date($row['post_time']),
			// This will cause issues with non refreshing posts.
			'message' => $text,
		);
	}
}
