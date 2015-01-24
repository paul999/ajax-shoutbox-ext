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
		'AJAX_SHOUTBOX'                  => 'Cuadro de Charla',
		'AJAX_SHOUTBOX_MESSAGE'          => 'Añadir mensaje',
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'Lo sentimos, la publicación en el Cuadro de Charla sólo se admite cuando JavaScript está activado',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'No tiene permiso para la acción seleccionada',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'Mensaje vacío',
		'AJAX_SHOUTBOX_ERROR'            => 'Error',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'No se puede eliminar el mensaje',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'No se puede encontrar el mensaje',
		'AJAX_SHOUTBOX_PUSH_NOT_AVAIL'   => 'El servidor de inserción remoto no está disponible',

		'AJAXSHOUTBOX_BOARD_DATE_FORMAT'            => 'My shoutbox date format',
		'AJAXSHOUTBOX_BOARD_DATE_FORMAT_EXPLAIN'    => 'Specify a date format for just the shoutbox. You should not use a relative date format.',
	)
);
