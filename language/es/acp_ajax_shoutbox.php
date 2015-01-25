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
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'Ajustes de Ajax Shoutbox',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'En esta página usted puede cambiar los ajustes específicos para el Cuadro de Charla. <br /><br />
			Si desea permitir a los usuarios utilizar los iOS y Android (actualmente en beta cerrada, sin embargo los usuarios pueden seguir utilizando con
			su foro si tienen acceso a la beta.
			Vea <a href="http://www.ajax-shoutbox.com/viewtopic.php?f=2&t=9">aquí</a> para más información), es necesario crear una cuenta en
			<a href="https://www.shoutbox-app.com/">www.shoutbox-app.com</a> y añadir un nuevo foro. Se le pedirá un código de activación. Este código aparece más abajo.
		',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'Purgar ajustes',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'Habilitar purgado de mensajes',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'Purgar mensajes después',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Date format',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Default date format for the shoutbox. You shouldn’t use the relative dates, the date won’t update on refresh of the shoutbox',

		'ACP_AJAXSHOUTBOX_PUSH'         => 'Configuración de App',
		'AJAXSHOUTBOX_ACTIVATION_KEY'   => 'Código de activación',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH'  => 'Habilitar iOS y Android App',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH_EXPLAIN'  => 'Antes de poder registrar su sitio, necesita habilitar esta característica.',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH' => 'Clave API',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH_EXPLAIN' => 'Usted recibirá esta clave después de añadir su foro en www.shoutbox-app.com',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH' => 'ID de conexión',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH_EXPLAIN' => 'Usted recibirá esta clave después de añadir su foro en www.shoutbox-app.com.<br />Sus usuarios utilizarán este ID para encontrar su foro en la App.',

		'AJAXSHOUTBOX_PUSH_DISABLED'            => 'Push functionality disabled',
		'AJAXSHOUTBOX_PUSH_DISABLED_EXPLAIN'    => 'The Push functionality is, by default, disabled. If you want to use this functionality add the following line to config.php: ',
	)
);
