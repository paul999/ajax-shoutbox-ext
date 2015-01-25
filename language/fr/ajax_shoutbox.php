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
		'AJAX_SHOUTBOX'                  => 'Shoutbox',
		'AJAX_SHOUTBOX_MESSAGE'          => 'Poster message',
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'Désolé, JavaScript doit être activé',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'Vous n’avez pas la permission d’effectuer l’action séléctionée.',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'Message vide',
		'AJAX_SHOUTBOX_ERROR'            => 'Erreur',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'Impossible de supprimer ce post',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'Post introuvable',
		'AJAX_SHOUTBOX_PUSH_NOT_AVAIL'   => 'Le serveur distant n’est pas disponible.',

		'AJAXSHOUTBOX_BOARD_DATE_FORMAT'            => 'My shoutbox date format',
		'AJAXSHOUTBOX_BOARD_DATE_FORMAT_EXPLAIN'    => 'Specify a date format for just the shoutbox. You should not use a relative date format.',
	)
);
