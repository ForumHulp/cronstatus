<?php
/**
*
* @package Cron_status
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cron_status\acp;

class cron_status_module
{
	public $u_action;
	function main($id, $mode)
	{
		global $db, $config, $user, $template, $request, $phpbb_container;

		$this->page_title = $user->lang['ACP_CRON_STATUS_TITLE'];
		$this->tpl_name = 'acp_cron_status';
		// Refreshing the page every 60 seconds...
		meta_refresh(60, $this->u_action);

		$tasks = array();
		$tasks = $phpbb_container->get('cron.manager')->get_tasks();

		if (sizeof($tasks))
		{
			$sql = 'SELECT config_name, config_value FROM '.CONFIG_TABLE.' WHERE config_name LIKE "%gc" OR config_name LIKE "%queue%"';
			$result = $db->sql_query($sql);
			$rows = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);
			
			$sql = 'SELECT prune_next, prune_days * 86400 AS prune_time FROM ' . FORUMS_TABLE . ' WHERE enable_prune = 1 ORDER BY prune_next';
			$result = $db->sql_query_limit($sql, 1);
			$prune = $db->sql_fetchrow($result);
			$rows[] = array(
				"config_name"	=> "prune_forum_last_gc",
				"config_value"	=> $prune['prune_next']
			);
			$rows[] = array(
				"config_name"	=> "prune_forum_gc",
				"config_value"	=> $prune['prune_time']
			);
			$db->sql_freeresult($result);
			
			$sql = 'SELECT prune_shadow_next, prune_shadow_days * 86400 AS prune_shadow_time FROM ' . FORUMS_TABLE . ' WHERE enable_shadow_prune = 1 ORDER BY prune_shadow_next';
			$result = $db->sql_query_limit($sql, 1);
			$prune_shadow = $db->sql_fetchrow($result);
			$rows[] = array(
				"config_name"	=> "prune_shadow_topics_last_gc",
				"config_value"	=> $prune_shadow['prune_shadow_next']
			);
			$rows[] = array(
				"config_name"	=> "prune_shadow_topics_gc",
				"config_value"	=> $prune_shadow['prune_shadow_time']
			);			
			$db->sql_freeresult($result);

			if ($config['cron_lock'])
			{
				$cronlock = $this->maxValueInArray($rows, 'config_value');
				$cronlock = str_replace(array('_last_gc', 'prune_notification', 'last_queue_run'), array('', 'read_notifications', 'queue_interval'), $cronlock['config_name']);
			}

			foreach ($tasks as $task)
			{
				$task_name = $task->get_name();
				if(empty($task_name)) continue;
				
				$task_date = -1;
				$find = strpos($task_name, 'tidy');
				if($find !== false)
				{
					$name = substr($task_name, $find + 5);
					$name = ($name == 'sessions') ? 'session' : $name;
					$task_date = (int) $this->array_find($name . '_last_gc', $rows);
				}
				else if (strpos($task_name, 'prune_notifications'))
				{
					$task_date = (int) $this->array_find('read_notification_last_gc', $rows);
					$name = 'read_notification';
				}
				else if (strpos($task_name, 'queue'))
				{
					$task_date = (int) $this->array_find('last_queue_run', $rows);
					$name = 'queue_interval';
				} else
				{
					$name = substr($task_name, 15) ;
					$task_date = (int) $this->array_find($name . '_last_gc', $rows);
				}
				
				$template->assign_block_vars(($task->is_ready()) ? 'ready' : 'not_ready', array(
					'DISPLAY_NAME'	=> $task_name,
					'TASK_DATE'		=> ($task_date == -1) ? $user->lang['CRON_TASK_AUTO'] : (($task_date) ? 
										$user->format_date($task_date, $config['cron_status_dateformat']) : $user->lang['CRON_TASK_NEVER_STARTED']),
					'NEW_DATE'		=> (($task_date > 0 && $name != 'queue_interval') || ($name == 'queue_interval' && $task->is_ready())) ? 
										$user->format_date(($task_date + $this->array_find($name, $rows)), $config['cron_status_dateformat']) : '',
					'TASK_OK'		=> ($task_date > 0 && ($task_date + $this->array_find($name, $rows) > time()) || ($name == 'queue_interval' && !$task->is_ready())) ? false : true,
					'LOCKED'		=> ($config['cron_lock'] && $cronlock == $name) ? true : false,
				));
			}
		}
	}

	public function maxValueInArray($array, $keyToSearch)
	{
		$currentMax = NULL;
		foreach($array as $arr)
		{
			foreach($arr as $key => $value)
			{
				if ($key == $keyToSearch && ($value >= $currentMax))
				{
					$currentMax = $value;
					$currentName = $arr['config_name'];
				}
			}
		}
		return array('config_name' => $currentName , 'config_value' => $currentMax);
	}

	// array_search with partial matches
	public function array_find($needle, $haystack) 
	{
		if(!is_array($haystack)) return false;
		foreach ($haystack as $key => $item) 
		{
			if (strpos($item['config_name'], $needle) !== false) return $haystack[$key]['config_value'];
		}
		return false;
	}
}
