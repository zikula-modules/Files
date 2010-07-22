<?php
/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv2.1 (or at your option, any later version).
 * @package Multisites
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */
class Files_Installer extends Zikula_Installer
{
    public function install()
	{
        if (!SecurityUtil::checkPermission('Files::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError();
        }
        // set content of the files .htaccess and .locked
        $htaccessContent = "# Avoid direct web access to folder files\r\nOrder deny,allow\r\nDeny from all\r\n";
        $lockedContent = "# Avoid direct web access with the file file.php\r\n";
        // Create module table
        if (!DBUtil::createTable('Files')) return false;
        //Create indexes
        $pntable = DBUtil::getTables();
        $c = $pntable['Files_column'];
        DBUtil::createIndex($c['userId'], 'Files', 'userId');
        // create security files
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
     * uninstall the Files module
     * @author Albert Pérez Monfort (aperezm@xtec.cat)
     * @return bool true if successful, false otherwise
     */
    public function uninstall()
    {
        // Delete module table
        DBUtil::dropTable('Files');
    	//Delete module vars
        $this->delVar('folderPath');
        $this->delVar('usersFolder');
        $this->delVar('showHideFiles');
        $this->delVar('allowedExtensions');
        $this->delVar('defaultQuota');
        $this->delVar('groupsQuota');
        $this->delVar('filesMaxSize');
        $this->delVar('maxWidth');
        $this->delVar('maxHeight');
        $this->delVar('editableExtensions');
        //Deletion successfull
        return true;
    }

    /**
     * Update the Files module
     * @author Albert Pérez Monfort (aperezm@xtec.cat)
     * @return bool true if successful, false otherwise
     */
    public function upgrade($oldversion)
    {
        return true;
    }
}