<?php
/**
*
* @package Cron_status
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
        exit;
}

if (empty($lang) || !is_array($lang))
{
        $lang = array();
}

$lang = array_merge($lang, array(
    'CRON_STATUS'					=> 'Cron Locked',
	'ACP_CRON_STATUS_TITLE'			=> 'Cron status',
	'ACP_CRON_STATUS_CONFIG_TITLE'	=> 'Check cron status',
	'CRON_STATUS_READY_TASKS'		=> 'Ready tasks',
	'CRON_STATUS_NOT_READY_TASKS'	=> 'Not ready tasks',
	'CRON_STATUS_NO_TASKS'			=> 'No available cron tasks',
));