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

	/**
	 * @param \phpbb\config\config     $config
	 * @param \phpbb\controller\helper $helper
	 * @param \phpbb\template\template $template
	 * @param \phpbb\user              $user
	 * @param string                   $root_path
	 * @param string                   $php_ext
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper,
								\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request,
								$root_path, $php_ext)
	{
		$this->config    = $config;
		$this->helper    = $helper;
		$this->template  = $template;
		$this->user      = $user;
		$this->request   = $request;
		$this->root_path = $root_path;
		$this->php_ext   = $php_ext;
	}

	/**
	 *
	 */
	public function post()
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response();
			$json_response->send(
				array()
			);
		}
	}
}
