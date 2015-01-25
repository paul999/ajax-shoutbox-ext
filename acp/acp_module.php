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
		global $user, $template, $request;
		global $config, $phpbb_dispatcher, $phpbb_log;

		$user->add_lang_ext("paul999/ajaxshoutbox", "acp_ajax_shoutbox");
		$user->add_lang('acp/board');

		$submit = isset($_POST['submit']);

		$form_key = 'acp_shoutbox';
		add_form_key($form_key);

		$display_vars = array(
			'title'	=> 'ACP_AJAXSHOUTBOX_SETTINGS',
			'vars'	=> array(
				'legend1'				=> 'ACP_AJAXSHOUTBOX_PRUNE',
				'ajaxshoutbox_enable_prune'			=> array('lang' => 'AJAXSHOUTBOX_ENABLE_PRUNE',			'validate' => 'bool',	'type' => 'radio:yes_no','explain' => false),
				'ajaxshoutbox_prune_days'			=> array('lang' => 'AJAXSHOUTBOX_PRUNE_DAYS',			'validate' => 'int',	'type' => 'number:0:9999','explain' => false, 'append' => ' ' . $user->lang['DAYS']),
				'ajaxshoutbox_date_format'      	=> array('lang' => 'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT',	'validate' => 'string',	'type' => 'custom', 'method' => 'dateformat_select', 'explain' => true),
			)
		);

		// We only show the app settings if it is enabled.
		if (defined('AJAXSHOUTBOX_SHOW_APP'))
		{
			$display_vars['vars'] += array(
				'legend2'                     => 'ACP_AJAXSHOUTBOX_PUSH',
				'ajaxshoutbox_validation_id'  => array('lang' => 'AJAXSHOUTBOX_ACTIVATION_KEY', 'validate' => 'string',
													   'type' => 'custom', 'explain' => false, 'method' => 'key'
				),
				'ajaxshoutbox_push_enabled'   => array('lang' => 'ACP_AJAXSHOUTBOX_ENABLE_PUSH', 'validate' => 'bool',
													   'type' => 'radio:yes_no', 'explain' => true
				),
				'ajaxshoutbox_api_key'        => array('lang'     => 'ACP_AJAXSHOUTBOX_API_KEY_PUSH',
													   'validate' => 'string', 'type' => 'text:40:255',
													   'explain'  => true
				),
				'ajaxshoutbox_connection_key' => array('lang'     => 'ACP_AJAXSHOUTBOX_CON_KEY_PUSH',
													   'validate' => 'string', 'type' => 'text:40:255',
													   'explain'  => true
				),
			);
		}
		else
		{
			$display_vars['vars'] += array(
				'legend2'       => 'ACP_AJAXSHOUTBOX_PUSH',
				'ajaxshoutbox_push_disabled'  => array('lang' => 'ACP_AJAXSHOUTBOX_PUSH_DISABLED', 'validate' => 'string', 'type' => 'custom', 'explain' => false, 'method' => 'push_disabled',),
			);
		}

		$display_vars['vars'] += array(

			'legend4'				=> 'ACP_SUBMIT_CHANGES',
		);

		/**
		* Event to add and/or modify acp_board configurations
		*
		* @event paul999.ajaxshoutbox.shoutbox_config_edit_add
		* @var	array	display_vars	Array of config values to display and process
		* @var	string	mode			Mode of the config page we are displaying
		* @var	boolean	submit			Do we display the form or process the submission
		* @since 1.0.0-b2
		*/
		$vars = array('display_vars', 'mode', 'submit');
		extract($phpbb_dispatcher->trigger_event('paul999.ajaxshoutbox.shoutbox_config_edit_add', compact($vars)));

		$this->new_config = $config;
		// Copied from acp_board.php
		$cfg_array = (isset($_REQUEST['config'])) ? utf8_normalize_nfc($request->variable('config', array('' => ''), true)) : $this->new_config;
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
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false || $config_name == 'ajaxshoutbox_validation_id' || $config_name == 'ajaxshoutbox_push_disabled')
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				$config->set($config_name, $config_value);
			}
		}

		if ($submit)
		{
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_AJAX_SHOUTBOX_CONFIG_' . strtoupper($mode));

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
			if ($vars['explain'] && isset($user->lang[$vars['lang'] . '_EXPLAIN']))
			{
				$l_explain =  $user->lang[$vars['lang'] . '_EXPLAIN'];
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

	function key()
	{
		global $config;

		return '<strong>' . $config['ajaxshoutbox_validation_id'] . '</strong>';
	}
	function push_disabled()
	{
		global $user;

		// Yes, I agree, it should be in the html file.
		// However, as the files are generated based on acp_board, and this code is temporary,
		// I put it here for now.
		$html = '<div class="codebox"><code>define("AJAXSHOUTBOX_SHOW_APP", true);</code></div>';

		return $user->lang['ACP_AJAXSHOUTBOX_PUSH_DISABLED_EXPLAIN'] . $html;
	}

	/**
	 * Set the date format.
	 * @param $value
	 * @param $key
	 *
	 * @return string
	 */
	function dateformat_select($value, $key)
	{
		global $user, $config;
		// Let the format_date function operate with the acp values
		$old_tz = $user->timezone;
		try
		{
			$user->timezone = new \DateTimeZone($config['board_timezone']);
		}
		catch (\Exception $e)
		{
			// If the board timezone is invalid, we just use the users timezone.
		}
		$dateformat_options = '';
		foreach ($user->lang['dateformats'] as $format => $null)
		{
			if (strpos($format, '|') === 0) // Skip relative formats!
			{
				continue;
			}

			$dateformat_options .= '<option value="' . $format . '"' . (($format == $value) ? ' selected="selected"' : '') . '>';
			$dateformat_options .= $user->format_date(time(), $format, false) . ((strpos($format, '|') !== false) ? $user->lang['VARIANT_DATE_SEPARATOR'] . $user->format_date(time(), $format, true) : '');
			$dateformat_options .= '</option>';
		}
		$dateformat_options .= '<option value="custom"';
		if (!isset($user->lang['dateformats'][$value]))
		{
			$dateformat_options .= ' selected="selected"';
		}
		$dateformat_options .= '>' . $user->lang['CUSTOM_DATEFORMAT'] . '</option>';
		// Reset users date options
		$user->timezone = $old_tz;
		return "<select name=\"dateoptions\" id=\"dateoptions\" onchange=\"if (this.value == 'custom') { document.getElementById('" . addslashes($key) . "').value = '" . addslashes($value) . "'; } else { document.getElementById('" . addslashes($key) . "').value = this.value; }\">$dateformat_options</select>
		<input type=\"text\" name=\"config[$key]\" id=\"$key\" value=\"$value\" maxlength=\"30\" />";
	}
}
