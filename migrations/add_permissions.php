<?php

namespace paul999\ajaxshoutbox\migrations;


use phpbb\db\migration\migration;

class add_permissions extends migration {
	public function update_data()
	{
		return array(
			array('permission.add', array('u_shoutbox_view')),
			array('permission.add', array('u_shoutbox_post')),
			array('permission.add', array('u_shoutbox_quote')),
			array('permission.add', array('u_shoutbox_bbcode')),
			array('permission.add', array('u_shoutbox_delete')),
			array('permission.add', array('m_shoutbox_delete')),
			array('permission.add', array('m_shoutbox_edit')),


		);
	}
} 
