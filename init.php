<?php
/**
 * Zikula Application Framework
 *
 * @copyright  (c) Zikula Development Team
 * @link       http://www.zikula.org
 * @version    $Id: pninit.php 202 2009-12-09 20:28:11Z aperezm $
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @author     Albert Pérez Monfort <aperezm@xtec.cat>
 * @category   Zikula_Extension
 * @package    Utilities
 * @subpackage Files
 */

/**
 * Initialise the Files module creating module vars
 * @author Albert Pérez Monfort (aperezm@xtec.cat)
 * @return bool true if successful, false otherwise
 */
function Files_init()
{
	// set content of the files .htaccess and .locked
    $htaccessContent = "# Avoid direct web access to folder files\r\nOrder deny,allow\r\nDeny from all\r\n";
    $lockedContent = "# Avoid direct web access with the file file.php\r\n";
    // Create module table
    if (!DBUtil::createTable('Files')) return false;
    //Create indexes
    $pntable = System::dbGetTables();
    $c = $pntable['Files_column'];
    // create security files
    DBUtil::createIndex($c['userId'], 'Files', 'userId');
    FileUtil::writeFile(ModUtil::getVar('Files', 'folderPath') . '/.htaccess', $htaccessContent, true);
    FileUtil::writeFile(ModUtil::getVar('Files', 'folderPath') . '/.locked', $lockedContent, true);
    FileUtil::writeFile(ModUtil::getVar('Files', 'folderPath') . '/' . ModUtil::getVar('Files', 'usersFolder') . '/.htaccess', $htaccessContent, true);
    FileUtil::writeFile(ModUtil::getVar('Files', 'folderPath') . '/' . ModUtil::getVar('Files', 'usersFolder') . '/.locked', $lockedContent, true);
    //Create module vars
    ModUtil::setVar('Files', 'showHideFiles', '0');
    ModUtil::setVar('Files', 'allowedExtensions', 'gif,png,jpg,odt,doc,pdf,zip');
    ModUtil::setVar('Files', 'defaultQuota', 1);
    ModUtil::setVar('Files', 'groupsQuota', 's:0:"";');
    ModUtil::setVar('Files', 'filesMaxSize', '1000000');
    ModUtil::setVar('Files', 'maxWidth', '250');
    ModUtil::setVar('Files', 'maxHeight', '250');
    ModUtil::setVar('Files', 'editableExtensions', 'php,htm,html,htaccess,css,js,tpl');
    
    
    // Set up module hook
    ModUtil::registerHook('item', 'display', 'GUI', 'Files', 'user', 'Files');
    return true;
}

/**
 * Initialise the interactive install system for the Files module. Checks if the needed folders exists and they are writeable
 * @author Albert Pérez Monfort (aperezm@xtec.cat)
 * @return If the files folder and users folder are not created and writeable it is not possible to install
 */
