<?php
/*
This file is part of VCMS.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

if(!is_object($libGlobal) || !$libAuth->isLoggedin())
	exit();


if(!$libGenericStorage->attributeExistsInCurrentModule('searchNotReadAbleFiles')){
	$libGenericStorage->saveValueInCurrentModule('searchNotReadAbleFiles', 0);
}

if(!$libGenericStorage->attributeExistsInCurrentModule('showTrauerflor')){
	$libGenericStorage->saveValueInCurrentModule('showTrauerflor', 0);
}


if(in_array('internetwart', $libAuth->getAemter())){
	/*
	* output
	*/
	$oks = array();
	$errors = array();

	$securedFolders = array();
	$unsecuredFolders = array();

	$notReadableFiles = array();

	/*
	* php_version
	*/
	if(version_compare(PHP_VERSION, '5.4') < 0){
		$errors[] = 'Die PHP-Version auf diesem Server ist ' .PHP_VERSION. '. Empfohlen wird <a href="http://de.wikipedia.org/wiki/PHP#Wichtige_Versionen">zur Sicherheit</a> mindestens PHP-Version 5.4.';
	} else {
		$oks[] = 'PHP-Version=' .PHP_VERSION. '.';
	}

	/*
	* safe_mode
	*/
	if(ini_get('safe_mode')){ //ist safe_mode in der php.ini aktiviert?
		$errors[] = 'In der PHP-Version auf diesem Server ist safe_mode=On konfiguriert. Die Einstellung safe_mode=Off ist eine Voraussetzung für den Betrieb des VCMS.';
	} else {
		$oks[] = 'safe_mode=Off ist konfiguriert.';
	}

	/*
	* register_globals
	*/
	if(ini_get('register_globals')){ //ist register_globals in der php.ini aktiviert?
		$errors[] = 'In der PHP-Version auf diesem Server ist register_globals=On konfiguriert. Diese Einstellung ist veraltet und äußerst unsicher, da sie das Auftreten von Sicherheitslücken deutlich wahrscheinlicher macht. Bitte ändere den Wert in der PHP-Konfiguration Deines Hostings auf register_globals=Off.';
	} else {
		$oks[] = 'register_globals=Off ist konfiguriert.';
	}

	/*
	* system config
	*/
	if($libConfig->sitePath == ''){
		$errors[] = 'In der Systemkonfiguration ist kein sitepath eingestellt.';
	} else {
		$oks[] = 'In der Systemkonfiguration ist ein sitepath eingestellt.';
	}

	/*
	* HTTPS check
	*/
	if($libGenericStorage->loadValue('base_internet_login', 'useHttps') != '1'){
		$errors[] = 'HTTPS ist nicht für das Intranet aktiviert. Damit ist es für Dritte ein Leichtes, mit Wireshark in einem öffentlichen (Uni-)Netz die Logindaten abzuhören. Falls der Webserver <a href="https://' .$libConfig->sitePath. '" target="_blank">HTTPS unterstützt</a>, sollte HTTPS in der Konfiguration aktiviert werden.';
	} else {
		$oks[] = 'HTTPS ist für das Intranet aktiviert.';
	}


	/*
	* missing folders
	*/
	$dirs = array('custom', 'custom/intranet', 'custom/styles', 'custom/intranet/downloads', 'custom/intranet/mitgliederfotos', 'custom/semestercover', 'custom/veranstaltungsfotos', 'temp');

	foreach($dirs as $dir){
		if(!is_dir($dir)){
			$errors[] = 'Ordner '. $dir .' fehlt.';
		} else {
			$oks[] = 'Ordner ' .$dir.' vorhanden.';
		}
	}

	/*
	* missing htaccess deny files
	*/
	$htaccessDirs = array('lib', 'custom/intranet', 'custom/veranstaltungsfotos', 'temp');

	foreach($htaccessDirs as $dir){
		if(is_dir($dir)){
			if(hasHtaccessDenyFile($dir)){
				$securedFolders[] = $dir;
			} else {
				$unsecuredFolders[] = $dir;
			}
		}
	}

	$modulespath = 'modules/';

	$fd = opendir($modulespath);

	while (($part = readdir($fd)) == true){
		//module folders
		if (is_dir($modulespath . $part) && $part != '.' && $part != '..'){
			$modulePath = $modulespath . $part .'/';

			//deny access to folder by htaccess
			if(is_dir($modulePath. 'scripts/')){
				if(hasHtaccessDenyFile($modulePath. 'scripts/')){
					$securedFolders[] = $modulePath. 'scripts';
				} else {
					$unsecuredFolders[] = $modulePath. 'scripts';
				}
			}

			if(is_dir($modulePath. 'install/')){
				if(hasHtaccessDenyFile($modulePath. 'install/')){
					$securedFolders[] = $modulePath. 'install';
				} else {
					$unsecuredFolders[] = $modulePath. 'install';
				}
			}
		}
	}

	/*
	* nonreadable files
	*/
	if(function_exists('posix_access')){
		if($libGenericStorage->loadValueInCurrentModule('searchNotReadAbleFiles') == 1){
			$notReadableFiles = searchNotReadAbleFiles('.');
		}
	}

	//----------------------------------------------------------------------------------------------------------------

	/*
	* output
	*/
	if(count($errors) > 0 || count($unsecuredFolders) > 0 || count($notReadableFiles) > 0){
		echo '<h2>System-Probleme</h2>';
		echo '<hr />';

		if(count($errors) > 0){
			echo '<ul>';

			foreach($errors as $error){
				echo '<li><img src="styles/icons/basic/error.svg" alt="Error" class="icon_small" />' .$error. '</li>';
			}

			echo '</ul>';
		}

		if(count($unsecuredFolders) > 0){
			echo '<p>Folgende Ordner sind nicht durch eine htaccess-Datei geschützt:</p>';
			echo '<ul>';

			foreach($unsecuredFolders as $folder){
				echo '<li>' .$folder. '</li>';
			}

			echo '</ul>';
			echo '<p>Auf Dateien in diesen Ordnern kann aus dem Internet zugegriffen werden. Um den Schutz zu erneuern, rufe den Modul-Manager auf. Falls dies nicht hilft, gib PHP Schreibrechte auf die genannten Ordner, damit das VCMS htaccess-Dateien anlegen kann.</p>';
		}

		if(is_array($notReadableFiles) && count($notReadableFiles) > 0){
			echo '<p>PHP besitzt für die folgenden Dateien bzw. Ordner keine Leserechte:</p>';
			echo '<ul>';

			foreach($notReadableFiles as $file){
				echo '<li>' .$file . '</li>';
			}

			echo '</ul>';
			echo '<p>Leserechte können z.B. mit einem FTP-Programm eingerichtet werden.</p>';
		}

		echo '<hr />';
	}
}

function hasHtaccessDenyFile($directory){
	$filename = $directory. '/.htaccess';

   	if(!is_file($filename)){
   		return false;
   	}

	$handle = @fopen($filename, 'r');
	$content = @fread($handle, @filesize($filename));
	@fclose($handle);

	if($content == 'deny from all'){
   		return true;
   	} else {
   		return false;
   	}
}

function searchNotReadAbleFiles($dir){
	$notReadableFiles = array();

	$fd = @opendir($dir);

	while (($part = @readdir($fd)) == true){
		if($part != '.' && $part != '..'){
			if(!@posix_access($dir . '/' . $part, POSIX_R_OK)){
				$notReadableFiles[] = $dir . '/' . $part;
			}

			if(@is_dir($dir . '/' . $part) && $dir.'/'.$part != 'custom/veranstaltungsfotos'){
				$notReadableFiles = array_merge($notReadableFiles, searchNotReadAbleFiles($dir . '/' . $part));
			}
		}
	}

	return $notReadableFiles;
}
?>