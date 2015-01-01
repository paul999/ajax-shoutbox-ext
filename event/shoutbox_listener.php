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

	/** @var \phpbb\auth\auth  */
	private $auth;

	/**
	 * @param \phpbb\user              $user
	 * @param \phpbb\template\template $template
	 * @param \phpbb\controller\helper $helper
	 * @param \phpbb\auth\auth         $auth
	 */
	public function __construct(\phpbb\user $user, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\auth\auth $auth)
	{
		$this->user     = $user;
		$this->template = $template;
		$this->helper   = $helper;
		$this->auth     = $auth;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'  => 'index',
			'core.permissions'				=> 'add_permission',
		);
	}

	/**
	 *
	 */
	public function index()
	{
		$this->user->add_lang_ext('paul999/ajaxshoutbox', 'ajax_shoutbox');

		$this->template->assign_vars(
			array(
				'S_AJAX_SHOUTBOX'    => $this->auth->acl_get('u_shoutbox_view'),
				'S_CAN_POST_SHOUT'   => $this->auth->acl_get('u_shoutbox_post') && $this->user->data['user_id'] != ANONYMOUS,
				'U_SUBMIT_SHOUTBOX'  => $this->helper->route('paul999_ajaxshoutbox_post'),
				'U_DELETE_SHOUTBOX'  => $this->helper->route('paul999_ajaxshoutbox_delete'),
				'UA_GET_POST_ACTION' => htmlspecialchars($this->helper->route('paul999_ajaxshoutbox_get_all')),
				'UA_GET_POST_ACTION_NEW'    => htmlspecialchars($this->helper->route('paul999_ajaxshoutbox_get_after', array('id' => 0))),
				'UA_GET_POST_ACTION_OLD'    => htmlspecialchars($this->helper->route('paul999_ajaxshoutbox_get_before', array('id' => 0))),
			)
		);
	}


	/**
	 * Add administrative permissions
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];

		$permissions['u_shoutbox_view'] = array('lang' => 'ACL_U_SHOUTBOX_VIEW', 'cat' => 'misc');
		$permissions['u_shoutbox_post'] = array('lang' => 'ACL_U_SHOUTBOX_POST', 'cat' => 'misc');
		$permissions['u_shoutbox_quote'] = array('lang' => 'ACL_U_SHOUTBOX_QUOTE', 'cat' => 'misc');
		$permissions['u_shoutbox_bbcode'] = array('lang' => 'ACL_U_SHOUTBOX_BBCODE', 'cat' => 'misc');
		$permissions['u_shoutbox_delete'] = array('lang' => 'ACL_U_SHOUTBOX_DELETE', 'cat' => 'misc');
		$permissions['m_shoutbox_delete'] = array('lang' => 'ACL_M_SHOUTBOX_DELETE', 'cat' => 'misc');
		$permissions['m_shoutbox_edit'] = array('lang' => 'ACL_M_SHOUTBOX_EDIT', 'cat' => 'misc');

		$event['permissions'] = $permissions;
	}
}
