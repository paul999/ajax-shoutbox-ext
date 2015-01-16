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
// French translation by Philibert Ollier pollier@student.42.fr

$lang = array_merge(
	$lang, array(
		'ACL_U_SHOUTBOX_VIEW'   => 'Peut voir la messagerie instatanée',
		'ACL_U_SHOUTBOX_POST'   => 'Peut poster dans la messagerie instatanée',
		'ACL_U_SHOUTBOX_QUOTE'  => 'Peut citer la messagerie instatanée',
		'ACL_U_SHOUTBOX_BBCODE' => 'Peut utiliser le BBcode dans la messagerie instatanée',
		'ACL_U_SHOUTBOX_DELETE' => 'Peut supprimer ses post dans la messagerie instatanée',
		'ACL_M_SHOUTBOX_DELETE' => 'Peut supprimer les post dans la messagerie instatanée',
		'ACL_M_SHOUTBOX_EDIT'   => 'Peut editer dans la messagerie instatanée',
	)
);
