<?php

declare(strict_types=1);

namespace Verdigado\Piflexformupdate\Update;

use Symfony\Component\Console\Output\OutputInterface;
use Verdigado\Piflexformupdate\Utility\PersistanceUtility;
use Verdigado\Piflexformupdate\Utility\SqlUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\ChattyInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Updates content element/CType "shortcut"
 */
class XblogGridUpdater implements ChattyInterface, UpgradeWizardInterface
{

  /**
   * @var int
   */
  //private $_devPid = 160060;
  private $_devPid = null;

  /**
   * @var int
   */
  private $_quantity = null;

  /**
   * @var OutputInterface
   */
  public $output = null;

  /**
   * Transforms the given array to FlexForm XML
   *
   * @param array $input
   * @return string
   */
  private function _array2xml(array $input = []): string
  {
    $options  = [
        'parentTagMap'      => [
            'data'       => 'sheet',
            'sheet'      => 'language',
            'language'   => 'field',
            'el'         => 'field',
            'field'      => 'value',
            'field:el'   => 'el',
            'el:_IS_NUM' => 'section',
            'section'    => 'itemType'
        ],
        'disableTypeAttrib' => 2
    ];
    $spaceInd = 2;
    $output   = GeneralUtility::array2xml($input, '', 0, 'T3FlexForms', $spaceInd, $options);
    $output   = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . LF . $output;
    return $output;
  }

  /**
   * Get quantity
   *
   * @return int
   */
  private function _getQuantity(): int
  {
    if ($this->_quantity !== null)
    {
      return $this->_quantity;
    }
    $this->_quantity = SqlUtility::SelectCountXBlogGrid($this->_devPid);

    return (int) $this->_quantity;
  }

  /**
   * 
   *
   * @return void
   */
  private function _update(): void
  {
    // Get affected records
    $rows = SqlUtility::SelectXBlogGrid($this->_devPid);
    foreach ((array) $rows as $row)
    {
      //var_dump(__METHOD__, __LINE__, $row['pid']);
      $row = $this->_updatePiFlexform($row);
      PersistanceUtility::UpdatePiFlexform($row);
    }
  }

  /**
   * 
   * @param array $row
   * @return array $row
   */
  private function _updatePiFlexform($row): array
  {
    $arrFlexform = GeneralUtility::xml2array($row['pi_flexform']);
    $gridValue   = $arrFlexform['data']['tmpl']['lDEF']['settings.flexform.pi1.tmpl.grid']['vDEF'];

    switch ($gridValue)
    {
      case('4'):
        $newGridValue = '3';
        break;
      case('8'):
        $newGridValue = '9';
        break;
    }
    $arrFlexform['data']['tmpl']['lDEF']['settings.flexform.pi1.tmpl.grid']['vDEF'] = $newGridValue;

    $pi_flexform        = $this->_array2xml($arrFlexform);
    //var_dump(__METHOD__, __LINE__, $row['pi_flexform'], $pi_flexform);
    $row['pi_flexform'] = $pi_flexform;

    $prompt = '[UPDATE] pid: ' . $row['pid'] . ' | uid: ' . $row['uid'] . PHP_EOL;
    $this->output->write($prompt, true);


    return $row;
  }

  /**
   * 
   *
   * @return bool
   */
  public function executeUpdate(): bool
  {
    $this->_update();
    return true;
  }

  /**
   * Return the identifier for this wizard
   * This should be the same string as used in the ext_localconf class registration
   *
   * @return string
   */
  public function getIdentifier(): string
  {
    return 'PiflexformupdateXblogGrid';
  }

  /**
   * @return string[] All new fields and tables must exist
   */
  public function getPrerequisites(): array
  {
    return [
        DatabaseUpdatedPrerequisite::class
    ];
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle(): string
  {
    return 'EXT:piflexformupdate: Updates the xBlog grid';
  }

  /**
   * Get description
   *
   * @return string Longer description of this updater
   */
  public function getDescription(): string
  {
    $quantity    = $this->_getQuantity();
    $description = 'xBlog plugin main: Updates the grid from 8|4 to 9|3 and 4|8 to 3|9, '
            . 'if image height is 165 pixel and width is 220 pixel. '
            . $quantity . ' records will be updated.'
    ;
    return $description;
  }

  /**
   * Setter injection for output into upgrade wizards
   *
   * @param OutputInterface $output
   */
  public function setOutput(OutputInterface $output): void
  {
    $this->output = $output;
  }

  /**
   * Is an update necessary?
   *
   * for now: always ;-)
   *
   * @return bool
   */
  public function updateNecessary(): bool
  {
    $quantity = $this->_getQuantity();
    if ($quantity == 0)
    {
      return false;
    }
    return true;
  }

}
