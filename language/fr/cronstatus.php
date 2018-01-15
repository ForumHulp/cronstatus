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
	'CRON'								=> 'Cron',
	'CRON_LOCKED'						=> 'Cron arrêté',
	'CRON_TIME_LOCKED'					=> 'Temps d’arrêt du Cron',
	'ACP_CRON_STATUS_TITLE'				=> 'Statut du Cron',
	'ACP_CRON_STATUS_EXPLAIN'			=> 'Depuis cette page il est possible d’avoir une vue d’ensemble sur le statut des tâches du Cron. Une tâche marquée en rouge signifie que celle-ci n’a jamais été exécutée ou rencontre un problème. Un verrou rouge signifie que celle-ci est en cours d’exécution, ou que celle-ci est verrouillée par le gestionnaire du Cron et bloque d’autres tâches.<br /><br />Réinitialiser le verrouillage du Cron en cliquant sur le verrou ou exécuter toutes les tâches du CRON en un clic.<br /><br />Exécuter une tâche disponible en cliquant sur « Exécuter la tâche maintenant » situé à droite de son nom.<br /><br />L’indication « Automatique » concerne une tâche qui possède sa propre gestion de sa fréquence d’exécution et qui ne peut être prise en charge par l’extension « Cron Status ».',
	'CRON_STATUS_REFRESH'				=> 'Nombre de secondes avant l’actualisation',
	'CRON_TASK_LOCKED'					=> 'Tâche du Cron arrêtée',
	'CRON_STATUS_READY_TASKS'			=> 'Tâches disponibles',
	'CRON_STATUS_NOT_READY_TASKS'		=> 'Tâches non disponibles',
	'CRON_STATUS_NEVER_STARTED_TASKS'	=> 'Tâches n’ayant jamais été exécutées (cliquer pour les afficher)',
	'CRON_STATUS_NO_TASKS'				=> 'Aucune tâche du Cron n’est prête à être exécutée',
	'CRON_STATUS_DATE_FORMAT'			=> 'Format de la date du statut des tâches du Cron',
	'CRON_STATUS_DATE_FORMAT_EXPLAIN'	=> 'Le format de la date est le même que la fonction <code>date</code> de PHP.',
	'CRON_STATUS_MAIN_NOTICE'			=> 'Notification dans le panneau d’administration',
	'CRON_STATUS_MAIN_NOTICE_EXPLAIN'	=> 'Permet d’être informé lorsque le Cron est arrêté par une notification affichée sur la page de l’index du panneau d’administration.',
	'CRON_STATUS_RUN_ALWAYS'			=> 'Exécuter le Cron plus souvent',
	'CRON_STATUS_RUN_ALWAYS_EXPLAIN'	=> 'Permet d’exécuter les tâches du Cron lors des visites des robots. Ce comportement donne de bons résultats sur les forums peu fréquentés.',
	'CRON_TASK_NAME'					=> 'Nom de la tâche',
	'CRON_TASK_DATE'					=> 'Dernière exécution',
	'CRON_NEW_DATE'						=> 'Prochaine exécution',
	'CRON_TASK_NEVER_STARTED'			=> 'N’a jamais été exécutée',
	'CRON_TASK_AUTO'					=> 'Automatique',
	'CRON_TASK_DATE_TIME'				=> 'Date et heure actuelles',
	'CRON_STATUS_ERROR'					=> 'Erreur d’actualisation',
	'CRON_STATUS_TIMEOUT'				=> 'Temps d’actualisation dépassé',
	'CRON_STATUS_ERROR_EXPLAIN'			=> 'Une erreur s’est produite lors de l’actualisation de la page.',
	'CRON_TASK_RUN'						=> 'Exécuter la tâche',
	'CRON_TASK_RUNNING'					=> 'En cours d’exécution…',
	'CRON_TASK_RUN_NOW'					=> 'Exécuter la tâche maintenant',
	'CRON_TASK_RUN_ALL'					=> 'Tout exécuter'
));
