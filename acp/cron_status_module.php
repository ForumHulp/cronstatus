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
		global $user, $template, $request, $phpbb_container;

		$action	= $request->variable('action', '');

		switch($mode)
		{
			case 'config':
			$this->page_title = $user->lang['ACP_CRON_STATUS_TITLE'];
			$this->tpl_name = 'acp_cron_status';
			break;
		}
		
		$tasks = $phpbb_container->get('cron.manager')->get_tasks();

		if (empty($tasks))
		{
			$template->assign_vars(array(
				'S_READY_TASKS'		=> false,
				'L_READY_TASKS'		=> '',
				'READY_TASKS'		=> '',
				'L_NOT_READY_TASKS'	=> $user->lang['CRON_STATUS_NO_TASKS'],
				'NOT_READY_TASKS'	=> '',
				'U_ACTION'			=> $this->u_action,
				)
			);
			return;
		}

		$not_ready_tasks = array();
		$ready_tasks = array();
		foreach ($tasks as $task)
		{
			if (!$task->is_ready()) $not_ready_tasks[] = $task->get_name();
			else $ready_tasks[] = $task->get_name();
		}

		$template->assign_vars(array(
			'S_READY_TASKS'		=> (sizeof($ready_tasks)) ? true : false,
			'L_READY_TASKS'		=> $user->lang['CRON_STATUS_READY_TASKS'],
			'READY_TASKS'		=> implode('<br />', $ready_tasks),
			'L_NOT_READY_TASKS'	=> $user->lang['CRON_STATUS_NOT_READY_TASKS'],
			'NOT_READY_TASKS'	=> implode('<br />', $not_ready_tasks),
			'U_ACTION'			=> $this->u_action,
			)
		);
	}
}
