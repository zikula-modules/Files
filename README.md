Files module
============
Files module 1.0.0 **for Zikula 1.3.0-6**

  - The module Files **allow users to manage their own files**. They can upload, rename, delete, zip and unzip files and folders. The users can decide if a folder is **public or private**. If a folder is set as public files stored in it are accessible trough the file file.php.
  - The administrators can set different **quotas** for different groups of users.
  - The module needs a folder where to store the users' files. In preference this folder must be located out of the public HTML. This folder (may be the same zkdata folder). Files folder contains the users folders and other content (if it is zkdata, all the files of other modules).
  - **Administrators also can manage the entire Files folder**.

Install notes
-------------
The module needs also a file named **file.php**, which must be located in the **root of the Zikula** installation. This file is needed to get the files from the public directories of the users. You can find this file in **Files/Resources/extras**, so you have to move it during the installation.

Working on 1.0.1 version (**branch dev**)
=========================================

Changes
=======
  - Remove *InteractiveInstall* functions (deprecated on zk 1.3.6).
      - Firs idea was move this functions to a *Controller-Admin-config* functions. Unnecesary after 1.0.1 goals.
      - Remove also *Files_init.tpl*.

  - Create function *checkingModule* in *Controller/User*.
      - Every controller function will call it to check module configuration.
      - **folderPath**:
        - For multisites (*$ZConfig['Multisites']['multi']* = 1) folderPath will be *$ZConfig['Multisites']['filesRealPath'] . '/' . $ZConfig['Multisites']['siteFilesFolder'];*.
        - If global *$ZConfig['FilesModule']['folderPath']* use this like folderPath. It checks if this folder exist and is writable.
        - If globar var not exist, use *$ZConfig['System']['datadir']* like folderPath. It checks if this folder exist (and if not, it create it) and if is writeable (and if not, it change acces permissions).
      - **usersFiles**:
        - ~~If global *$ZConfig['FilesModule']['usersFiles']* use this like usersFiles.~~ Files folder keeps managing like a module_var (*usersFolder*). Default value is 'usersFiles'.
        - Function checks if this folder exists (or creates it) and if it's wirteable (or changes permissions).
      - Failed checks report a warning template.
      - Overcome checks return all config vars: folderPath, usersFiles, multisites.

  - Change file.php not to start *Zikula engine* in any case.
      - With global $ZConfig, files folder is known in every case.
      - Remove also Controller-User-notPublicFile function, Files_user_notPublicFile.tpl and lang strings

  - Add Xinha plugin resource to repo

  - Update file.php request. Return to Controller-External functions and templates.
      - Fix ajax problems in thumbnail functions.
      - Fix insert problems
      - Remove Controller-User request and fix popup creation problems.

  - Fix problems win zip/unzip functions
     - No zip *.htaccess*, *.locked* and *.tbn* folders.
     - Update PclZib lib to 2.8.2 and add callback function to skip these files

  - Changes in extenal templates I
      - New option to insert pictures (not only thumbnails). Only in public folders, add option to thumbnail img, insert img and inset thumbnails.
      - Update file links: url for public folders and *title* message for no-public.
      - Add new functions to editor.response: *insertImg*, *insertLink*, *copyURL* and *gotoURL*.
Pending
=======

  - Changes in extenal templates II
      - Add jquery_toggle_divs with the new response options.
      - Update warnings and templates messages.
      - Add *select all* feature.

  - No-public init folders. Check this feature for admin and users (and the relationship behavior).

  - Check possible last Agora dependences (and add, if necessary, config var and its checks)

  - Fix problems with editor plugin, when focus is in the editor but cursor is not in the textarea.

  - Update module
      - Remake catalan translation (many changes).
      - Update installer.
      - Upgrade removing vars and alerting about necessary changes in ZConfig.
      - Version number: 1.0.1
