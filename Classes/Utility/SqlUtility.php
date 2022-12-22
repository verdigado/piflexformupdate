<?php

declare(strict_types=1);

namespace Verdigado\Piflexformupdate\Utility;

use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class SqlUtility
{

  /**
   * @param  int  $pid
   * @return int
   * @throws DBALException
   */
  public static function SelectCountXBlogGrid($pid = null): int
  {
    $andWherePid = '';
    if ($pid)
    {
      $andWherePid = ' AND pid = ' . $pid;
    }
    
    $query = '
      SELECT  COUNT(uid) AS quantity
      FROM    tt_content
      WHERE   CType = "list" 
      ' . $andWherePid . '
      AND     list_type = "xblog_pi1" 
      AND     EXTRACTVALUE(
                pi_flexform,
                \'//T3FlexForms/data/sheet[@index="tmpl"]/language/field[@index="settings.flexform.pi1.tmpl.grid"]/value\'
              ) IN (4,8) 
      AND     EXTRACTVALUE(
                pi_flexform,
                \'//T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageHeight"]/value\'
              ) = "165"
      AND     EXTRACTVALUE(
                pi_flexform,
                \'//T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageWidth"]/value\'
              ) = "220";
';

    $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');
    $row        = (array) $connection->query($query)->fetch();
    return $row['quantity'];
  }

  /**
   * @param  int  $pid
   * @return array
   * @throws DBALException
   */
  public static function SelectXBlogGrid($pid = null): array
  {
    $andWherePid = '';
    if ($pid)
    {
      $andWherePid = ' AND pid = ' . $pid;
    }

    $query = '
      SELECT  uid,
              pid,
              pi_flexform
      FROM    tt_content
      WHERE   CType = "list" 
      ' . $andWherePid . '
      AND     list_type = "xblog_pi1" 
      AND     EXTRACTVALUE(
                pi_flexform,
                \'//T3FlexForms/data/sheet[@index="tmpl"]/language/field[@index="settings.flexform.pi1.tmpl.grid"]/value\'
              ) IN (4,8) 
      AND     EXTRACTVALUE(
                pi_flexform,
                \'//T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageHeight"]/value\'
              ) = "165"
      AND     EXTRACTVALUE(
                pi_flexform,
                \'//T3FlexForms/data/sheet[@index="image"]/language/field[@index="settings.flexform.pi.image.imageWidth"]/value\'
              ) = "220";
';

    $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tt_content');
    $rows       = (array) $connection->query($query)->fetchAll();
    return $rows;
  }

}
