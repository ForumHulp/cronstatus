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
		global $db, $user, $template, $request, $phpbb_container;

		$action	= $request->variable('action', '');

		switch($mode)
		{
			case 'config':
			$this->page_title = $user->lang['ACP_CRON_STATUS_TITLE'];
			$this->tpl_name = 'acp_cron_status';
			break;
		}
		
		$tasks = array();
		$tasks = $phpbb_container->get('cron.manager')->get_tasks();

		if (empty($tasks))
		{
			$template->assign_vars(array(
				'S_CRON_TASKS'		=> false,
				'U_ACTION'			=> $this->u_action,
			));
			return;
		}

		$sql = 'SELECT * FROM '.CONFIG_TABLE.' WHERE config_name LIKE "%last_gc"';
		$result = $db->sql_query($sql);
		$rows = $db->sql_fetchrowset($result);

		$template->assign_vars(array(
			'S_CRON_TASKS'		=> (sizeof($tasks)) ? true : false,
			'U_ACTION'			=> $this->u_action,
		));

		$not_ready_tasks = array();
		$ready_tasks = array();
		foreach ($tasks as $task)
		{
			$task_name = $task->get_name();
			if(empty($task_name)) continue;
			$task_date = -1;
			$find = strpos($task_name, 'tidy');
			if($find !== false)
			{
				$name = substr($task_name, $find + 5);
				$task_date = (int) $this->array_find($name, $rows);
			}
			else if (strpos($task_name, 'prune_notifications'))
			{
				$task_date = (int) $this->array_find('read_notifications', $rows);
			}
			$template->assign_block_vars(($task->is_ready()) ? 'ready' : 'not_ready', array(
				'DISPLAY_NAME'	=> $task_name,
				'TASK_DATE'		=> ($task_date == -1) ? $user->lang['CRON_TASK_AUTO'] : (($task_date) ? $user->format_date($task_date) : $user->lang['CRON_TASK_NEVER_STARTED']),
			));
		}

		
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
