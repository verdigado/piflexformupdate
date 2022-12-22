.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _administrators_upgrade_cli:


CLI Script
==========

Run the command below. **Only run it after all other migration scripts are completed!**

You will get a report in your console.


.. code:: php

  my@host:/srv/typo104/public_html/current$ time php vendor/bin/typo3cms upgrade:run XblogGridUpdater

  ...
  [OK] uid: 451235 | pid: 119997 | tx_cal_event_31087 > tx_calendarize_domain_model_event_31087
  [OK] uid: 555093 | pid: 181343 | tt_content_551609,tt_content_551785 > tt_content_862883,tt_content_551785
  [OK] uid: 657755 | pid: 111889 | tt_news_175276 > tx_org_news_175276
  [OK] uid: 664941 | pid: 200691 | tx_cal_event_521015,tx_cal_event_553752 > tx_calendarize_domain_model_event_521015,tx_calendarize_domain_model_event_553752
  [OK] uid: 739028 | pid: 216834 | tt_news_203163,tt_news_203172,tt_news_203177,tt_news_203179 > tx_org_news_203163,tx_org_news_203172,tx_org_news_203177,tx_org_news_203179
  ...
