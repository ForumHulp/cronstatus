<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cronstatus\acp;

class cronstatus_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $db, $config, $user, $cache, $template, $request, $phpbb_root_path, $phpEx, $phpbb_container, $phpbb_dispatcher;

		$this->page_title = $user->lang['ACP_CRON_STATUS_TITLE'];
		$this->tpl_name = 'acp_cronstatus';
		$user->add_lang_ext('forumhulp/cronstatus', 'cronstatus');
		$action = $request->variable('action', '');

		list($sk_config, $sd_config) = explode('|', $config['cronstatus_default_sort']);

		$sk = $request->variable('sk', $sk_config);
		$sd = $request->variable('sd', $sd_config);

		if ($sk != $sk_config || $sd != $sd_config)
		{
			$config->set("cronstatus_default_sort", $sk . '|' . $sd);
		}

		switch ($action)
		{
			case 'details':
				$user->add_lang_ext('forumhulp/cronstatus', 'info_acp_cronstatus');
				$phpbb_container->get('forumhulp.helper')->detail('forumhulp/cronstatus');
				$this->tpl_name = 'acp_ext_details';
			break;

			case 'runnow':
				$cron_type = $request->variable('cron_type', '');
				$find = strpos($cron_type, 'tidy');
				if ($find !== false)
				{
					$name = substr($cron_type, $find + 5);
					$name = ($name == 'sessions') ? 'session' : $name . '_last_gc';
				} else if (strpos($cron_type, 'prune_notifications'))
				{
					$name = 'read_notification_last_gc';
				} else if (strpos($cron_type, 'queue'))
				{
					$name = 'last_queue_run';
				} else
				{
					$name = (strrpos($cron_type, ".") !== false) ? substr($cron_type, strrpos($cron_type, ".") + 1) : $cron_type;
					$name = $name . '_last_gc';
				}

				$config->set($name, 12/*time()*/);
				exit();
			break;

			case 'reset':
				$config->set('cron_lock', 0);

			default:
			$view_table = $request->variable('table', false);
			$cron_type = $request->variable('cron_type', '');

			if (!($request->is_ajax()) && $cron_type)
			{
				$url = append_sid($phpbb_root_path . 'cron.' . $phpEx, 'cron_type=' . $cron_type);
				$template->assign_var('RUN_CRON_TASK', '<img src="' . $url . '" width="1" height="1" alt="" />');
				meta_refresh(60, $this->u_action . '&amp;sk=' . $sk . '&amp;sd='. $sd);
			}

			$tasks = $task_array = array();
			$tasks = $phpbb_container->get('cron.manager')->get_tasks();

			$rows = $phpbb_container->get('forumhulp.cronstatus.listener')->get_cron_tasks($cronlock);
			if (sizeof($tasks) && is_array($rows))
			{
				foreach ($tasks as $task)
				{
					$task_name = $task->get_name();
					if (empty($task_name))
					{
						continue;
					}

					$task_date = -1;
					$find = strpos($task_name, 'tidy');
					if ($find !== false)
					{
						$name = substr($task_name, $find + 5);
						$name = ($name == 'sessions') ? 'session' : $name;
						$task_date = (int) $this->array_find($name . '_last_gc', $rows);
					} else if (strpos($task_name, 'prune_notifications'))
					{
						$task_date = (int) $this->array_find('read_notification_last_gc', $rows);
						$name = 'read_notification';
					} else if (strpos($task_name, 'queue'))
					{
						$task_date = (int) $this->array_find('last_queue_run', $rows);
						$name = 'queue_interval';
					} else if (strpos($task_name, 'text_reparser'))
					{
						$task_date = (int) $this->array_find(str_replace('cron.task.', '', $task_name) . '_last_cron', $rows);
						$name = $task_name;
					} else if (strpos($task_name, 'update_hashes'))
					{
						$task_date = (int) $this->array_find(str_replace('cron.task.core.', '', $task_name) . '_last_cron', $rows);
						$name = $task_name;
					} else
					{
						$name = (strrpos($task_name, ".") !== false) ? substr($task_name, strrpos($task_name, ".") + 1) : $task_name;
						$task_last_gc = $this->array_find($name . '_last_gc', $rows);
						$task_date = ($task_last_gc !== false) ? (int) $task_last_gc : 0;
					}

					$new_task_interval = ($task_date > 0) ? $this->array_find($name . (($name != 'queue_interval') ? '_gc': ''), $rows) : 0;
					$new_task_interval = ($task_date > 0) ? $this->array_find(str_replace('cron.task.', '', $name) . (($name == 'text_reparser') ? '_cron_interval': ''), $rows) : 0;
					$new_task_date = ($new_task_interval > 0) ? $task_date + $new_task_interval : 0;

					/**
					* Event to modify task variables before displaying cron information
					*
					* @event forumhulp.cronstatus.modify_cron_task
					* @var	object	task			Task object
					* @var	object	task_name		Task name ($task->get_name())
					* @var	object	name			Task name for new task date
					* @var	object	task_date		Last task date
					* @var	object	new_task_date	Next task date
					* @since 3.1.0-RC3
					* @changed 3.1.1 Added new_task_date variable
					*/
					$vars = array('task', 'task_name', 'name', 'task_date', 'new_task_date');
					extract($phpbb_dispatcher->trigger_event('forumhulp.cronstatus.modify_cron_task', compact($vars)));

					$task_array[] = array(
						'task_sort'			=> ($task->is_ready()) ? 'ready' : (($task_date) ? 'not_ready' : 'never_started'),
						'display_name'		=> $task_name,
						'task_date'			=> $task_date,
						'task_date_print'	=> ($task_date == -1) ? $user->lang['CRON_TASK_AUTO'] : (($task_date) ?
												$user->format_date($task_date, $config['cronstatus_dateformat']) : $user->lang['CRON_TASK_NEVER_STARTED']),
						'new_date'			=> $new_task_date,
						'new_date_print'	=> ($new_task_date > 0 && ($name != 'queue_interval' && $name != 'plupload')) ?
												$user->format_date($new_task_date, $config['cronstatus_dateformat']) : '-',
						'task_ok'			=> ($task_date > 0 && ($new_task_date > time() || ($name == 'queue_interval' || $name == 'plupload'))) ? false : true,
						'locked'			=> ($config['cron_lock'] && $cronlock == $task_name) ? true : false,
					);
				}
				unset($tasks, $rows);

				$task_array = $this->array_sort($task_array, $sk, (($sd == 'a') ? SORT_ASC : SORT_DESC));

				foreach ($task_array as $row)
				{
					$template->assign_block_vars($row['task_sort'], array(
						'DISPLAY_NAME'	=> $row['display_name'],
						'TASK_DATE'		=> $row['task_date_print'],
						'NEW_DATE'		=> $row['new_date_print'],
						'TASK_OK'		=> $row['task_ok'],
						'LOCKED'		=> $row['locked'],
						'CRON_TASK_RUN'	=> ($request->is_ajax()) ? '' : (($row['display_name'] != $cron_type) ? '<a href="' . $this->u_action . '&amp;cron_type=' . $row['display_name'] . '&amp;sk=' . $sk . '&amp;sd='. $sd . '" class="cron_run_link">'.$user->lang['CRON_TASK_RUN'].'</a>' : '<span class="cron_running_update">'.$user->lang['CRON_TASK_RUNNING'].'</span>'),
					));
				}
			}
			$cron_url = append_sid($phpbb_root_path . 'cron.' . $phpEx, false, false); // This is used in JavaScript (no &amp;).
			$template->assign_vars(array(
				'U_ACTION'		=> $this->u_action,
				'U_NAME'		=> $sk,
				'U_SORT'		=> $sd,
				'CRON_URL'		=> (!$config['cron_lock']) ? addslashes($cron_url) : '',
				'U_UNLOCK'		=> $this->u_action,
				'VIEW_TABLE'	=> $view_table
			));
		}
	}


	function array_sort($array, $on, $order = SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (sizeof($array) > 0)
		{
			foreach ($array as $k => $v)
			{
				if (is_array($v))
				{
					foreach ($v as $k2 => $v2)
					{
						if ($k2 == $on)
						{
							$sortable_array[$k] = $v2;
						}
					}
				} else
				{
					$sortable_array[$k] = $v;
				}
			}

			switch ($order)
			{
				case SORT_ASC:
					asort($sortable_array);
				break;
				case SORT_DESC:
					arsort($sortable_array);
				break;
			}

			foreach ($sortable_array as $k => $v)
			{
				$new_array[$k] = $array[$k];
			}
		}
		return $new_array;
	}

	// array_search with partial matches
	public function array_find($needle, $haystack)
	{
		if (!is_array($haystack))
		{
			return false;
		}
		foreach ($haystack as $key => $item)
		{
			if (strpos($item['config_name'], $needle) !== false)
			{
				return $haystack[$key]['config_value'];
			}
		}
		return false;
	}
}
