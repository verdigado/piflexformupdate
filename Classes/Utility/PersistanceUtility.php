<?php

declare(strict_types=1);

namespace Verdigado\Piflexformupdate\Utility;

use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Updates content element/CType "shortcut"
 */
class PersistanceUtility
{

  /**
   * @param   string        $table  The migrated table
   * @param   int           $uid    Uid of the srce record
   *
   * @return  null||array    $row
   */
  public static function GetDestUid($table, $uid)
  {
    $queryBuilder      = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
    $deleteRestriction = GeneralUtility::makeInstance(DeletedRestriction::class);

    $queryBuilder->getRestrictions()->removeAll()->add($deleteRestriction);
    $row = $queryBuilder
            ->select('uid')
            ->from($table)
            ->where(
                    $queryBuilder->expr()->eq('_migrated_uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
                    , $queryBuilder->expr()->eq('_migrated_table', $queryBuilder->createNamedParameter($table, \PDO::PARAM_STR))
            )
            ->execute()
            ->fetch()
    ;

    if (empty($row))
    {
      return $uid;
    }
    return $row['uid'];
  }

  /**
   * 
   *
   * @return null||array    $rows
   */
  public static function GetShortcuts()
  {
    $queryBuilder      = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
    $deleteRestriction = GeneralUtility::makeInstance(DeletedRestriction::class);

    $queryBuilder->getRestrictions()->removeAll()->add($deleteRestriction);
    $rows = $queryBuilder
            ->select('uid', 'pid', 'records')
            ->from('tt_content')
            ->where(
                    $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('shortcut', \PDO::PARAM_STR))
            )
            ->orderBy('uid', 'ASC')
            ->execute()
            ->fetchAll()
    ;
    return $rows;
  }

  /**
   * 
   *
   * @return void
   */
  public static function UpdateShortcut($uid, $records): void
  {
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');

    $queryBuilder
            ->update('tt_content')
            ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->set('records', $records)
            ->execute()
    ;
  }

}
