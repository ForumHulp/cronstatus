<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cronstatus\migrations\v31x;

use phpbb\db\migration\container_aware_migration;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends container_aware_migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_data()
	{
		$this->revert = false;
		return array(
			array('custom', array(array($this, 'update_files'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'update_files'))),
		);
	}

	public function update_files()
	{
		if (class_exists('forumhulp\helper\helper'))
		{
			if (!$this->container->has('forumhulp.helper'))
			{
				$forumhulp_helper = new \forumhulp\helper\helper(
					$this->config,
					$this->container->get('ext.manager'),
					$this->container->get('template'),
					$this->container->get('user'),
					$this->container->get('request'),
					$this->container->get('log'),
					$this->container->get('cache'),
					$this->phpbb_root_path
				);
				$this->container->set('forumhulp.helper', $forumhulp_helper);
			}
			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
		} else
		{
			$this->container->get('user')->add_lang_ext('forumhulp/cronstatus', 'info_acp_cronstatus');
			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);
		}
	}

	public function data()
	{
		$replacements = array(
			'files' => array(
				0 => '/cron.' . $this->php_ext,
				1 => '/phpbb/lock/db.' . $this->php_ext,
				),
			'searches' => array(
				0 => array(
					0 => 'if ($cron_lock->acquire())'
					),
				1 => array(
					0 => 'public function acquire()',
					1 => '$this->unique_id = time() . \' \' . unique_id();',
					),
				),
			'replaces' => array(
				0 => array(
					0 => 'if ($cron_lock->acquire($cron_type))'
					),
				1 => array(
					0 => 'public function acquire($task = \'\')',
					1 => '$this->unique_id = time() . \' \' . $task;',
					),
				)
			);
		return $replacements;
	}
}
