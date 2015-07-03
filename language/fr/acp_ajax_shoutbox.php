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
// ’ « » “ ” …
//

$lang = array_merge(
	$lang, array(
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'Paramètres de la Shoutbox Ajax',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'Sur cette page vous pouvez modifier les paramètres spécifiques à la shoutbox.<br /><br />
		Si vous voulez permettre à vos utilisateurs l’usage des applications Android et iOS (actuellement en version Bêta fermée mais qui peuvent être utilisées si vos utilisateurs y ont accès. Voir <a href="http://www.ajax-shoutbox.com/viewtopic.php?f=2&t=9">ici</a> pour plus d’informations)
		, vous devez créer un compte sur <a href="https://www.shoutbox-app.com/">www.shoutbox-app.com</a> 
		et ajouter un nouveau forum. Un code d’activation vous sera demandé. Ce code est affiché ci-dessous :',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Paramètres d’archivage',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Activer l’archivage',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Archiver après',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Format de la date',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Format par défaut de la date pour la shoutbox. Vous ne devriez pas utiliser les formats relatifs pour la date, la date ne sera pas mise à jour lors de l’actualisation de la shoutbox.',

		'ACP_AJAXSHOUTBOX_PUSH'         => 'Configuration des applications',
		'AJAXSHOUTBOX_ACTIVATION_KEY'   => 'Code d’activation',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH'  => 'Activer les applications Android et iOS',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH_EXPLAIN'  => 'Vous devez activer cette fonctionnalité avant d’enregistrer votre site.',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH' => 'Clé API',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH_EXPLAIN' => 'Vous recevrez cette clé après avoir ajouté votre forum sur www.shoutbox-app.com.',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH' => 'ID de connection',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH_EXPLAIN' => 'Vous recevrez cette clé après avoir ajouté votre forum sur www.shoutbox-app.com<br />Vos utilisateurs utiliseront cet ID pour trouver votre forum dans l’application mobile.',

		'ACP_AJAXSHOUTBOX_PUSH_DISABLED'            => 'La fonctionnalité Push est désactivée',
		'ACP_AJAXSHOUTBOX_PUSH_DISABLED_EXPLAIN'    => 'La fonctionnalité Push est par défaut désactivée. Si vous souhaitez utiliser cette fonctionnalité, ajoutez la ligne suivante dans le fichier config.php : ',
	)
);
