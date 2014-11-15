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

class update_table extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\paul999\ajaxshoutbox\migrations\create_table');
	}

	public function update_schema()
	{
		return array(
			'add_columns'        => array(
				$this->table_prefix . 'ajax_shoutbox' => array(
					'bbcode_options'    => array('UINT', 0, 'after' => 'bbcode_uid'),
				),
			)
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'ajax_shoutbox' => array(
					'bbcode_options',
				)
			),
		);
	}
}
