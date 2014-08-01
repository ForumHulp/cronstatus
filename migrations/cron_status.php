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
			array('config.add', array('cron_status_version', '3.1.0')),
			array('config.add', array('cron_status_dateformat', '|d M Y|, H:i')),
			array('config.add', array('cron_status_main_notice', 'true')),
			array('module.add', array('acp', 'ACP_CAT_MAINTENANCE', 'ACP_CRON_STATUS_TITLE')),
			array('module.add', array(
				'acp', 'ACP_CRON_STATUS_TITLE', array(
					'module_basename'	=> '\forumhulp\cron_status\acp\cron_status_module',
					'auth'				=> 'ext_forumhulp/cron_status',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
