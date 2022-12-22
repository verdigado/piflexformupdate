.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _developers:


Developers
==========

If you need to replace values in your pi_flexform, 
you can take the classes of this extension as a draft.

This is the workflow:

* For example, copy Classes/Update/XblogGridUpdater.php into your class called MyUpdater.php
* Register your update wizard class in ext_localconf.php
* In Classes/Utility, extend the PersistanceUtility.php and SqlUtility.php classes with your queries.