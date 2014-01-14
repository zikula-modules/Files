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

Goals
=====
  - Remove *InteractiveInstall* functions (deprecated on zk 1.3.6)
      - Firs idea was move this functions to a Controller-Admin-config functions. Unnecesary after 1.0.1 goals.
      - Remove also Files_init.tpl

  - Create function *checkingModule* on Controller/User
      - Every controller function will call it to check module configuration.
      - If global *$ZConfig['FilesModule']['datadir']* use this like module folder (the current users folder). It checks if this folder exist and is writable.
      - If globar var not exist, use *$ZConfig['System']['datadir'].'/userFiles'* like module folder. It checks if this folder exist (and if not, it create it) and if is writable (and if not, it change acces permissions).

  - Change file.php not to start *Zikula engine* in any case.
      - With global $ZConfig, files folder is known in every case.
      - Remove also Controller-User-notPublicFile function, Files_user_notPublicFile.tpl and lang strings

  - Update module
      - Remove vars and alert about necessary changes in ZConfig.
      - Version number: 1.0.1
