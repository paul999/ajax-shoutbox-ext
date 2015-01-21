<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 * Translated By : Basil Taha Alhitary - www.alhitary.net
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
		'AJAX_SHOUTBOX'                  => 'الدردشة أجاكس',
		'AJAX_SHOUTBOX_MESSAGE'          => 'ارسل رسالتك',
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'المعذرة , يجب تفعيل الجافا سكربت لكي تعمل هذه الدردشة.',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'لا توجد صلاحية لتنفيذ هذا الأمر',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'الرسالة فارغة',
		'AJAX_SHOUTBOX_ERROR'            => 'خطأ',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'لا يُمكن حذف المشاركة',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'لا يُمكن العثور على المشاركة',
		'AJAX_SHOUTBOX_PUSH_NOT_AVAIL'   => 'الخدمة عير متوفرة حالياً',
	)
);
