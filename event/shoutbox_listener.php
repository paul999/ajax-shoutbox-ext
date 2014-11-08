<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace paul999\ajaxshoutbox\event;


class shoutbox_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface{

	/** @var \phpbb\user  */
	private $user;

	/**
	 * @param \phpbb\user $user
	 */
	public function __construct(\phpbb\user $user) {
		$this->user = $user;
	}
	static public function getSubscribedEvents()
	{
		return array(
		);
	}
} 
