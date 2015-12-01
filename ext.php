<?php
/**
*
* @package Cronstatus
* @copyright (c) 2015 ForumHulp.com
* @license Proprietary
*
*/

namespace forumhulp\cronstatus;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		if (!class_exists('forumhulp\helper\helper'))
		{
			$this->container->get('user')->add_lang_ext('forumhulp/cronstatus', 'info_acp_cronstatus');
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('forumhulp/helper'))
		{
			$this->container->get('ext.manager')->enable('forumhulp/helper');
		}

		return class_exists('forumhulp\helper\helper');
	}

	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('forumhulp/cronstatus', 'info_acp_cronstatus');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['CRONSTAT_NOTICE']) ?
							sprintf($this->container->get('user')->lang['CRONSTAT_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_MAINTENANCE'],
									$this->container->get('user')->lang['ACP_FORUM_LOGS'],
									$this->container->get('user')->lang['ACP_CRON_STATUS_TITLE']) : ''));
				}

				// Run parent enable step method
				return parent::enable_step($old_state);
			
			break;
			
			default:
			
				// Run parent enable step method
				return parent::enable_step($old_state);
				
			break;
		}
	}
}