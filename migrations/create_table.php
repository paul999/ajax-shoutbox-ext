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

class create_table extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array();
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'ajax_shoutbox' => array(
					'COLUMNS'     => array(
						'shout_id'        => array('UINT', null, 'auto_increment'),
						'user_id'         => array('UINT', 0),
						'post_time'       => array('TIMESTAMP', 0),
						'bbcode_bitfield' => array('VCHAR:255', ''),
						'bbcode_uid'      => array('VCHAR:8', ''),
						'post_message'    => array('MTEXT_UNI', ''),
					),
					'PRIMARY_KEY' => 'shout_id',
					'KEYS'        => array(
						'u_id' => array('INDEX', 'user_id'),
					)
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'ajax_shoutbox',
			),
		);
	}
}
