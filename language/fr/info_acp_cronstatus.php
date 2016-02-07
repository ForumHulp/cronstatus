<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* French translation by Galixte (http://www.galixte.com)
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
	'ACP_CRON_STATUS_TITLE'	=> 'Statut  du Cron',
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
			'DESCRIPTION_1'		=> 'Vue d’ensemble des tâches du Cron (avec tri).',
			'DESCRIPTION_2'		=> 'Affiche le statut de chaque tâche du Cron.',
			'DESCRIPTION_3'		=> 'Vous pouvez exécuter manuellement n’importe quelle tâche disponible.',
			'DESCRIPTION_4'		=> 'Reset cronlock with a simple click',
		),
		'note' => array(
			'NOTICE_1'			=> 'Notification sur le statut du Cron (optionnelle)',
			'NOTICE_2'			=> 'Peut être désactivée dans la page « Configuration du forum.',
			'NOTICE_3'			=> 'Switchable Run Cron Always',
			'NOTICE_4'			=> 'phpBB 3.2 ready'
		)
	)
));
