<?php
/**
*
* @package Cron_status
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cron_status\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;
    protected $helper;
	protected $user;
	protected $template;
	protected $db;
	protected $cron_manager;

    /**
    * Constructor
    *
    * @param \phpbb\controller\helper    $helper        Controller helper object
    */
    public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\user $user, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\cron\manager $cron_manager)
    {
        $this->config = $config;
		$this->helper = $helper;
		$this->user = $user;
		$this->template = $template;
		$this->db = $db;
		$this->cron_manager = $cron_manager;
    }

    static public function getSubscribedEvents()
    {
        return array(
			'core.user_setup'					=> 'load_language_on_setup',
			'core.acp_main_notice'				=> 'load_cron_status'
		);
    }

	public function load_cron_status($event)
	{

		$tasks = $this->cron_manager->get_tasks();

		if (empty($tasks) || !$this->config['cron_lock'])
		{
			return;
		}

		$not_ready_tasks = array();
		foreach ($tasks as $task)
		{
			if (!$task->is_ready())
			{
				$not_ready_tasks[] = $task->get_name();
			}
		}

		$time = explode(' ', $this->config['cron_lock']);

		$sql = 'SELECT * FROM tbl_config where config_name LIKE "%last_gc" ORDER BY config_value DESC LIMIT 1';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$task = str_replace('_last_gc', '',$row['config_name']);
		$task = str_replace('read_notification', 'prune_notification', $task);

		$task = $this->array_find($task, $not_ready_tasks);

		$this->template->assign_vars(array(
			'CRON_TIME' => (sizeof($time) == 2) ? $this->user->format_date((int) $time[0]) : false,
			'CRON_NAME' => $task
		));
	}

	// array_search with partial matches
	public function array_find($needle, $haystack) 
	{
		if(!is_array($haystack)) return false;
		foreach ($haystack as $key => $item) 
		{
			if (strpos($item, $needle) !== false) return $haystack[$key];
		}
		return false;
	}
	
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'forumhulp/cron_status',
			'lang_set' => 'cron_status',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}