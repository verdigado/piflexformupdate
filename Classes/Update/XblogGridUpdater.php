<?php

declare(strict_types=1);

namespace Verdigado\Piflexformupdate\Update;

use Verdigado\Piflexformupdate\Utility\PersistanceUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Updates content element/CType "shortcut"
 */
class XblogGridUpdater implements UpgradeWizardInterface
{

  /**
   * @var array
   */
  private $_migratedTables = [
      'tt_content'   => 'tt_content'
      , 'tt_news'      => 'tx_org_news'
      , 'tx_cal_event' => 'tx_calendarize_domain_model_event'
  ];

  /**
   * @param   string  $csvSrceRecords   Something like tt_content_srceUid,tt_content_srceUid,tt_address_srceUid
   *
   * @return  string  $csvDestRecords   Something like tt_content_newUid,tt_content_srceUid,tt_address_srceUid
   */
  private function _getDestRecord($csvSrceRecords): string
  {
    $srceRecords = explode(',', $csvSrceRecords);
    foreach ($srceRecords as $srceRecord)
    {
      list($srceTable, $srceUid) = $this->_getRecordsTableUid($srceRecord);
      if (empty($srceTable))
      {
        $destRecords[] = $srceRecord; // Don't loose the not proper data
        continue;
      }

      $destTable = $this->_migratedTables[$srceTable];
      if (empty($destTable))
      {
        $destRecords[] = $srceRecord; // Don't loose the not proper data
        continue;
      }
      $destUid       = PersistanceUtility::GetDestUid($destTable, $srceUid);
      $destRecords[] = $destTable . '_' . $destUid;
    }

    $csvDestRecords = implode(',', $destRecords);

    return $csvDestRecords;
  }

  /**
   * @param   string  $srceRecord   Something like tt_content_srceUid
   *
   * @return  array   Params table like tt_content and uid like srceUid
   */
  private function _getRecordsTableUid($srceRecord): array
  {
    $parts    = explode('_', $srceRecord);
    $uid      = end($parts);
    $lenTable = strlen($srceRecord) - strlen('_' . $uid);
    $table    = substr($srceRecord, 0, $lenTable);

    return [
        $table,
        $uid
    ];
  }

  /**
   * 
   *
   * @return void
   */
  private function _update(): void
  {
    $shortcuts = PersistanceUtility::GetShortcuts();
    if (empty($shortcuts))
    {
      return;
    }

    foreach ($shortcuts as $shortcut)
    {
      $csvSrceRecords = $shortcut['records']; // something like tt_content_srceUid,tt_content_srceUid,tt_address_srceUid
      if (empty($csvSrceRecords))
      {
        continue;
      }
      $srceRecords = explode(',', $csvSrceRecords);
      $destRecords = null;
      foreach ($srceRecords as $srceRecord)
      {
        $destRecords[] = $this->_getDestRecord($srceRecord);    // something like tt_content_newUid,tt_content_srceUid,tt_address_srceUid
      }

      $csvDestRecords = implode(',', $destRecords);
      if ($csvSrceRecords == $csvDestRecords)
      {
        continue;
      }

      //var_dump(__METHOD__, __LINE__, $csvSrceRecords, $csvDestRecords);
      echo '[OK] uid: ' . $shortcut['uid'] . ' | pid: ' . $shortcut['pid'] . ' | ' . $csvSrceRecords . ' > ' . $csvDestRecords . PHP_EOL;

      $uid     = $shortcut['uid'];
      $records = $csvDestRecords;
      PersistanceUtility::UpdateShortcut($uid, $records);
    }
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
    return 'XblogGridUpdater';
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
    return '[XblogGridUpdater] Updates the grid';
  }

  /**
   * Get description
   *
   * @return string Longer description of this updater
   */
  public function getDescription(): string
  {
    return 'Updates the grid from 8|4 to 9|3, if image width is 220 pixel';
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
    $updateNeeded = true;

    return $updateNeeded;
  }

}
