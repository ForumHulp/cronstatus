<?php
/**
*
* @package cronstatus
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\cronstatus\migrations;

class cronstatus extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		$this->revert = false;
		return array(
			array('config.add', array('cronstatus_dateformat', '|d M Y|, H:i')),
			array('config.add', array('cronstatus_main_notice', 'true')),
			array('config.add', array('cronstatus_default_sort', 'display_name|a')),
			array('module.add', array('acp', 'ACP_CAT_MAINTENANCE', 'ACP_CRON_STATUS_TITLE')),
			array('module.add', array(
				'acp', 'ACP_CRON_STATUS_TITLE', array(
					'module_basename'	=> '\forumhulp\cronstatus\acp\cronstatus_module',
					'auth'				=> 'ext_forumhulp/cronstatus',
					'modes'				=> array('config'),
				),
			)),
			array('custom', array(array($this, 'update_cron'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'update_cron'))),
		);
	}

	/**
	* Update files on server
	*
	* @return null
	* @access public
	*/
	public function update_cron()
	{
		$this->replacements = $this->data();
		$files = $this->replacements['files'];
		$searches = ($this->revert) ? $this->replacements['replaces'] : $this->replacements['searches'];
		$replace = ($this->revert) ? $this->replacements['searches'] : $this->replacements['replaces'];
		$i = $j = 0;
		$files_changed = array();
		foreach($files as $key => $file)
		{
			if (is_writable($this->phpbb_root_path . $file))
			{
				$fp = @fopen($this->phpbb_root_path . $file , 'r' );
				if ($fp === false) continue;
				$content = fread( $fp, filesize($this->phpbb_root_path . $file) );
				(!$this->revert) ? copy($this->phpbb_root_path . $file, $this->phpbb_root_path . $file . '.bak') : null;
				fclose($fp); 
				foreach($searches[$key] as $key2 => $search)
				{
					if ($this->revert || strpos($content, $replace[$key][$key2]) === false)
					{
						$content = str_replace($search, $replace[$key][$key2], $content);
						($key2 == 0) ? $i++ : $i;
					}
				}
				if ($i != $j)
				{
					$new_file = $files[$key];
					$fp = @fopen($this->phpbb_root_path . $new_file , 'w' ); 	
					if ($fp === false) continue;
					$fwrite = fwrite($fp, $content);	
					fclose($fp);
					if ($fwrite !== false) 
					{
						$j = $i;
						$files_changed[] = $new_file;
					}
				}
			}
		}
		
		global $phpbb_log, $user;
		if (sizeof($files) == sizeof($files_changed))
		{
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_CORE_DEINSTALLED' : 'LOG_CORE_INSTALLED'), time(), array());
			
		} else
		{
			$not_updated = array_diff($files, $files_changed);
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_CORE_NOT_REPLACED' : 'LOG_CORE_NOT_UPDATED'), time(), array(implode('<br />', $not_updated)));
			
			$user->lang['EXTENSION_' . (($this->revert) ? 'DELETE_DATA' : 'ENABLE') . '_SUCCESS'] .= '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">' .
			(($this->revert) ? 'Not all files are replaced! Please replace by hand the file(s) mentioned in the admin-log' : 'Not all updates are done properly because of filepermissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions!') . '</p></div>';;
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
