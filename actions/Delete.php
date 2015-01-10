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

class Delete
{
	/** @var \phpbb\config\config  */
	private $config;

	/** @var \phpbb\db\driver\driver_interface  */
	private $db;

	/** @var \phpbb\auth\auth  */
	private $auth;

	/** @var \phpbb\log\log  */
	private $log;

	/** @var string */
	private $string;
	/**
	 * @param \phpbb\config\config              $config
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\auth\auth                  $auth
	 * @param \phpbb\log\log                    $log
	 * @param string                            $table
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\auth\auth $auth, \phpbb\log\log $log, $table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
		$this->log = $log;
		$this->table = $table;
	}

	/**
	 * Delete a shoutbox post
	 *
	 * @param int $id
	 */
	public function delete($id) {

	}
}
