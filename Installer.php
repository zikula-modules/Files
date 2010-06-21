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
    public function upgrade($oldversion)
    {
        return true;
    }
}