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

	/** @var \paul999\ajaxshoutbox\actions\delete  */
	private $delete;

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db,
								\paul999\ajaxshoutbox\actions\delete $delete)
	{
		$this->config   = $config;
		$this->delete   = $delete;
		$this->db       = $db;
	}

	/**
	 * Run the cronjob.
	 */
	public function run()
	{
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
		return $this->config['shoutbox_prune_gc'] < strtotime('24 hours ago');
	}
}
