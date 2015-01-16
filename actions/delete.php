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

class delete
{
	/** @var \phpbb\config\config  */
	private $config;

	/** @var \phpbb\db\driver\driver_interface  */
	private $db;

	/** @var \phpbb\auth\auth  */
	private $auth;

	/** @var \phpbb\log\log  */
	private $log;

	/** @var \phpbb\request\request  */
	private $request;

	/** @var \paul999\ajaxshoutbox\actions\Push  */
	private $push;

	/** @var string */
	private $table;
	/**
	 * @param \phpbb\config\config              $config
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\auth\auth                  $auth
	 * @param \phpbb\log\log                    $log
	 * @param string                            $table
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\auth\auth $auth, \phpbb\log\log $log, \phpbb\request\request $request,
								\paul999\ajaxshoutbox\actions\Push $push, $table)
	{
		$this->config   = $config;
		$this->db       = $db;
		$this->auth     = $auth;
		$this->log      = $log;
		$this->request  = $request;
		$this->push     = $push;
		$this->table    = $table;
	}

	/**
	 * Delete a shoutbox post
	 *
	 * @param int $id
	 */
	public function delete_post($id)
	{
		if (!$id)
		{
			$id = $this->request->variable('id', 0);
		}
		$sql = 'DELETE FROM ' . $this->table .' WHERE shout_id =  ' . (int)$id;
		$this->db->sql_query($sql);

		if ($this->push->canPush())
		{
			$this->push->delete($id);
		}
	}
}
