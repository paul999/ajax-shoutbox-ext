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
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'Ajax Shoutbox instellingen',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'Op deze pagina vind je de instellingen specifiek voor de shoutbox.<br /><br />
		',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Prune instellingen',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Zet het automatische verwijderen van oude posts aan',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Prune posts na',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Datum formaat',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Standaard datum formaat voor in de shoutbox. Je kan het beste geen gebruik maken van
			relatieve formaten, aangezien de datum niet update wanneer de shoutbox ververst.
		',

	)
);
