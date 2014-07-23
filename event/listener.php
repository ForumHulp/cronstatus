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
  
    /**
    * Constructor
    *
    * @param \phpbb\controller\helper    $helper        Controller helper object
    */
    public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\user $user, \phpbb\template\template $template)
    {
        $this->config = $config;
		$this->helper = $helper;
		$this->user = $user;
		$this->template = $template;
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
		$time = explode(' ', $this->config['cron_lock']);

		$this->template->assign_vars(array(
			'CRON_TIME' => (sizeof($time) == 3) ? $this->user->format_date((int) $time[0]) : false,
			'CRON_NAME' => (sizeof($time) == 3) ? $time[2] : ''
		));
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