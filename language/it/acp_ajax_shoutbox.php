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
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'Impostazioni bacheca AJAX',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'In questa pagina, è possibile cambiare le impostazioni specifiche per la bacheca.<br />
			<br />Per abilitare gli utenti all’uso delle applicazioni per iOS e Android (al momento in fase BETA privata ma utilizzabile 
			da chi abbia accesso alla beta, leggere <a href="http://www.ajax-shoutbox.com/viewtopic.php?f=2&t=9">qui</a> per ulteriori informazioni), 
			è necessario creare un profilo su <a href="https://www.shoutbox-app.com/">www.shoutbox-app.com</a> ed aggiungere un nuovo forum. Sarà 
			richiesto un codice di attivazione, mostrato qui in basso.',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Impostazioni cancellazione automatica',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Abilita cancellazione automatica dei messaggi',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Cancella automaticamente messaggi più vecchi di',
	)
);
