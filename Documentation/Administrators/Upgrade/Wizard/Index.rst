.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _administrators_upgrade_wizard:


Upgrade Wizard
==============


PiflexformupdateXblogArchive
----------------------------

Effected plugin: main plugin of EXT:xblog

Enable the property "Display only archived news". The private variable $_csvUidList
contains a list of the uids of the plugins which shoul updated.

The script will not be displayed if there is no plugin with the specified grid and image size values. 

Run the script in the Upgrade Wizard of your Install Tool.

You will get a report like:

* [UPDATE] pid: 111889 | uid: 657755
* [UPDATE] pid: 119997 | uid: 451235
* ...


PiflexformupdateXblogGrid
-------------------------

Effected plugin: main plugin of EXT:xblog

If you want to update xBlog plugin main grid from 8|4 to 9|3 or 4|8 to 3|9 
when image height is 165px and width is 220px run this script.

The script will not be displayed if there is no plugin with the specified grid and image size values. 

Run the script in the Upgrade Wizard of your Install Tool.

You will get a report like:

* [UPDATE] pid: 181343 | uid: 555093
* [UPDATE] pid: 200691 | uid: 664941
* ...


PiflexformupdateXblogImagesizemode
----------------------------------

Effected plugin: main plugin of EXT:xblog

Sets "Size in list view" to "See below [plugin]" and "Size in single view" to "From record [record]".
All xBlog main plugins will be affected.

The script will not be displayed if there is no plugin for updating. 

Run the script in the Upgrade Wizard of your Install Tool.

You will get a report like:

* [UPDATE] pid: 119997 | uid: 451235
* [UPDATE] pid: 216834 | uid: 739028 
* ...