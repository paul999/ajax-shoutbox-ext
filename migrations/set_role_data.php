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

class set_role_data extends migration
{
	public function update_data()
	{
		$data = array();

		if ($this->role_exists('ROLE_MOD_FULL')) {
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_shoutbox_delete'));
		}
		if ($this->role_exists('ROLE_MOD_STANDARD')) {
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_shoutbox_delete'));
		}

		if ($this->role_exists('ROLE_FORUM_FULL')) {
			$data[] = array('permission.permission_set', array('ROLE_FORUM_FULL', 'u_shoutbox_view'));
			$data[] = array('permission.permission_set', array('ROLE_FORUM_FULL', 'u_shoutbox_post'));
			$data[] = array('permission.permission_set', array('ROLE_FORUM_FULL', 'u_shoutbox_bbcode'));
			$data[] = array('permission.permission_set', array('ROLE_FORUM_FULL', 'u_shoutbox_delete'));
		}

		if ($this->role_exists('ROLE_FORUM_STANDARD')) {
			$data[] = array('permission.permission_set', array('ROLE_FORUM_STANDARD', 'u_shoutbox_view'));
			$data[] = array('permission.permission_set', array('ROLE_FORUM_STANDARD', 'u_shoutbox_post'));
			$data[] = array('permission.permission_set', array('ROLE_FORUM_STANDARD', 'u_shoutbox_bbcode'));
		}

		return $data;
	}

	/**
	 * Checks whether the given role does exist or not.
	 *
	 * @param String $role the name of the role
	 * @return true if the role exists, false otherwise.
	 */
	protected function role_exists($role)
	{
		$sql = 'SELECT role_id
        FROM ' . ACL_ROLES_TABLE . "
        WHERE role_name = '" . $this->db->sql_escape($role) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$role_id = $this->db->sql_fetchfield('role_id');
		$this->db->sql_freeresult($result);
		return $role_id;
	}
}
