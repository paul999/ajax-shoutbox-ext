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

use Buzz\Browser;
use Buzz\Client\Curl;

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

	/** @var \phpbb\log\log  */
	private $log;

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
								\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\log\log $log, $root_path, $php_ext,
								$table, $usertable)
	{
		$this->config    = $config;
		$this->helper    = $helper;
		$this->template  = $template;
		$this->user      = $user;
		$this->request   = $request;
		$this->db        = $db;
		$this->auth      = $auth;
		$this->log       = $log;
		$this->root_path = $root_path;
		$this->php_ext   = $php_ext;
		$this->table     = $table;
		$this->usertable = $usertable;
	}

	/**
	 * Validate the push connection with shoutbox-app.com
	 *
	 */
	public function validate($id)
	{
		$result = array();
		if ($this->config['ajaxshoutbox_push_enabled']) {
			if ($id == $this->config['ajaxshoutbox_validation_id']) {
				$result['ok'] = 'ok';
				$result['key'] = $this->config['ajaxshoutbox_validation_id'];
			}
			else
			{
				$result['error'] = 'Incorrect key';
			}
		} else {
			$result['error'] = 'disabled';
		}

		$json_response = new \phpbb\json_response();
		$json_response->send(array($result));
	}

	/**
	 *
	 */
	public function post()
	{
		$this->user->add_lang_ext("paul999/ajaxshoutbox", "ajax_shoutbox");

		// We always disallow guests to post in the shoutbox.
		if (!$this->auth->acl_get('u_shoutbox_post') || $this->user->data['user_id'] == ANONYMOUS)
		{
			return $this->helper->error('AJAX_SHOUTBOX_NO_PERMISSION');
		}

		if ($this->request->is_ajax())
		{
			$message = $msg     = trim(utf8_normalize_nfc($this->request->variable('text_shoutbox', '', true)));

			if (empty($message)) {
				return $this->helper->error('AJAX_SHOUTBOX_MESSAGE_EMPTY');
			}

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

			if ($this->validatePush()) {
				// User configured us to submit the shoutbox post to the iOS/Android app
				$this->submitToApp($msg, $insert['post_time'], $this->user->data['username']);
			}

			$json_response = new \phpbb\json_response();
			$json_response->send(array('OK'));
		}
		else
		{
			return $this->helper->error($this->user->lang('ONLY_AJAX'), 500);
		}
	}

	/**
	 * check if the push to iOS app is enabled, and all requirements are met.
	 * @return bool
	 */
	private function validatePush()
	{
		if (!isset($this->config['ajaxshoutbox_push_enabled']) || !$this->config['ajaxshoutbox_push_enabled'])
		{
			return false;
		}
		if (empty($this->config['ajaxshoutbox_api_key']))
		{
			return false;
		}
		if (empty($this->config['ajaxshoutbox_api_server']))
		{
			// hmmm.
			$this->config['ajaxshoutbox_api_server'] = 'https://www.shoutbox-app.com/post'; // API is for the app only.
		}
		if (!function_exists('curl_version') || !function_exists('curl_init') || !function_exists('curl_exec'))
		{
			return false;
		}
		return true;
	}

	/**
	 * @param string $message Message that has been send
	 * @param int $date Date in UNIX timestamp
	 * @param string $user Username (Not the user id!)
	 */
	private function submitToApp($message, $date, $user)
	{

		$browser = new Browser(new Curl());
		try
		{
			$headers = array('Content-Type' => 'application/json');
			$data = json_encode(array(
				'message'   => $message,
				'date'      => $date,
				'user'      => $user,
				'authkey'   => $this->config['ajaxshoutbox_api_key'],
			));

			/** @var \Buzz\Message\Response $response */
			$response = $browser->post($this->config['ajaxshoutbox_api_server'], $headers, $data);

			if ($response->isSuccessful())
			{
				$rsp = $response->getContent();
				$rsp = @json_decode($rsp, true);

				if (isset($rsp['error'])) {
					throw new \Exception(htmlspecialchars($rsp['error'])); // ;)
				}
			}
		}
		catch (\Exception $e)
		{
			// TODO: Missing lang
			$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_AJAX_SHOUTBOX_ERROR', time(), array($e->getMessage()));
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

		$this->returnPosts($result, false);
	}

	/**
	 * Loop over a SQL result set, and generate a JSON array based on the post data.
	 *
	 * @param mixed $result return the data for the posts
	 * @param bool  $reverse
	 */
	private function returnPosts($result, $reverse = true)
	{
		$posts = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$posts[] = $this->getPost($row);
		}
		$this->db->sql_freeresult($result);

		$json_response = new \phpbb\json_response();
		$json_response->send(
			$reverse ? array_reverse($posts) : $posts
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
		if (!defined('PHPBB_USE_BOARD_URL_PATH')) {
			define('PHPBB_USE_BOARD_URL_PATH', true); // Require full URL to smilies.
		}

		$text = generate_text_for_display(
			$row['post_message'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']
		);

		$username = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
		$username = str_replace('./../../', generate_board_url() . '/', $username); // Fix paths
		$username = str_replace('./../', generate_board_url() . '/', $username); // Fix paths

		return array(
			'id'      => $row['shout_id'],
			'user'    => $username,
			'date'    => $this->user->format_date($row['post_time']),
			// This will cause issues with non refreshing posts.
			'message' => $text,
		);
	}
}
