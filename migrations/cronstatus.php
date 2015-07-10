<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cronstatus\migrations;

class cronstatus extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('cronstatus_dateformat', '|d M Y|, H:i')),
			array('config.add', array('cronstatus_main_notice', 'true')),
			array('config.add', array('cronstatus_default_sort', 'display_name|a')),
			array('module.add', array('acp', 'ACP_CAT_MAINTENANCE', 'ACP_CRON_STATUS_TITLE')),
			array('module.add', array(
				'acp', 'ACP_CRON_STATUS_TITLE', array(
					'module_basename'	=> '\forumhulp\cronstatus\acp\cronstatus_module',
					'auth'				=> 'ext_forumhulp/cronstatus',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
