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
		'AJAX_SHOUTBOX_MESSAGE'          => 'Add message',
		'AJAX_SHOUTBOX_ONLY_AJAX'        => 'Sorry, posting in the shoutbox is only supported when JavaScript is enabled',
		'AJAX_SHOUTBOX_NO_PERMISSION'    => 'No permission for the selected action',
		'AJAX_SHOUTBOX_MESSAGE_EMPTY'    => 'Message empty',
		'AJAX_SHOUTBOX_ERROR'            => 'Error',
		'AJAX_SHOUTBOX_MISSING_ID'       => 'Unable to delete post',
		'AJAX_SHOUTBOX_NO_SUCH_POST'     => 'Unable to find post',
		'AJAX_SHOUTBOX_PUSH_NOT_AVAIL'   => 'The remote push server is currently not available',

		'AJAXSHOUTBOX_BOARD_DATE_FORMAT'            => 'My shoutbox date format',
		'AJAXSHOUTBOX_BOARD_DATE_FORMAT_EXPLAIN'    => 'Specify a date format for just the shoutbox. You should not use a relative date format.',
	)
);
