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
			Als je wilt dat je gebruikers gebruik kunnen maken van de iOS en android APPs (Op dit moment in een gesloten beta,
			maar gebruikers kunnen de APP nog steeds gebruik maken als ze toegang hebben tot de BETA. Zie
			<a href="http://www.ajax-shoutbox.com/viewtopic.php?f=2&t=9">hier</a> voor meer informatie), moet je een account
			 aanmaken op <a href="https://www.shoutbox-app.com/">www.shoutbox-app.com</a>. Hierna moet je een nieuw forum toevoegen
			 op de site. Bij dit proces heb je een activatie code nodig. Deze vind je hieronder.
		',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Prune instellingen',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Zet het automatische verwijderen van oude posts aan',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Prune posts na',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Datum formaat',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Standaard datum formaat voor in de shoutbox. Je kan het beste geen gebruik maken van
			relatieve formaten, aangezien de datum niet update wanneer de shoutbox ververst.
		',

		'ACP_AJAXSHOUTBOX_PUSH'         => 'App configuratie',
		'AJAXSHOUTBOX_ACTIVATION_KEY'   => 'Activatie code',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH'  => 'Schakel de android en iOS app in',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH_EXPLAIN'  => 'Voordat je je kan registeren, moet je deze feature eerst inschakelen',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH' => 'API Key',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH_EXPLAIN' => 'Deze key zal je ontvangen wanneer je je forum toevoegt op www.shoutbox-app.com',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH' => 'Connection ID',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH_EXPLAIN' => 'Deze ID zal je ontvangen wanneer je je forum toevoegt op www.shoutbox-app.com.<br />Je gebruikers kunnen dit ID gebruiken om je forum te vinden in de APP.',

		'AJAXSHOUTBOX_PUSH_DISABLED'            => 'Push features uitgeschakeld',
		'AJAXSHOUTBOX_PUSH_DISABLED_EXPLAIN'    => 'De push features zijn, standaard, uitgeschakeld. Wanneer je deze functionaliteit wilt inschakelen voeg je de volgende code toe aan je config.php:',
	)
);
