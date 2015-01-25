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
	/** @var \phpbb\config\config  */
	private $config;

	/** @var \phpbb\user */
	private $user;

	/** @var \phpbb\template\template */
	private $template;

	/** @var \phpbb\controller\helper */
	private $helper;

	/** @var \phpbb\auth\auth  */
	private $auth;

	/** @var \phpbb\request\request  */
	private $request;

	/**
	 * @param \phpbb\user              $user
	 * @param \phpbb\template\template $template
	 * @param \phpbb\controller\helper $helper
	 * @param \phpbb\auth\auth         $auth
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template,
								\phpbb\controller\helper $helper, \phpbb\auth\auth $auth, \phpbb\request\request $request)
	{
		$this->config   = $config;
		$this->user     = $user;
		$this->template = $template;
		$this->helper   = $helper;
		$this->auth     = $auth;
		$this->request  = $request;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'          => 'index',
			'core.permissions'			        	=> 'add_permission',
			'forumhulp.cronstatus.modify_cron_task' => 'modify_cron_date',
			'boardtools.cronstatus.modify_cron_task'=> 'modify_cron_date',
			'core.ucp_prefs_personal_data'          => 'update_ucp_personal_data',
			'core.ucp_prefs_personal_update_data'   => 'ucp_prefs_personal_update_data',
			'core.user_add_modify_data'             => 'user_add_modify_data',
		);
	}

	public function user_add_modify_data($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['user_ajaxshoutbox_format'] = $this->config['ajaxshoutbox_date_format'];

		$event['sql_ary'] = $sql_ary;

		return $event;
	}

	public function ucp_prefs_personal_update_data($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['user_ajaxshoutbox_format'] = $event['data']['ajaxshoutbox_format'];

		$event['sql_ary'] = $sql_ary;

		return $event;
	}

	public function update_ucp_personal_data($event)
	{
		$data = $event['data'];
		$data['ajaxshoutbox_format'] = $this->request->variable('ajaxshoutbox_format', $this->user->data['user_ajaxshoutbox_format']);
		$event['data'] = $data;

		if ($event['submit'])
		{
			$error = validate_data($data, array(
				'ajaxshoutbox_format'			=> array('timezone'),
			));

			if (sizeof($error) > 0)
			{
				if (isset($event['error']))
				{
					$event['error'] = array_merge($event['error'], $error);
				}
				else
				{
					// 3.1.3 and lower don't provide us with $error.
					// Set submit to false instead.
					$event['submit'] = false;
				}
			}
		}

		$dateformat_options = '';

		foreach ($this->user->lang['dateformats'] as $format => $null)
		{
			if (strpos($format, '|') === 0)
			{
				continue;
			}
			$dateformat_options .= '<option value="' . $format . '"' . (($format == $data['ajaxshoutbox_format']) ? ' selected="selected"' : '') . '>';
			$dateformat_options .= $this->user->format_date(time(), $format, false) . ((strpos($format, '|') !== false) ? $this->user->lang['VARIANT_DATE_SEPARATOR'] . $this->user->format_date(time(), $format, true) : '');
			$dateformat_options .= '</option>';
		}

		$dateformat_options .= '<option value="custom"';
		if (!isset($this->user->lang['dateformats'][$data['ajaxshoutbox_format']]))
		{
			$dateformat_options .= ' selected="selected"';
		}
		$dateformat_options .= '>' . $this->user->lang['CUSTOM_DATEFORMAT'] . '</option>';

		$this->user->add_lang_ext("paul999/ajaxshoutbox", "ajax_shoutbox");

		$this->template->assign_vars(array(
			'S_SHOUTBOX_DATEFORMAT_OPTIONS' => $dateformat_options,
			'AJAXSHOUTBOX_DATE_FORMAT'      => $data['ajaxshoutbox_format'],
			'A_AJAXSHOUTBOX_DATE_FORMAT'    => addslashes($data['ajaxshoutbox_format']),
		));

		return $event;
	}

	public function modify_cron_date($event)
	{
		if ($event['task_name'] == 'cron.task.shoutbox_prune')
		{
			$event['task_date'] = (int) $this->config['shoutbox_prune_gc'];
			if ($event['task_date'] > 0)
			{
				$new_task = $event['task_date'] + 24 * 3600;
				$event['new_task_date'] = $new_task;
			}
		}
		return $event;
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
