<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
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
	'CRON'								=> 'Cron',
	'CRON_LOCKED'						=> 'Cron Locked',
	'CRON_TIME_LOCKED'					=> 'Cron time locked',
	'ACP_CRON_STATUS_TITLE'				=> 'Cron Status',
	'ACP_CRON_STATUS_EXPLAIN'			=> 'Cron Status presents a overview of cron tasks in your board. A red marked task means a task which never started which has a problem. A red lock means this task running now or, is locked by cron manager and blocks other tasks. Reset the cronlock by clicking on the lock.<br />Run a ready to run task by click on run next to the taskname. Configure Cron Status in General » Board configuration » Board settings.',
	'CRON_STATUS_REFRESH'				=> 'Seconds for refresh',
	'CRON_TASK_LOCKED'					=> 'Cron task locked, unlock it!',
	'CRON_STATUS_READY_TASKS'			=> 'Tasks ready to run',
	'CRON_STATUS_NOT_READY_TASKS'		=> 'Not ready to run tasks',
	'CRON_STATUS_NO_TASKS'				=> 'No available cron tasks',
	'CRON_STATUS_DATE_FORMAT'			=> 'Date format for Cron Status page',
	'CRON_STATUS_DATE_FORMAT_EXPLAIN'	=> 'The date format is the same as the PHP <code>date</code> function.',
	'CRON_STATUS_MAIN_NOTICE'			=> 'Notice on the ACP index page',
	'CRON_STATUS_MAIN_NOTICE_EXPLAIN'	=> 'Display Cron Status Notice on the ACP index page if Cron is locked.',
	'CRON_TASK_NAME'					=> 'Task name',
	'CRON_TASK_DATE'					=> 'Planned / Last task date',
	'CRON_NEW_DATE'						=> 'Run / New task date',
	'CRON_TASK_NEVER_STARTED'			=> 'Never started',
	'CRON_TASK_AUTO'					=> 'Auto',
	'CRON_TASK_DATE_TIME'				=> 'Current date & time',
	'CRON_STATUS_ERROR'					=> 'Refresh error',
	'CRON_STATUS_TIMEOUT'				=> 'Refresh timeout',
	'CRON_STATUS_ERROR_EXPLAIN'			=> 'An error occurred during refreshing the page.',
	'CRON_TASK_RUN'						=> 'Run',
	'CRON_TASK_RUNNING'					=> 'Running...',
));
