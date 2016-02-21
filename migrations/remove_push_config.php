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

class remove_push_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\paul999\ajaxshoutbox\migrations\add_push_config',
			'\paul999\ajaxshoutbox\migrations\add_push_config2',
			'\paul999\ajaxshoutbox\migrations\update_push_config'
		);
	}

	public function revert_data()
	{
		return array(
			array('config.add', array('ajaxshoutbox_validation_id', uniqid())),
			array('config.add', array('ajaxshoutbox_push_enabled', false)),
			array('config.add', array('ajaxshoutbox_api_key', '')),
			array('config.add', array('ajaxshoutbox_connection_key', '')),

			array('config.add', array('ajaxshoutbox_api_server', 'https://www.shoutbox-app.com/post')), // We can't use the API.
			array('config.add', array('ajaxshoutbox_ssl_key', '')),
		);
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('ajaxshoutbox_validation_id')),
			array('config.remove', array('ajaxshoutbox_push_enabled')),
			array('config.remove', array('ajaxshoutbox_api_key')),
			array('config.remove', array('ajaxshoutbox_connection_key')),

			array('config.remove', array('ajaxshoutbox_api_server')),
			array('config.remove', array('ajaxshoutbox_ssl_key')),
		);
	}
}
