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
		'AJAX_SHOUTBOX_MESSAGE'          => 'Dodaj wiadomość',
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'Przepraszamy, pisanie wiadomości możliwe jest tylko gdy mamy włączoną obsługę JavaScrip',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'Nie masz odpowiednich uprawnień aby wykonać to polecenie',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'Pusta wiadomość',
		'AJAX_SHOUTBOX_ERROR'            => 'Błąd',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'Nie można usunąć wiadomości',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'Nie można znaleźć wiadomości',

		'AJAXSHOUTBOX_BOARD_DATE_FORMAT'            => 'Mój format daty shoutboxa',
		'AJAXSHOUTBOX_BOARD_DATE_FORMAT_EXPLAIN'    => 'Określ format daty (jedynie dla shoutboxa).',

		'AJAXSHOUTBOX_UNSUPPORTED_STYLE'    => 'Wygląda na to iż używasz stylu nie bazującego na stylu prosilver lub takiego który nie prawidłowo dziedziczy właściwości stylu prosilver.
			<br />Jeśli używasz stylu bazującego na prosilver to upewnij się czy dziedziczy on prawidłowo.
			<br />Jeśli używasz stylu nie bazującego na prosilver to musisz stworzyć odpowiedni szablon dla shoutboxa lub poprosić autora stylu który ożywasz o stworzenie takiego szablonu.
			<br />Nie udzielam wsparcia ze stylami nie bazującymi na prosilver (w tym subsilver2!). Wiadomość ta jest widoczna tylko dla adminów.',
	)
);
