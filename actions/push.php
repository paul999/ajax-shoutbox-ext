<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\actions;

use Buzz\Browser;
use Buzz\Client\Curl;

class push
{
	/** @var \phpbb\config\config  */
	private $config;

	/** @var \phpbb\log\log  */
	private $log;

	/** @var \phpbb\user  */
	private $user;

	/**
	 * @param \phpbb\config\config $config
	 * @param \phpbb\log\log       $log
	 *
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\log\log $log)
	{
		$this->config = $config;
		$this->user   = $user;
		$this->log    = $log;
	}

	/**
	 * Delete a shoutbox post
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function delete($id)
	{
		$data = array(
			'authkey'   => $this->config['ajaxshoutbox_api_key'],
			'localId'   => $id,
		);
		return $this->postData($data, 'delete');
	}

	/**
	 * @param string $message Message that has been send
	 * @param int    $date    Date in UNIX timestamp
	 * @param string $user    Username (Not the user id!)
	 * @param int    $post_id ID of the post (used for deletion)
	 */
	public function post($message, $date, $user, $post_id)
	{
		$data = array(
			'message'   => $message,
			'date'      => $date,
			'user'      => $user,
			'authkey'   => $this->config['ajaxshoutbox_api_key'],
			'localId'   => $post_id,
		);
		$this->postData($data, 'post');
	}

	/**
	 * Post to the shoutbox-app server
	 *
	 * @param array $data
	 * @param string $path
	 *
	 * @return mixed
	 */
	private function postData($data, $path)
	{
		$browser = new Browser(new Curl());
		try
		{
			$headers = array('Content-Type' => 'application/json');
			$data = @json_encode($data);

			/** @var \Buzz\Message\Response $response */
			$response = $browser->post($this->config['ajaxshoutbox_api_server'] . $path, $headers, $data);

			if ($response->isSuccessful())
			{
				$rsp = $response->getContent();
				$rsp = @json_decode($rsp, true);

				if (isset($rsp['error'])) {
					throw new \Exception(htmlspecialchars($rsp['error'])); // ;)
				}
				return $rsp;
			}
		}
		catch (\Exception $e)
		{
			$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_AJAX_SHOUTBOX_ERROR', time(), array($e->getMessage()));
			return false;
		}
	}

	/**
	 * check if the push to iOS app is enabled, and all requirements are met.
	 * @return bool
	 */
	public function canPush()
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
			$this->config['ajaxshoutbox_api_server'] = 'https://www.shoutbox-app.com/'; // API is for the app only.
		}
		if (!function_exists('curl_version') || !function_exists('curl_init') || !function_exists('curl_exec'))
		{
			return false;
		}
		return true;
	}
}
