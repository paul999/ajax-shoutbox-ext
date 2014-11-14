<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace paul999\ajaxshoutbox\event;

class shoutbox_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{

	/** @var \phpbb\user */
	private $user;

	/** @var \phpbb\template\template */
	private $template;

	/** @var \phpbb\controller\helper */
	private $helper;

	/**
	 * @param \phpbb\user $user
	 */
	public function __construct(\phpbb\user $user, \phpbb\template\template $template, \phpbb\controller\helper $helper)
	{
		$this->user     = $user;
		$this->template = $template;
		$this->helper   = $helper;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title' => 'index',
		);
	}

	/**
	 *
	 */
	public function index()
	{
		$this->user->add_lang_ext("paul999/ajaxshoutbox", "ajax_shoutbox");

		$this->template->assign_vars(
			array(
				'S_AJAX_SHOUTBOX'    => true,
				'S_CAN_POST_SHOUT'   => true,
				'U_SUBMIT_SHOUTBOX'  => $this->helper->route("paul999_ajaxshoutbox_post"),
				'UA_GET_POST_ACTION' => htmlspecialchars($this->helper->route("paul999_ajaxshoutbox_get_all")),
				'UA_GET_POST_ACTION_NEW'    => htmlspecialchars($this->helper->route("paul999_ajaxshoutbox_get_after", array('id' => 0))),
			)
		);
	}
}
