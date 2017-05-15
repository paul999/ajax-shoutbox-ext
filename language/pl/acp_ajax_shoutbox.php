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
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'Ustawienia Ajax Shoutboxa',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'Na tej stronie można zmienić ustawienia specyficzne dla shoutboxa.<br>Jeśli chcesz umożliwić użytkownikom korzystanie z iOS i Android, należy utworzyć konto na <a href="https://www.shoutbox-app.com/"> www.shoutbox-app.com</a> i dodać nowe forum. Zostaniesz poproszony o podanie kodu aktywacyjnego. Ten kod jest wyświetlany poniżej.',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Ustawienia czyszczenia',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Włącz czyszczenie shoutboxa',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Czyść posty po',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Format daty',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Ustaw domyślny format daty.',

		'ACP_AJAXSHOUTBOX_PUSH'         => 'Konfiguracja shoutboxa',
		'AJAXSHOUTBOX_ACTIVATION_KEY'   => 'Kod aktywacyjny',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH'  => 'Włącz aplikację Android i iOS',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH_EXPLAIN'  => 'Zanim będzie można zarejestrować swoją witrynę, należy włączyć tę funkcję.',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH' => 'Klucz API',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH_EXPLAIN' => 'Otrzymasz ten kod po dodaniu forum na www.shoutbox-app.com.',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH' => 'ID połączenia',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH_EXPLAIN' => 'Otrzymasz ten kod po dodaniu forum na www.shoutbox-app.com.<br>Kod będzie potrzebny użytkownikom, aby mogli znaleźć twoje forum w aplikacji.',

		'ACP_AJAXSHOUTBOX_PUSH_DISABLED'            => 'Funkcje wyłączone',
		'ACP_AJAXSHOUTBOX_PUSH_DISABLED_EXPLAIN'    => 'Aby odblokować konfiguracje rozszerzenia, musisz dodać następującą linię do config.php: ',
	)
);
