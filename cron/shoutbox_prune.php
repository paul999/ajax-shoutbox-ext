<?php
/**
 *
 * Ajax Shoutbox extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 Paul Sohier <http://www.ajax-shoutbox.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paul999\ajaxshoutbox\cron;


class shoutbox_prune extends \phpbb\cron\task\base {

	/** @var \phpbb\config\config  */
	private $config;

	/** @var \phpbb\db\driver\driver_interface  */
	private $db;

	/** @var \paul999\ajaxshoutbox\actions\push  */
	private $push;

	/** @var string  */
	private $table;

	/** @var \phpbb\log\log  */
	private $log;

	/** @var \phpbb\user */
	private $user;

	/**
	 * @param \phpbb\config\config               $config
	 * @param \phpbb\db\driver\driver_interface  $db
	 * @param \phpbb\log\log                     $log
	 * @param \phpbb\user                        $user
	 * @param \paul999\ajaxshoutbox\actions\push $push
	 * @param                                    $table
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\phpbb\log\log $log, \phpbb\user $user, \paul999\ajaxshoutbox\actions\push $push, $table)
	{
		$this->config   = $config;
		$this->push     = $push;
		$this->db       = $db;
		$this->log      = $log;
		$this->table    = $table;
		$this->user     = $user;
	}

	/**
	 * Run the cronjob.
	 */
	public function run()
	{
		$time = strtotime('- ' . (int) $this->config['ajaxshoutbox_prune_days']  . ' days');
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE post_time <= ' . (int) $time;

		$result = $this->db->sql_query($sql);
		$canpush = $this->push->canPush();
		$delete = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($canpush)
			{
				if ($this->push->delete($row['shout_id']) !== false)
				{
					$delete[] = $row['shout_id'];
				}
			}
			else
			{
				$delete[] = $row['shout_id'];
			}
		}
		$this->db->sql_freeresult();

		if (sizeof($delete))
		{
			$sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->db->sql_in_set('shout_id', $delete);
			$this->db->sql_query($sql);
			$uuid = $this->user->data['user_id'];

			if (!$uuid)
			{
				$uuid = ANONYMOUS; // the log interface doesn't fall back to ANONYMOUS as the add_log function did...
			}

			$this->log->add('admin', $uuid, $this->user->ip, 'LOG_AJAX_SHOUTBOX_PRUNED', time(), array(sizeof($delete)));
		}

		$this->config->set('shoutbox_prune_gc', time(), false);
	}

	/**
	 * Should this cron run?
	 * @return bool
	 */
	public function is_runnable()
	{
		return (bool) $this->config['ajaxshoutbox_enable_prune'];
	}

	/**
	 * @return bool
	 */
	public function should_run()
	{
		return (int) $this->config['shoutbox_prune_gc'] < strtotime('24 hours ago');
	}
}
