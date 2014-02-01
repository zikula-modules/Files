Files module
============
Files module 1.0.1 **for Zikula 1.3.x**

  - The module Files **allow users to manage their own files**. They can upload, rename, delete, zip and unzip files and folders. The users can decide if a folder is **public or private**. If a folder is set as public files stored in it are accessible trough the file *file.php*.
  - Administrators can set different **quotas** for different groups of users.
  - The module needs a folder where to store the users' files. In preference this folder must be located out of the public HTML. This folder (may be the same zkdata folder). Files folder contains the users folders and other content (if it is zkdata, all the files of other modules).
  - **Administrators also can manage the entire Files folder**.
  - Module has a **xinha plugin** to easily **insert links and images** from the public folders.

Installing Files
================

Copying files
-------------

  1. Download the repo form [github](https://github.com/zikula-modules/Files/archive/master.zip).
  2. Extract files and copy them to *path_to_Zikula_root/modules/Files*
  3. Copy *path_to_Zikula_root/modules/Files/Resources/extras/file.php* to *path_to_Zikula_root/file.php*
  4. If you use Scribite and you want the xinha plugin, copy *path_to_Zikula_root/modules/Files/Resources/xinhaPlugin/Files* to  *path_to_Zikula_root/modules/Scribite/includes/xinha/plugins/Files*
  5. Delete *path_to_Zikula_root/modules/Files/Resources* folder

Note: (1) For scribite 5.0.0, it will be *path_to_Zikula_root/Scribite/plugins/Xinha/vendor/xinha/plugins/Files*

Module configuration
--------------------

  1. Simply install the module and run it.
  2. Default configuration use *zikulaDataFolder* to store files. Then module creates *usersFiles* (into *zikulaDataFolder*) to store users files. There will be one folder for each user (for example *zikulaDataFolder/usersFiles/a/admin*)
  3. The users folder (*usersFiles*) is easily changeable from module administration.
  4. You can change the main folder (default value *zikulaDataFolder*) in *config.php*
      - You can define *$ZConfig['FilesModule']['folderPath']* with an alternative route (the path needs an real and writeable folder)
      - For multisites (*$ZConfig['Multisites']['multi']* = 1) you need a more complex configuration. Then you must define two more vars. The path will be *$ZConfig['Multisites']['filesRealPath'] . '/' . $ZConfig['Multisites']['siteFilesFolder']*
  5. If you use [Àgora project](https://github.com/projectestac/agora), you must define *$ZConfig['iwmodules']['agora'] = true* to use agora functions

Xinha Files plugin
------------------

  1. Like other plugins, admin have to go to *Administration-Scribite-EditorConfig-Xinha* and check *Files* plugin
  2. Then, you will see a *paper clip* button in your xinha editor

Notes
-----

  1. For scribite 5.0.0, the path will be *path_to_Zikula_root/Scribite/plugins/Xinha/vendor/xinha/plugins/Files*
  2. Using the default configuration (*folderPath = zikulaDataFolder*), admin can manage other modules files.

Using Files
===========
For users
---------
  - Go to *Your Account* -> *File Manager*
  - You can manage folders (create, rename and delete) and files (upload, download, rename and delete and also unzip/view for zip files)
  - You can check one/more/all elements (files and folders) to move, zip or delete them.
  - You can set public/private all your folders (except your root folder, private by default)

  (Xinha plugin)
  - Use the *paper clip* button in your editor.
  - In the modal dialog, you have all the *File Manager* functions
  - In your public folders, you simply click to insert links or images, copy or goto URLs
  - You can make a thumbnail from your pictures, change their size and insert directly

  Note: Like other xinha plugins, take care to use it when cursor (no only window focus) is in the text area.

For admins
----------
  - Your *File Manager*  manage the entire Files folder (all users folders and the main one).
  - In module administration you have multiple control options: allowed extensions, hidden files... and optional quotas for groups

--------
Check version [changes](docs/changes.md)