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
 * Updates settings.flexform.pi1.profile.news.archive from '' to 'archived'
 */
class XblogArchiveUpdater implements ChattyInterface, UpgradeWizardInterface
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
   * @var string
   */
  private $_csvUidList = '5817, 61263, 61742, 61745, 64092, 64095, 64096, 72308, 103916, 125826, 125831, 139576, 280535, 282148, 295176, 298838, 298839, 303639, 304082, 304862, 305817, 306641, 307252, 307449, 308684, 318388, 318390, 321568, 324228, 338970, 339689, 341460, 341463, 351815, 382146, 385595, 385847, 386787, 386789, 386791, 386793, 412080, 416243, 416927, 416928, 416933, 420163, 420169, 420170, 459310, 459320, 465956, 467463, 494662, 514975, 514977, 571956, 572119, 573111, 573255, 573256, 584600, 603179, 606779, 618403, 618404, 641674, 656027, 656878, 670097, 681846, 700114, 700115, 715006, 720845, 720863, 720864, 720865, 733835, 735357, 764667, 778955, 780341, 780342, 788692, 791928, 793263, 832178, 832181, 839528, 843811';

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
    $this->_quantity = SqlUtility::SelectCountXBlogArchive($this->_csvUidList, $this->_devPid);

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
    $rows = SqlUtility::SelectXBlogArchive($this->_csvUidList, $this->_devPid);
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
    $arrFlexform['data']['profile']['lDEF']['settings.flexform.pi1.profile.news.archive']['vDEF'] = 'archived';

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
   * Get description
   *
   * @return string Longer description of this updater
   */
  public function getDescription(): string
  {
    $quantity    = $this->_getQuantity();
    $description = 'xBlog plugin main: Enable the property "Display only archived news" '
            . 'if uid is in ' . $this->_csvUidList . '. '
            . $quantity . ' records will be updated.'
    ;
    return $description;
  }

  /**
   * Return the identifier for this wizard
   * This should be the same string as used in the ext_localconf class registration
   *
   * @return string
   */
  public function getIdentifier(): string
  {
    return 'PiflexformupdateXblogArchive';
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
    return 'EXT:piflexformupdate: Updates the xBlog property "display archived news only"';
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
