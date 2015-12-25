<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge(
	$lang, array(
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'Ajax Shoutbox settings',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'On this page you can change the settings specific for the shoutbox. <br /><br />
		',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Prune settings',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Enable pruning of posts',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Prune posts after',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Date format',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Default date format for the shoutbox. You shouldn’t use the relative dates, the date won’t update on refresh of the shoutbox',

	)
);
