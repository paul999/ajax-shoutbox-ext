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

use Endroid\QrCode\QrCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

	/** @var \paul999\ajaxshoutbox\actions\Delete  */
	private $delete;

	/** @var \paul999\ajaxshoutbox\actions\Push  */
	private $push;

	private $dispatcher;

	/** @var  string */
	private $table;

	/** @var string */
	private $usertable;

	/**
	 * @param \phpbb\config\config                 $config
	 * @param \phpbb\controller\helper             $helper
	 * @param \phpbb\template\template             $template
	 * @param \phpbb\user                          $user
	 * @param \phpbb\request\request               $request
	 * @param \phpbb\db\driver\driver_interface    $db
	 * @param \phpbb\auth\auth                     $auth
	 * @param \phpbb\log\log                       $log
	 * @param \paul999\ajaxshoutbox\actions\delete $delete
	 * @param \paul999\ajaxshoutbox\actions\push   $push
	 * @param string                               $root_path
	 * @param string                               $php_ext
	 * @param string                               $table
	 * @param string                               $usertable
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper,
								\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request,
								\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\log\log $log,
								\phpbb\event\dispatcher_interface $dispatcher,
								\paul999\ajaxshoutbox\actions\delete $delete, \paul999\ajaxshoutbox\actions\push $push,
								$root_path, $php_ext, $table, $usertable)
	{
		$this->config     = $config;
		$this->helper     = $helper;
		$this->template   = $template;
		$this->user       = $user;
		$this->request    = $request;
		$this->db         = $db;
		$this->auth       = $auth;
		$this->log        = $log;
		$this->dispatcher = $dispatcher;
		$this->delete     = $delete;
		$this->push       = $push;
		$this->root_path  = $root_path;
		$this->php_ext    = $php_ext;
		$this->table      = $table;
		$this->usertable  = $usertable;

		$this->user->add_lang_ext("paul999/ajaxshoutbox", "ajax_shoutbox");
	}

	/**
	 * Create a image with a QR code.
	 * The image will be directly returned, with correct HTTP headers.
	 *
	 * The code in the URL will be embedded in the QR code.
	 *
	 * @param String $code Code to embed in the QR code
	 * @return Response
	 */
	public function qrCode($code)
	{
		$code = str_replace(':__', '://', $code);
		$qr = new QrCode();

		$image = $qr->setText($code)
			->setSize(75)
			->setPadding(10)
			->setErrorCorrection('high')
			->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
			->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
			->setLabelFontSize(16)
			->get();

		return new Response($image, 200, array('Content-Type' =>  'image/jpeg'));
	}

	/**
	 * Validate the push connection with shoutbox-app.com
	 *
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function validate($id)
	{
		$result = array();

		// Language used here won't be seen by the user.
		// It is used on shoutbox-app.com to specify the result.
		// Do not change.
		if ($this->config['ajaxshoutbox_push_enabled'])
		{
			if ($id == $this->config['ajaxshoutbox_validation_id'])
			{
				$result['ok'] = 'ok';
				$result['key'] = $this->config['ajaxshoutbox_validation_id'];
			}
			else
			{
				$result['error'] = 'Incorrect key';
			}
		}
		else
		{
			$result['error'] = 'disabled';
		}

		return new JsonResponse(array($result));
	}

	/**
	 * Post a new message to the shoutbox.
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function post()
	{
		// We always disallow guests to post in the shoutbox.
		if (!$this->auth->acl_get('u_shoutbox_post') || $this->user->data['user_id'] == ANONYMOUS)
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_NO_PERMISSION', 403);
		}

		if (!check_form_key('ajaxshoutbox_posting', 3600 * 12)) // Allow 12 hours.
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'FORM_INVALID', 500);
		}

		if ($this->request->is_ajax())
		{
			$message = $msg     = trim($this->request->variable('text_shoutbox', '', true));

			if (empty($message))
			{
				return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_MESSAGE_EMPTY', 500);
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

			if ($this->push->canPush())
			{
				// User configured us to submit the shoutbox post to the iOS/Android app
				$this->push->post($msg, $insert['post_time'], $this->user->data['username'], $this->db->sql_nextid());
			}

			return new JsonResponse(array('OK'));
		}
		else
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_ONLY_AJAX', 500);
		}
	}

	/**
	 * Delete a post from the client.
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function delete()
	{
		$id = $this->request->variable('id', 0, false, \phpbb\request\request_interface::POST);

		if (!$id)
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_MISSING_ID', 500);
		}

		if (!check_form_key('ajaxshoutbox_delete_' . $id)) // Every delete form has its unique form key, based on ID.
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'FORM_INVALID', 500);
		}

		try
		{
			$this->delete->delete_post($id);
		}
		catch (\paul999\ajaxshoutbox\exceptions\shoutbox_exception $exception)
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', $exception->getMessage(), 500);
		}
		return new JsonResponse(array('OK'));
	}

	/**
	 * Get the last 10 shouts
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getAll()
	{
		if (!$this->auth->acl_get('u_shoutbox_view'))
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_NO_PERMISSION', 403);
		}

		$limit = 10;
		$sql    = 'SELECT c.*, u.username, u.user_colour FROM
					' . $this->table . ' c,
					' . $this->usertable . ' u
					WHERE
						u.user_id = c.user_id
					ORDER BY post_time DESC';

		/**
		 * Change SQL query for getAll
		 *
		 * @event paul999.ajaxshoutbox.getAll_change_sql
		 * @var		string	sql     Query to run
		 * @var		int		limit	The amount of shouts initially received.
		 * @since 1.1.0-B1
		 */
		$vars = array('sql', 'limit');
		extract($this->dispatcher->trigger_event('paul999.ajaxshoutbox.getAll_change_sql', compact($vars)));

		$result = $this->db->sql_query_limit($sql, $limit);

		return $this->returnPosts($result);
	}

	/**
	 * Get all shouts since a specific shout ID.
	 *
	 * @param int $id Last selected ID.
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getAfter($id)
	{
		if (!$this->auth->acl_get('u_shoutbox_view'))
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_NO_PERMISSION', 403);
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
				ORDER BY post_time DESC, shout_id DESC';

		/**
		 * Change SQL query for getAfter
		 *
		 * @event paul999.ajaxshoutbox.getAfter_change_sql
		 * @var    string    sql     Query to run
		 * @since 1.1.0-B1
		 */
		$vars = array('sql');
		extract($this->dispatcher->trigger_event('paul999.ajaxshoutbox.getAfter_change_sql', compact($vars)));

		$result = $this->db->sql_query($sql);

		return $this->returnPosts($result);
	}

	/**
	 * Get 10 shouts before the current shout ID.
	 *
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getBefore($id)
	{
		if (!$this->auth->acl_get('u_shoutbox_view'))
		{
			return $this->error('AJAX_SHOUTBOX_ERROR', 'AJAX_SHOUTBOX_NO_PERMISSION', 403);
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
				ORDER BY post_time DESC, shout_id ASC';

		/**
		 * Change SQL query for getBefore
		 *
		 * @event paul999.ajaxshoutbox.getBefore_change_sql
		 * @var    string    sql     Query to run
		 * @since 1.1.0-B1
		 */
		$vars = array('sql');
		extract($this->dispatcher->trigger_event('paul999.ajaxshoutbox.getBefore_change_sql', compact($vars)));

		$result = $this->db->sql_query_limit($sql, 10);

		return $this->returnPosts($result, false);
	}

	/**
	 * Loop over a SQL result set, and generate a JSON array based on the post data.
	 *
	 * @param mixed $result return the data for the posts
	 * @param bool  $reverse
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	private function returnPosts($result, $reverse = true)
	{
		$posts = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$posts[] = $this->getPost($row);
		}
		$this->db->sql_freeresult($result);

		return new JsonResponse($reverse ? array_reverse($posts) : $posts);
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
		if (!defined('PHPBB_USE_BOARD_URL_PATH'))
		{
			define('PHPBB_USE_BOARD_URL_PATH', true); // Require full URL to smilies.
		}

		$text = generate_text_for_display(
			$row['post_message'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']
		);

		$username = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
		$username = str_replace('./../../', generate_board_url() . '/', $username); // Fix paths
		$username = str_replace('./../', generate_board_url() . '/', $username); // Fix paths

		$result = array(
			'id'      => $row['shout_id'],
			'user'    => $username,
			'date'    => $this->user->format_date($row['post_time'], $this->user->data['user_ajaxshoutbox_format']),
			'message' => $text,
			'delete'  => ($this->auth->acl_get('m_shoutbox_delete') || ($this->auth->acl_get('u_shoutbox_delete') && $row['user_id'] == $this->user->data['user_id'])),
		);

		/**
		 * Add data to a event row.
		 *
		 * @event paul999.ajaxshoutbox.postrow
		 * @var    array    row     The row with data from the database
		 * @var    array    result	The current result returned for the template, but without form key. It is (For security reasons) impossible to modify the form key.
		 * @since 1.1.0-B1
		 */
		$vars = array('row', 'result');
		extract($this->dispatcher->trigger_event('paul999.ajaxshoutbox.postrow', compact($vars)));

		return array_merge($result, $this->add_form_key('ajaxshoutbox_delete_' . $row['shout_id']));
	}

	/**
	 * Send a error to the user.
	 *
	 * Important: phpBB (<= 3.1.2) handles non 200 status as error.
	 * Due to the way this is implemented, phpBB will display the browser
	 * generated error, instead of the user returned error.
	 * This method will result in a 200 OK, but the correct status is in
	 * the JsonResponse.status.
	 *
	 * @param string $title
	 * @param string $message
	 * @param integer $status
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	private function error($title, $message, $status)
	{
		$json = new JsonResponse(array(
			'title'     => $this->user->lang[$title],
			'error'     => $this->user->lang[$message],
			'status'    => $status,
		));

		return $json;
	}

	/**
	 * Add a secret token and returns it as array with creation_time and form_token.
	 *
	 * Based on phpBB's add_form_key. Compatible with check_form_key.
	 *
	 * IMPORTANT: The original event is not included, because the form is build before the event,
	 * while this function returns the (Possible modified) data after the event.
	 *
	 * @param string $form_name The name of the form; has to match the name used in check_form_key, otherwise no
	 *                          restrictions apply
	 *
	 * @return array
	 */
	private function add_form_key($form_name)
	{
		$now = time();
		$token_sid = ($this->user->data['user_id'] == ANONYMOUS && !empty($this->config['form_token_sid_guests'])) ? $this->user->session_id : '';
		$token = sha1($now . $this->user->data['user_form_salt'] . $form_name . $token_sid);

		return array(
			'creation_time' => $now,
			'form_token' => $token,
		);
	}
}
