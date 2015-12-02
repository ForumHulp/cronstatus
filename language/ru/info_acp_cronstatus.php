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
	'ACP_CRON_STATUS_TITLE'	=> 'Статус Cron',
	'LOG_CORE_INSTALLED'	=> 'Files succesfully changed',
	'LOG_CORE_DEINSTALLED'	=> 'Files succesfully changed back',
	'LOG_CORE_NOT_REPLACED'	=> 'Could not replaced file(s)<br />» %s',
	'LOG_CORE_NOT_UPDATED'	=> 'Could not update file(s)<br />» %s',
	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
	'CRONSTAT_NOTICE'		=> '<div class="phpinfo"><p class="entry">This extension resides in %1$s » %2$s » %3$s.</p></div>',
));

// Description of Cron Status extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Перечень заданий Cron (с сортировкой)',
			'DESCRIPTION_2'		=> 'Отображает статус каждого задания Cron',
			'DESCRIPTION_3'		=> 'Вы можете вручную выполнить любое готовое для выполнения задание',
			'DESCRIPTION_4'		=> 'Reset cronlock with a simple click',
		),
		'note' => array(
			'NOTICE_1'			=> 'Уведомление о Статусе Cron (опционально)',
			'NOTICE_2'			=> 'Может быть выключено в разделе Настройки конференции',
			'NOTICE_3'			=> 'phpBB 3.2 ready'
		)
	)
));
