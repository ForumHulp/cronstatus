<?php
/**
*
* @package Cron_status
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cron_status\migrations;

class cron_status extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['cron_status_version']) && version_compare($this->config['cron_status_version'], '3.1.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('cron_status_version', '3.1.0'))
		);
	}
}