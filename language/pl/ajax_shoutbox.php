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
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'Niestety, wiadomości są obsługiwane tylko wtedy, gdy włączona jest obsługa JavaScript',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'Brak uprawnień',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'Pusta wiadomość',
		'AJAX_SHOUTBOX_ERROR'            => 'Błąd',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'Nie można usunąć wiadomości',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'Nie można znaleźć wiadomości',
		'AJAX_SHOUTBOX_PUSH_NOT_AVAIL'   => 'Zdalny serwer jest obecnie niedostępny',

		'AJAXSHOUTBOX_BOARD_DATE_FORMAT'            => 'Mój format daty',
		'AJAXSHOUTBOX_BOARD_DATE_FORMAT_EXPLAIN'    => 'Określ format daty tylko dla shoutboxa',

		'AJAXSHOUTBOX_UNSUPPORTED_STYLE'    => 'Wydaje się, że nie używasz stylu opartego na prosilver.
												<br>Jeśli używasz styl oparty na prosilver, upewnij się, że dziedziczenie z prosilver ustawione jest poprawnie.
												<br>Jeśli używany styl nie opiera się na prosilver, trzeba będzie utworzyć odpowiedni szablon lub spytać autora szablonu o taką możliwość.
												<br>Brak wsparcia dla stylów bez dziedziczenia z prosilver. Ten komunikat jest widoczny tylko dla administratorów.',
	)
);
