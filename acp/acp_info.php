<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\acp;


class acp_info {
	function module()
	{
		return array(
			'filename'	=> '\paul999\ajaxshoutbox\acp\acp_module',
			'title'		=> 'ACP_AJAX_SHOUTBOX',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_AJAX_SHOUTBOX_SETTINGS',
					'auth' => 'ext_paul999/ajaxshoutbox && acl_a_board',
					'cat' => array('ACP_BOARD_ANNOUNCEMENTS')
				),
			),
		);
	}
}
