<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cronstatus\migrations\v33x;

/**
 * Migration stage 3: Config data
 */
class m2_config_data extends \phpbb\db\migration\migration
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
		return array('\forumhulp\cronstatus\migrations\v33x\m1_initial_schema');
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('cronstatus_dateformat', '|d M Y|, H:i')),
			array('config.add', array('cronstatus_main_notice', 'true')),
			array('config.add', array('cronstatus_default_sort', 'display_name|a')),
			array('config.add', array('cronstatus_run_always', 0)),
		);
	}
}
