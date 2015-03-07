<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
  * Translated By : Bassel Taha Alhitary - www.alhitary.net
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
		'ACP_AJAXSHOUTBOX_SETTINGS'     => 'اعدادات الدردشة أجاكس',
		'ACP_AJAXSHOUTBOX_SETTINGS_EXPLAIN'     => 'من هنا تستطيع ضبط اعدادات الدردشة أجاكس <br /><br />
			يجب عليك انشاء حساب و إضافة منتداك في الموقع <a href="https://www.shoutbox-app.com/">www.shoutbox-app.com</a> لكي يستطيع الأعضاء لديك من استخدام تطبيق الأندرويد و الـiOS ( حالياً في النسخة بيتا ) 
			<br />بعد ذلك سيتم طلب رمز التفعيل منك ( سيتم اظهار هذا الرمز هنا بالأسفل ).
		',

		'ACP_AJAXSHOUTBOX_PRUNE'        => 'إعدادات التهذيب',
		'AJAXSHOUTBOX_ENABLE_PRUNE'     => 'تفعيل تهذيب المشاركات',
		'AJAXSHOUTBOX_PRUNE_DAYS'       => 'تهذيب المشاركات بعد',

		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT'  => 'Date format',
		'AJAXSHOUTBOX_DEFAULT_DATE_FORMAT_EXPLAIN'  => 'Default date format for the shoutbox. You shouldn’t use the relative dates, the date won’t update on refresh of the shoutbox',

		'ACP_AJAXSHOUTBOX_PUSH'         => 'تهئية التطبيق',
		'AJAXSHOUTBOX_ACTIVATION_KEY'   => 'رمز التفعيل ',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH'  => 'تفعيل تطبيق الأندرويد والـ iOS ',
		'ACP_AJAXSHOUTBOX_ENABLE_PUSH_EXPLAIN'  => 'يجب تفعيل هذا الخيار لكي تستطيع تسجيل موقعك.',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH' => 'مفتاح الـAPI ',
		'ACP_AJAXSHOUTBOX_API_KEY_PUSH_EXPLAIN' => 'سوف تستلم هذا المفتاح بعد إضافة منتداك إلى www.shoutbox-app.com',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH' => 'مفتاح الإتصال ',
		'ACP_AJAXSHOUTBOX_CON_KEY_PUSH_EXPLAIN' => 'سوف تستلم هذا المفتاح بعد إضافة منتداك إلى www.shoutbox-app.com.<br />يجب على أعضاء منتداك استخدام هذا المفتاح للعثور على منتداك في التطبيق.',

		'ACP_AJAXSHOUTBOX_PUSH_DISABLED'            => 'Push functionality disabled',
		'ACP_AJAXSHOUTBOX_PUSH_DISABLED_EXPLAIN'    => 'The Push functionality is, by default, disabled. If you want to use this functionality add the following line to config.php: ',

	)
);
