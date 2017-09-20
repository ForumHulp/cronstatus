<?php
/**
 *
 * Cron Status. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_CRON_STATUS_TITLE'	=> 'Statut du Cron',
	'LOG_CORE_INSTALLED'	=> 'Fichiers modifiés avec succès !',
	'LOG_CORE_DEINSTALLED'	=> 'Fichiers restaurés avec succès !',
	'LOG_CORE_NOT_REPLACED'	=> 'Impossible de remplacer les fichiers<br />» %s',
	'LOG_CORE_NOT_UPDATED'	=> 'Impossible de mettre à jour les fichiers<br />» %s',
	'FH_HELPER_NOTICE'		=> 'L’extension « Forumhulp Helper » n’est pas installée !<br />Merci de la télécharger depuis la page « <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> », puis de l’installer.',
	'CRONSTAT_NOTICE'		=> '<div class="phpinfo" style="max-width:556px;margin-right:auto;margin-left:auto;"><p class="entry"><br />Cette extension est disponible depuis la page : %1$s » %2$s » %3$s.</p></div>',
));

// Description of Cron Status extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Informations sur l’extension',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'	=> 'Vue d’ensemble des tâches du Cron (avec tri).',
			'DESCRIPTION_2'	=> 'Affichage du statut de chaque tâche du Cron.',
			'DESCRIPTION_3'	=> 'Exécution manuelle de n’importe quelle tâche disponible.',
			'DESCRIPTION_4'	=> 'Réinitialisation du verrouillage du Cron en un clic.',
		),
		'note' => array(
			'NOTICE_1'		=> 'Notification sur le statut du Cron (optionnelle).',
			'NOTICE_2'		=> 'Peut être désactivée depuis la page « Configuration du forum ».',
			'NOTICE_3'		=> 'Permet d’exécuter le Cron plus souvent.',
			'NOTICE_4'		=> 'Compatible avec phpBB 3.2.x.'
		)
	)
));
