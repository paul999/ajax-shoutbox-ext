<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\acp;


class acp_module {
	/** @var  string */
	public $u_action;

	/** @var array  */
	public $new_config = array();

	/** @var   */
	public $page_title;

	/** @var   */
	public $tpl_name;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $cache, $phpbb_container, $phpbb_dispatcher;

		$user->add_lang('acp/board');

		$action	= request_var('action', '');
		$submit = (isset($_POST['submit']) || isset($_POST['allow_quick_reply_enable'])) ? true : false;

		$form_key = 'acp_board';
		add_form_key($form_key);

		/**
		 *	Validation types are:
		 *		string, int, bool,
		 *		script_path (absolute path in url - beginning with / and no trailing slash),
		 *		rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
		 */
		switch ($mode)
		{
			case 'settings':
				$display_vars = array(
					'title'	=> 'ACP_BOARD_SETTINGS',
					'vars'	=> array(
						/*'legend1'				=> 'ACP_BOARD_SETTINGS',
						'sitename'				=> array('lang' => 'SITE_NAME',				'validate' => 'string',	'type' => 'text:40:255', 'explain' => false),
						'site_desc'				=> array('lang' => 'SITE_DESC',				'validate' => 'string',	'type' => 'text:40:255', 'explain' => false),
						'site_home_url'			=> array('lang' => 'SITE_HOME_URL',			'validate' => 'string',	'type' => 'url:40:255', 'explain' => true),
						'site_home_text'		=> array('lang' => 'SITE_HOME_TEXT',		'validate' => 'string',	'type' => 'text:40:255', 'explain' => true),
						'board_index_text'		=> array('lang' => 'BOARD_INDEX_TEXT',		'validate' => 'string',	'type' => 'text:40:255', 'explain' => true),
						'board_disable'			=> array('lang' => 'DISABLE_BOARD',			'validate' => 'bool',	'type' => 'custom', 'method' => 'board_disable', 'explain' => true),
						'board_disable_msg'		=> false,
						'default_lang'			=> array('lang' => 'DEFAULT_LANGUAGE',		'validate' => 'lang',	'type' => 'select', 'function' => 'language_select', 'params' => array('{CONFIG_VALUE}'), 'explain' => false),
						'default_dateformat'	=> array('lang' => 'DEFAULT_DATE_FORMAT',	'validate' => 'string',	'type' => 'custom', 'method' => 'dateformat_select', 'explain' => true),
						'board_timezone'		=> array('lang' => 'SYSTEM_TIMEZONE',		'validate' => 'timezone',	'type' => 'custom', 'method' => 'timezone_select', 'explain' => true),

						'legend2'				=> 'BOARD_STYLE',
						'default_style'			=> array('lang' => 'DEFAULT_STYLE',			'validate' => 'int',	'type' => 'select', 'function' => 'style_select', 'params' => array('{CONFIG_VALUE}', false), 'explain' => true),
						'guest_style'			=> array('lang' => 'GUEST_STYLE',			'validate' => 'int',	'type' => 'select', 'function' => 'style_select', 'params' => array($this->guest_style_get(), false), 'explain' => true),
						'override_user_style'	=> array('lang' => 'OVERRIDE_STYLE',		'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => true),

						'legend3'				=> 'WARNINGS',
						'warnings_expire_days'	=> array('lang' => 'WARNINGS_EXPIRE',		'validate' => 'int:0:9999',	'type' => 'number:0:9999', 'explain' => true, 'append' => ' ' . $user->lang['DAYS']),
*/
						'legend4'					=> 'ACP_SUBMIT_CHANGES',
					)
				);
				break;


			default:
				trigger_error('NO_MODE', E_USER_ERROR);
				break;
		}

		/**
		 * Event to add and/or modify shoutbox configurations
		 *
		 * @event paul999.ajaxshoutbox.shoutbox_config_edit_add
		 * @var	array	display_vars	Array of config values to display and process
		 * @var	string	mode			Mode of the config page we are displaying
		 * @var	boolean	submit			Do we display the form or process the submission
		 * @since 1.0.0-BETA2
		 */
		$vars = array('display_vars', 'mode', 'submit');
		extract($phpbb_dispatcher->trigger_event('paul999.ajaxshoutbox.shoutbox_config_edit_add', compact($vars)));

		if (isset($display_vars['lang']))
		{
			$user->add_lang($display_vars['lang']);
		}

		$this->new_config = $config;
		$cfg_array = (isset($_REQUEST['config'])) ? utf8_normalize_nfc(request_var('config', array('' => ''), true)) : $this->new_config;
		$error = array();

		// We validate the complete config if wished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $user->lang['FORM_INVALID'];
		}
		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				set_config($config_name, $config_value);
			}
		}

		if ($submit)
		{
			add_log('admin', 'LOG_AJAX_SHOUTBOX_CONFIG_' . strtoupper($mode));

			$message = $user->lang('CONFIG_UPDATED');
			$message_type = E_USER_NOTICE;

			trigger_error($message . adm_back_link($this->u_action), $message_type);
		}

		$this->tpl_name = 'acp_board';
		$this->page_title = $display_vars['title'];

		$template->assign_vars(array(
			'L_TITLE'			=> $user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'	=> $user->lang[$display_vars['title'] . '_EXPLAIN'],

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action,
		));

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> $vars['explain'],
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> $content,

			));

			unset($display_vars['vars'][$config_key]);
		}
	}
}
