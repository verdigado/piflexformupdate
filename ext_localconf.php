<?php

defined('TYPO3') or exit();

(function ()
{
  // register upgrade wizards
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['PiflexformupdateXblogArchive']       = \Verdigado\Piflexformupdate\Update\XblogArchiveUpdater::class;
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['PiflexformupdateXblogGrid']          = \Verdigado\Piflexformupdate\Update\XblogGridUpdater::class;
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['PiflexformupdateXblogImagesizemode'] = \Verdigado\Piflexformupdate\Update\XblogImagesizemodeUpdater::class;
})();
