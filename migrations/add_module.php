<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace paul999\ajaxshoutbox\migrations;

use phpbb\db\migration\migration;

class add_module extends migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_AJAX_SHOUTBOX')),
			array('module.add', array(
				'acp', 'ACP_AJAX_SHOUTBOX', array(
					'module_basename'	=> '\paul999\ajaxshoutbox\acp\acp_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
