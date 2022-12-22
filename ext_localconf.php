<?php

defined('TYPO3') or exit();

(function ()
{
  // register upgrade wizards
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['PiflexformupdateXblogGrid'] = \Verdigado\Piflexformupdate\Update\XblogGridUpdater::class;
})();
