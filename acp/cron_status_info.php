<?php
/**
*
* @package Cron_status
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cron_status\acp;

class cron_status_info
{
    function module()
    {
        return array(
            'filename'    => 'forumhulp\cron_status\acp\cron_status_info',
            'title'        => 'ACP_CRON_STATUS_TITLE',
            'version'    => '1.0.0',
            'modes'        => array(
                'config'		=> array(
            								'title' => 'ACP_CRON_STATUS_CONFIG_TITLE',
            								'auth' => 'ext_forumhulp/cron_status',
            								'cat' => array('ACP_CAT_MAINTENANCE')
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