function Files_init_interactiveinit()
{
	if (!SecurityUtil::checkPermission*(0, 'Files::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
    $renderer = Renderer::getInstance('Files', false);
    $renderer->assign('step', 'info');
    return $renderer->fetch('Files_init.htm');
}

function Files_init_form($args)
{
    $file1 = FormUtil::getPassedValue('file1', isset($args['file1']) ? $args['file1'] : null, 'GET');
    $file2 = FormUtil::getPassedValue('file2', isset($args['file2']) ? $args['file2'] : 'users', 'GET');
    if (!SecurityUtil::checkPermission*(0, 'Files::', '::', ACCESS_ADMIN)){
        return LogUtil::registerPermissionError();
    }
    $renderer = Renderer::getInstance('Multisites', false);
    if($GLOBALS['PNConfig']['Multisites']['multi'] == 1) {
        $filesRealPath = 'files';
        $createdFilesFolder = true;
    } else {
	    // get server file root
        if($file1 == null) {
            $filesRoot = $_SERVER['DOCUMENT_ROOT'];
            $filesRealPath = substr($filesRoot, 0 ,  strrpos($filesRoot, '/')) . '/filesFolder';
        } else {
            $filesRealPath = $file1;
        }
        $createdFilesFolder = false;
    }
    $renderer = Renderer::getInstance('Files', false);
    $renderer->assign('filesRealPath', $filesRealPath);
    $renderer->assign('usersFolder', $file2);
    $renderer->assign('createdFilesFolder', $createdFilesFolder);
    $renderer->assign('step', 'form');
    return $renderer->fetch('Files_init.htm');
}

/**
 * Step 1 - Check if the needed files exists and if they are writeable
 * @author Albert Pérez Monfort (aperezm@xtec.cat)
 * @return if they exist and are writeable user can jump to step 2
 */
function Files_init_update()
{
    $filesRealPath = FormUtil::getPassedValue('filesRealPath', isset($args['filesRealPath']) ? $args['filesRealPath'] : null, 'POST');
    $usersFolder = FormUtil::getPassedValue('usersFolder', isset($args['usersFolder']) ? $args['usersFolder'] : null, 'POST');
	if (!SecurityUtil::checkPermission*(0, 'Files::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	$multisites = false;
	if($GLOBALS['PNConfig']['Multisites']['multi'] == 1) {
		// create the needed folders for the site
		$siteDNS = (isset($_GET['siteDNS']) ? DataUtil::formatForOS($_GET['siteDNS']) : null);
		$filesRealPath = $GLOBALS['PNConfig']['Multisites']['filesRealPath'] . '/' . $siteDNS . $GLOBALS['PNConfig']['Multisites']['siteFilesFolder'];
		if(!FileUtil::mkdirs($filesRealPath . '/' . $usersFolder, 0777, true)) {
            LogUtil::registerError(__('Directory creation error') . ': ' . $usersFolder);
            return false;
		}
		$multisites = true;
	}
    // check if the needed files are located in the correct places and they are writeable
    $file1 = false;
    $file2 = false;
    $fileWriteable1 = false;
    $fileWriteable2 = false;
    $path = $filesRealPath;
    if (file_exists($path)) {
        $file1 = true;
    }
    if (is_writeable($path)) {
        $fileWriteable1 = true;
    }
    $path = $filesRealPath . '/' . $usersFolder;
    if (file_exists($path)) {
        $file2 = true;
    }
    if (is_writeable($path)) {
        $fileWriteable2 = true;
    }
    if($fileWriteable1 && $fileWriteable2) {
        ModUtil::setVar('Files', 'folderPath', $filesRealPath);
        ModUtil::setVar('Files', 'usersFolder', $usersFolder);
    }
    $renderer = Renderer::getInstance('Files', false);
    $renderer->assign('filesRealPath', $filesRealPath);
    $renderer->assign('usersFolder', $usersFolder);
    $renderer->assign('file1', $file1);
    $renderer->assign('file2', $file2);
    $renderer->assign('multisites', $multisites);
    $renderer->assign('fileWriteable1', $fileWriteable1);
    $renderer->assign('fileWriteable2', $fileWriteable2);
    $renderer->assign('step', 'check');
    return $renderer->fetch('Files_init.htm');
}

/**
 * Delete the Files module
 * @author Albert Pérez Monfort (aperezm@xtec.cat)
 * @return bool true if successful, false otherwise
 */
function Files_delete()
{
    // Delete module table
    DBUtil::dropTable('Files');
	//Delete module vars
    ModUtil::delVar('Files', 'folderPath');
    ModUtil::delVar('Files', 'usersFolder');
    ModUtil::delVar('Files', 'showHideFiles');
    ModUtil::delVar('Files', 'allowedExtensions');
    ModUtil::delVar('Files', 'defaultQuota');
    ModUtil::delVar('Files', 'groupsQuota');
    ModUtil::delVar('Files', 'filesMaxSize');
    ModUtil::delVar('Files', 'maxWidth');
    ModUtil::delVar('Files', 'maxHeight');
    ModUtil::delVar('Files', 'editableExtensions');
    //Deletion successfull
    return true;
}

/**
 * Update the Files module
 * @author Albert Pérez Monfort (aperezm@xtec.cat)
 * @return bool true if successful, false otherwise
 */
function Files_upgrade($oldversion)
{
    return true;
}
