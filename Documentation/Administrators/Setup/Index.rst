.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _administrators_setup:


Setup
=====

You have to map source tables with migrated tables.

The class EXT:migration_shortcut/Classes/Update/XblogGridUpdater.php has an array $_migratedTables:

.. code:: php

  /**
   * @var array
   */
  private $_migratedTables = [
      'tt_content'   => 'tt_content'
      , 'tt_news'      => 'tx_org_news'
      , 'tx_cal_event' => 'tx_calendarize_domain_model_event'
  ];


In the sample above

* migrated tt_content elements were added to the table tt_content

but

* migrated tt_news records were added to the new table tx_org_news
* migrated tx_cal_event records were added to the new table tx_calendarize_domain_model_event

**You have to adapt the array above to your needs!**