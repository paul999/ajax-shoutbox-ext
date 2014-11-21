<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * Dutch translation by Dutch Translators (https://github.com/dutch-translators)
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
		"AJAX_SHOUTBOX"    => "Shoutbox",
		"SHOUTBOX_MESSAGE" => "Plaats bericht",
		"ONLY_AJAX"        => "Sorry, je kunt alleen een bericht plaatsen als JavaScript is ingeschakeld.",
		"AJAX_SHOUTBOX_NO_PERMISSION"   => 'Geen toestemming voor de geselecteerde actie',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'   => 'Het bericht is leeg',
	)
);
