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

class add_push_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array();
	}

	public function update_data()
	{
		return array(
			array('config.add', array('ajaxshoutbox_validation_id', uniqid())),
			array('config.add', array('ajaxshoutbox_push_enabled', false)),
			array('config.add', array('ajaxshoutbox_api_key', '')),
			array('config.add', array('ajaxshoutbox_connection_key', '')),
		);
	}
}
