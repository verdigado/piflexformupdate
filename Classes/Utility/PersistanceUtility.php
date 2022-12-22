<?php

declare(strict_types=1);

namespace Verdigado\Piflexformupdate\Utility;

use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class PersistanceUtility
{

  /**
   * 
   *
   * @return void
   */
  public static function UpdatePiFlexform($row): void
  {
    $uid         = $row['uid'];
    $pi_flexform = $row['pi_flexform'];

    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');

    $queryBuilder
            ->update('tt_content')
            ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->set('pi_flexform', $pi_flexform)
            ->execute()
    ;
  }

}
