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

	/**
	 * @param \phpbb\user $user
	 */
	public function __construct(\phpbb\user $user, \phpbb\template\template $template)
	{
		$this->user     = $user;
		$this->template = $template;
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
		$this->template->assign_vars(
			array(
				'S_AJAX_SHOUTBOX' => true,
			)
		);
	}
}
