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

class update_push_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\paul999\ajaxshoutbox\migrations\add_push_config2',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('ajaxshoutbox_api_server', 'https://www.shoutbox-app.com/')),
		);
	}
}
