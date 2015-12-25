<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\actions;

use paul999\ajaxshoutbox\exceptions\shoutbox_exception;

class delete
{
	/** @var \phpbb\config\config  */
	private $config;

	/** @var \phpbb\db\driver\driver_interface  */
	private $db;

	/** @var \phpbb\auth\auth  */
	private $auth;

	/** @var \phpbb\request\request  */
	private $request;

	/** @var \phpbb\user  */
	private $user;

	/** @var string */
	private $table;

	/**
	 * @param \phpbb\config\config               $config
	 * @param \phpbb\db\driver\driver_interface  $db
	 * @param \phpbb\auth\auth                   $auth
	 * @param \phpbb\request\request             $request
	 * @param \phpbb\user                        $user
	 * @param string                             $table
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\auth\auth $auth, \phpbb\request\request $request,
								\phpbb\user $user, $table)
	{
		$this->config   = $config;
		$this->db       = $db;
		$this->auth     = $auth;
		$this->request  = $request;
		$this->user     = $user;
		$this->table    = $table;
	}

	/**
	 * Delete a shoutbox post
	 *
	 * If push is enabled, we first make sure it is deleted on the server.
	 * When we delete first here, we have a problem when the server fails.
	 *
	 * @param int $id
	 *
	 * @throws \paul999\ajaxshoutbox\exceptions\shoutbox_exception
	 */
	public function delete_post($id)
	{
		if (!$id)
		{
			$id = $this->request->variable('id', 0);
		}
		$sql = 'SELECT user_id
					FROM ' . $this->table . '
					WHERE shout_id = ' . (int) $id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow();
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			throw new shoutbox_exception('AJAX_SHOUTBOX_NO_SUCH_POST');
		}
		if (!$this->auth->acl_get('m_shoutbox_delete'))
		{
			// User has no m_ permission.

			if ($row['user_id'] != $this->user->data['user_id'])
			{
				throw new shoutbox_exception('AJAX_SHOUTBOX_NO_SUCH_POST');
			}
			if (!$this->auth->acl_get('u_shoutbox_delete'))
			{
				throw new shoutbox_exception('AJAX_SHOUTBOX_NO_PERMISSION');
			}
		}

		$sql = 'DELETE FROM ' . $this->table .'
					WHERE shout_id =  ' . (int) $id;
		$this->db->sql_query($sql);
	}
}
