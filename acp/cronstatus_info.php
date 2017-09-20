<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cronstatus\acp;

class cronstatus_info
{
	function module()
	{
		return array(
			'filename'		=> 'forumhulp\cronstatus\acp\cronstatus_module',
			'title'			=> 'ACP_CRON_STATUS_TITLE',
			'version'		=> '1.0.0',
			'modes'			=> array(
				'config'	=> array('title' => 'ACP_CRON_STATUS_TITLE', 'auth' => 'ext_forumhulp/cronstatus', 'cat' => array('ACP_CAT_MAINTENANCE')
				),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
