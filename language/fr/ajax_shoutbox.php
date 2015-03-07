<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 * @translated into French by Psykofloyd & Galixte (http://www.galixte.com)
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
		'AJAX_SHOUTBOX_MESSAGE'          => 'Poster un message',
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'Désolé, pour poster dans la shoutbox JavaScript doit être activé',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'Vous n’avez pas l’autorisation d’effectuer l’action sélectionnée.',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'Message vide',
		'AJAX_SHOUTBOX_ERROR'            => 'Erreur',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'Impossible de supprimer ce message',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'Message introuvable',
		'AJAX_SHOUTBOX_PUSH_NOT_AVAIL'   => 'Le serveur distant n’est pas disponible.',

		'AJAXSHOUTBOX_BOARD_DATE_FORMAT'            => 'Format de la date de la shoutbox',
		'AJAXSHOUTBOX_BOARD_DATE_FORMAT_EXPLAIN'    => 'Spécifiez un format de la date dédié uniquement à la shoutbox. Vous ne devriez pas utiliser un format relatif pour la date.',
	)
);
