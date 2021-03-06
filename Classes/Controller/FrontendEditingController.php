<?php

namespace Netzmacher\Browser\Controller;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 - 2016 -  Dirk Wildt <http://wildt.at.die-netzmacher.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Class for rendering a HTML page by TCPDF methods
 *
 * @package TYPO3
 * @subpackage browser
 * @author Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @version 7.4.0
 * @since 7.4.0
 * @internal #i0215
 */
class FrontendEditingController extends ActionController
{

  /**
   * @var array Extension Configuration from ext_conf_template.txt
   */
  private $_aExtConf;

  /**
   * @var array Powermail GET and POST params
   */
  private $_aPowermailGP;

  /**
   * @var array record for an INSERT or an UPDATE
   */
  private $_feUserRecordKeyValues = array();

  /**
   * @var object
   */
  private $_oParamsPowermail;

  /**
   * @var int Last inserted id
   */
  private $_aTableSQLLastID;

  /**
   * @var TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
   */
  private $_oCObj;

  /**
   * @var Netzmacher\Browser\Utility\FrontendEditing\DRS
   */
  private $_oDRS;

  /**
   * @var Netzmacher\Browser\Utility\FrontendEditing\TCA
   */
  private $_oTCA;

  /**
   * @var Netzmacher\Browser\Utility\FrontendEditing\Tables
   */
  private $_oTables;

  /**
   * @var string The current table
   */
  private $_sCurrentTable;

  /**
   * @var string The current table properties
   */
  private $_sCurrentTableProperties;

  /**
   * @var int The uid of the current table record
   */
  private $_sCurrentTableRecordUid;

  /**
   * @var string Path to powermail uploads. Without any ending slash
   */
  private $_sPowermailPath = 'uploads/tx_powermail';

//  /**
//   * @var boolean Flag for the DRS - Development Reporting System
//   */
//  protected $b_drs_all = FALSE;
//  protected $b_drs_error = FALSE;
//  protected $b_drs_warn = FALSE;
//  protected $b_drs_info = FALSE;
//  protected $b_drs_frontendediting = FALSE;

  /**
   * dataAction( ) : Create PDF from HTML (using TCPDF through t3_tcpdf extension)
   *          * Provides a PDF file for download
   *          * It prints the HTML content in debug mode
   *
   * @return void
   * @access public
   * @version 7.4.0
   * @since 7.4.0
   * @internal #i0215
   *
   */
  public function dataAction()
  {
    $this->_init();
    if ( !$this->_isPowermailActionCreate() )
    {
      $prompt = 'Nothing to do: Powermail action isn\'t "create"';
      $this->_DRSprompt( $prompt, __LINE__ );
      return;
    }
    $this->_tables();
//    var_dump( __METHOD__, __LINE__ );
//    die();
  }

  /**
   * _DRSprompt( ) :
   *
   * @param string $prompt
   * @param int $line
   * @param int $type
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   *
   */
  private function _DRSprompt( $prompt, $line = __LINE__, $type = 0 )
  {
    if ( !$this->_oDRS->getDrsFrontendEditing() )
    {
      return;
    }
    GeneralUtility::devlog( '[INFO/FE] ' . $prompt, __CLASS__ . '#' . $line, $type );
  }

  /**
   * _DRSpromptData( ) :
   *
   * @param array $data
   * @param int $line
   * @param int $type
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   *
   */
  private function _DRSpromptData( $data, $line = __LINE__, $type = 0 )
  {
    if ( !$this->_oDRS->getDrsFrontendEditing() )
    {
      return;
    }

    foreach ( $data AS $field => $value )
    {
      $aPrompt[] = $field . ': "' . $value . '"';
    }
    $prompt = implode( ', ', ( array ) $aPrompt );
    $prompt = 'Fields are added to cObj. Fields are available by TypoScript! ' . $prompt;
    $this->_DRSprompt( $prompt, $line, $type );
  }

  /**
   * _SQLError( ) :
   *
   * @param string $query
   * @param int $line
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _SQLError( $query, $line = __LINE__ )
  {
    $sqlError = $GLOBALS[ 'TYPO3_DB' ]->sql_error();
    if ( empty( $sqlError ) )
    {
      return;
    }

    $sqlErrno = $GLOBALS[ 'TYPO3_DB' ]->sql_errno();
    $header = 'SQL-ERROR';
    $text = ''
            . '<p>'
            . '  Error: ' . $sqlError . '<br />'
            . '  Error number: ' . $sqlErrno . '<br />'
            . '  Query: ' . $query . '<br />'
            . '</p>'
    ;
    $this->_zzDieWiPrompt( $header, $text, __METHOD__, $line );
  }

  /**
   * _SQLInsert( ) :
   *
   * @param string $table
   * @param integer $data
   * @param int $line
   * @param boolean $bPromptQueryOnly
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _SQLInsert( $table, $data, $line = __LINE__, $bPromptQueryOnly = 0 )
  {
    $query = $GLOBALS[ 'TYPO3_DB' ]->INSERTquery(
            $table
            , $data
    );

    switch ( $bPromptQueryOnly )
    {
      case(TRUE):
        $this->_DRSprompt( 'Query: ' . $query, $line );
        var_dump( __METHOD__, __LINE__, $query );
        break;
      case(FALSE):
      default:
        $this->_DRSprompt( 'Query: ' . $query, $line );
        $GLOBALS[ 'TYPO3_DB' ]->exec_INSERTquery(
                $table
                , $data
        );
        $this->_aTableSQLLastID[ $table ] = $GLOBALS[ 'TYPO3_DB' ]->sql_insert_id();
        $this->_SQLError( $query, $line );
        break;
    }
  }

  /**
   * _SQLUpdate( ) :
   *
   * @param string $table
   * @param integer $uid
   * @param integer $data
   * @param int $line
   * @param boolean $bPromptQueryOnly
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _SQLUpdate( $table, $uid, $data, $line = __LINE__, $bPromptQueryOnly = 0 )
  {
    $query = $GLOBALS[ 'TYPO3_DB' ]->UPDATEquery(
            $table
            , 'uid = ' . $uid
            , $data
    );

    switch ( $bPromptQueryOnly )
    {
      case(TRUE):
        $this->_DRSprompt( 'Query: ' . $query, $line );
        var_dump( __METHOD__, __LINE__, $query );
        break;
      case(FALSE):
      default:
        $this->_DRSprompt( 'Query: ' . $query, $line );
        $GLOBALS[ 'TYPO3_DB' ]->exec_UPDATEquery(
                $table
                , 'uid = ' . $uid
                , $data
        );
        $this->_aTableSQLLastID[ $table ] = $uid;
        $this->_SQLError( $query, $line );
        break;
    }
  }

  /**
   * _dataActionError( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _dataActionError( $prompt = 'Sorry, an unknown error occurs.' )
  {
    $this->_dataActionErrorUnsetPowermailAction();
// pi6PromptError
    $this->view->assignMultiple(
            array(
              'condition' => 'error',
              'prompterror' => 'TYPO3 Browser Frontend Editing - ERROR: ' . $prompt
            )
    );
  }

  /**
   * _dataActionErrorUnsetPowermailAction( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _dataActionErrorUnsetPowermailAction()
  {
    unset( $_GET[ 'tx_powermail_pi1' ][ 'action' ] );
    unset( $_POST[ 'tx_powermail_pi1' ][ 'action' ] );
  }

  /**
   * _dataActionSuccess( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _dataActionSuccess( $prompt = 'Your posting was successful.' )
  {
// pi6PromptSuccess
    $this->view->assignMultiple(
            array(
              'condition' => 'success',
              'promptsuccess' => 'TYPO3 Browser Frontend Editing: ' . $prompt
            )
    );
    unset( $_GET[ 'tx_powermail_pi1' ][ 'action' ] );
    unset( $_POST[ 'tx_powermail_pi1' ][ 'action' ] );
  }

  /**
   * _init( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _init()
  {
    $this->_initExtConf();
//    $this->_initDrs();
    $this->_initClasses();
    $this->_setPowermailGP();
    $this->_initTables();
    $this->_initDRS();
    $this->_initTCA();
  }

  /**
   * _initClasses( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClasses()
  {
    $this->_initClassesDRS();
    $this->_initClassesObjectManager();
    $this->_initClassesCObj();
    $this->_initClassesPowermailParams();
    $this->_initClassesTCA();
    $this->_initClassesTables();
  }

  /**
   * _initClassesCObj( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClassesCObj()
  {
    $this->_oCObj = $this->_oObjectManager->get(
            'TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'
    );
  }

  /**
   * _initClassesDRS( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClassesDRS()
  {
    $this->_oDRS = GeneralUtility::makeInstance( 'Netzmacher\\Browser\\Utility\\FrontendEditing\\DRS' );
  }

  /**
   * _initClassesObjectManager( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClassesObjectManager()
  {
    $this->_oObjectManager = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager' );
  }

  /**
   * _initClassesPowermailParams( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClassesPowermailParams()
  {
    $this->_oParamsPowermail = GeneralUtility::makeInstance( 'Netzmacher\\Browser\\Utility\\FrontendEditing\\Params\\Powermail' );
  }

  /**
   * _initClassesTCA( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClassesTCA()
  {
    $this->_oTCA = GeneralUtility::makeInstance( 'Netzmacher\\Browser\\Utility\\FrontendEditing\\TCA' );
  }

  /**
   * _initClassesTables( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initClassesTables()
  {
    $this->_oTables = GeneralUtility::makeInstance( 'Netzmacher\\Browser\\Utility\\FrontendEditing\\Tables' );
  }

//
//  /**
//   * _initDrs( ) :
//   *
//   * @return void
//   * @access private
//   * @version 7.4.0
//   * @since 7.4.0
//   */
//  private function _initDrs()
//  {
//    $drsMode = $this->_aExtConf[ 'drs_mode' ];
//
//    switch ( $drsMode )
//    {
//      case('All'):
//      case('Frontend Editing'):
//        $this->b_drs_all = TRUE;
//        $this->b_drs_error = TRUE;
//        $this->b_drs_warn = TRUE;
//        $this->b_drs_info = TRUE;
//        $this->b_drs_frontendediting = TRUE;
//        $prompt = 'DRS - Development Reporting System: ' . $drsMode;
//        GeneralUtility::devlog( '[INFO/DRS] ' . $prompt, __CLASS__, 0 );
//        break;
//      case('Warnings and errors'):
//        $this->b_drs_error = TRUE;
//        $this->b_drs_warn = TRUE;
//        $prompt = 'DRS - Development Reporting System: ' . $drsMode;
//        GeneralUtility::devlog( '[INFO/DRS] ' . $prompt, __CLASS__, 0 );
//        break;
//      default:
//        break;
//    }
//  }

  /**
   * _initDRS( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initDRS()
  {
    $this->_oTCA->setDRS( $this->_oDRS );
    $this->_oTables->setDRS( $this->_oDRS );
  }

  /**
   * _initTCA( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initTCA()
  {
    $this->_oTables->setTCA( $this->_oTCA );
  }

  /**
   * _initExtConf( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initExtConf()
  {
    $this->_aExtConf = unserialize( $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'EXT' ][ 'extConf' ][ 'browser' ] );
  }

  /**
   * _initTables( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _initTables()
  {
    $this->_aTables = array();

    // if fe_users exits, it should be the firt element in $_aTables
    if ( isset( $this->settings[ 'mapping' ][ 'fe_users' ] ) )
    {
      $this->_aTables[ 'fe_users' ] = array(
        'uid' => 'new',
        'query' => array(
          'fields' => array(
          ),
        ),
        'postProcess' => array(
        ),
      );
    }

    foreach ( array_keys( ( array ) $this->settings[ 'mapping' ] ) AS $table )
    {
      switch ( TRUE )
      {
        case( $table == 'fe_users'):
        case( $table == '_typoScriptNodeValue'):
          continue;
        default:
          $this->_aTables[ $table ] = array(
            'uid' => 'new',
            'query' => array(
              'fields' => array(
              ),
            ),
            'postProcess' => array(
            ),
          );
          break;
      }
    }

//    var_dump( __METHOD__, __LINE__, array_keys( $this->settings[ 'mapping' ] ), $this->_aTables );
  }

  /**
   * _isPowermailActionCreate( ) :
   *
   * @return boolean
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _isPowermailActionCreate()
  {
    if ( $this->_aPowermailGP[ 'action' ] != 'create' )
    {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * _processForeignTable( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processForeignTable( $table, $field )
  {
    $config = BackendUtility::getTcaFieldConfiguration( $table, $field );
    switch ( TRUE )
    {
      case(isset( $config[ 'MM' ] )):
        $this->_processForeignTableMM( $table, $field );
        break;
      default:
        $this->_processForeignTableCSV( $table, $field );
        break;
    }
  }

  /**
   * _processForeignTableCSV( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processForeignTableCSV( $table, $field )
  {
    $record = $this->_oTables->getTableRecordKeyValues( $table );

    // Get update date
    $value = $record[ $field ];
    if ( is_array( $value ) )
    {
      $value = implode( ', ', $value );
    }
    $updateData = array(
      $field => $value
    );

    // Get the uid
    $tableField = $table . '.uid';
    $uid = $this->_oCObj->data[ $tableField ];
    $this->_SQLUpdate( $table, $uid, $updateData, __LINE__ );
  }

  /**
   * _processForeignTableMM( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processForeignTableMM( $table, $field )
  {
    $config = BackendUtility::getTcaFieldConfiguration( $table, $field );

    $mmTable = $config[ 'MM' ];
    foreach ( ( array ) $config[ 'MM_match_fields' ] AS $key => $value )
    {
      $staticInsertData[ $key ] = $value;
    }

    switch ( TRUE )
    {
      case(isset( $config[ 'MM_oppositeUsage' ] )):
        $header = 'ERROR: non supported TCA configuration';
        $text = $table . '.' . $field . ' is configured with "MM_oppositeUsage".';
        $this->_zzDieWiPrompt( $header, $text, __METHOD__, __LINE__ );
        break;
      case(isset( $config[ 'MM_opposite_field' ] )):
        $labelUidLocal = 'uid_foreign';
        $labelUidForeign = 'uid_local';
        break;
      case(!isset( $config[ 'MM_opposite_field' ] )):
        $labelUidLocal = 'uid_local';
        $labelUidForeign = 'uid_foreign';
      default:
        break;
    }

    // Get the uid
    $tableField = $table . '.uid';
    $uidLocal = $this->_oCObj->data[ $tableField ];

    // Get the values
    $record = $this->_oTables->getTableRecordKeyValues( $table );
    $aValues = $record[ $field ];

    if ( !is_array( $aValues ) )
    {
      $aValues = array(
        0 => $aValues
      );
    }
    foreach ( ( array ) $aValues AS $uidForeign )
    {
      $insertData = $staticInsertData;
      $insertData[ $labelUidLocal ] = $uidLocal;
      $insertData[ $labelUidForeign ] = $uidForeign;
      $this->_SQLInsert( $mmTable, $insertData, __LINE__ );
    }
  }

  /**
   * _processInternalType( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalType( $table, $field )
  {
    $config = BackendUtility::getTcaFieldConfiguration( $table, $field );
    switch ( $config[ 'internal_type' ] )
    {
      case('db'):
        $this->_processInternalTypeDB( $table, $field );
        break;
      case('file'):
        $this->_processInternalTypeFile( $table, $field );
        break;
      default:
        $tableField = $table . '.' . $field;
        $header = 'ERROR: undefined key';
        $key = $config[ 'internal_type' ];
        $text = $tableField . ': Key for internal_type isn\'t defined! Key is "' . $key . '"';
        $this->_zzDieWiPrompt( $header, $text, __METHOD__, __LINE__ );
        break;
    }
  }

  /**
   * _processInternalTypeDB( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeDB( $table, $field )
  {
    $this->_processForeignTable( $table, $field );
  }

  /**
   * _processInternalTypeFile( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeFile( $table, $field )
  {
    if ( !$this->_processInternalTypeFileCopy( $table, $field ) )
    {
      return;
    }

    $this->_processInternalTypeFileUpdate( $table, $field );
  }

  /**
   * _processInternalTypeFileUpdate( ) :
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeFileUpdate( $table, $field )
  {
    $tableField = $table . '.' . $field;
    $updateData = array(
      $field => $this->_oCObj->data[ $tableField ]
    );
    $uid = $this->_sCurrentTableRecordUid[ $table ];
    $this->_SQLUpdate( $table, $uid, $updateData, __LINE__ );

//    var_dump( __METHOD__, __LINE__, $table, $field, $file, $this->_sCurrentTableRecordUid );
//    $header = 'ERROR: undefined key';
//    $key = $config[ 'internal_type' ];
//    $text = $tableField . ': Key for internal_type isn\'t defined! Key is "' . $key . '"';
//    $this->_zzDieWiPrompt( $header, $text, __METHOD__, __LINE__ );
  }

  /**
   * _processInternalTypeFileCopy( ) :
   *
   * @param string $table
   * @param string $field
   * @return boolean
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeFileCopy( $table, $field )
  {
    $srce = $this->_processInternalTypeFileCopySrce( $table, $field );
    $dest = $this->_processInternalTypeFileCopyDest( $table, $field );
    $bSuccess = copy( $srce, $dest );
    $this->_processInternalTypeFileCopyDRS( $srce, $dest, $bSuccess );

    return $bSuccess;
  }

  /**
   * _processInternalTypeFileCopyDRS( ) :
   *
   * @param string $srce
   * @param string $dest
   * @param boolean $bSuccess
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeFileCopyDRS( $srce, $dest, $bSuccess )
  {
    switch ( $bSuccess )
    {
      case( TRUE ):
        $prompt = 'File is moved from ' . $srce . ' to ' . $dest;
        $this->_DRSprompt( $prompt, __LINE__, -1 );
        break;
      case( FALSE ):
      default:
        $prompt = 'ERROR! File couldn\'t moved from ' . $srce . ' to ' . $dest;
        $this->_DRSprompt( $prompt, __LINE__, 3 );
        break;
    }
  }

  /**
   * _processInternalTypeFileCopyDest( ) : Rteurns the absolute path for the file destination
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeFileCopyDest( $table, $field )
  {
    $config = BackendUtility::getTcaFieldConfiguration( $table, $field );
    $tableField = $table . '.' . $field;
    $file = $this->_oCObj->data[ $tableField ];
    $path = $config[ 'uploadfolder' ] . '/' . $file;
    $absPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName( $path );
    return $absPath;
  }

  /**
   * _processInternalTypeFileCopySrce( ) : Returns the absolute path to the file uploaded by powermail
   *
   * @param string $table
   * @param string $field
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _processInternalTypeFileCopySrce( $table, $field )
  {
    $tableField = $table . '.' . $field;
    $file = $this->_oCObj->data[ $tableField ];
    $path = $this->_sPowermailPath . '/' . $file;
    $absPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName( $path );
    return $absPath;
  }

  /**
   * _setCObjStart( ) :
   *
   * @param string $table
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _setCObjStart( $table )
  {
    $data = $this->_setCObjStartData();
    $this->_DRSpromptData( $data, __LINE__ );
    $this->_oCObj->start( $data, $table );
  }

  /**
   * _setCObjStartData( ) :
   *
   * @return array
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _setCObjStartData()
  {
    $data = $this->_setCObjStartDataPowermail();
    return $data;
  }

  /**
   * _setCObjStartDataPowermail( ) :
   *
   * @return array
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _setCObjStartDataPowermail()
  {
    foreach ( ( array ) $this->_aPowermailGP AS $key => $value )
    {
      if ( is_array( $value ) )
      {
        $value = implode( ', ', $value );
      }
      $data[ $key ] = $value;
      list($table, $field) = explode( '__', $key );
      if ( $field )
      {
        $tableField = $table . '.' . $field;
        $data[ $tableField ] = $value;
      }
    }
    return $data;
  }

  /**
   * _setCurrentTableRecordUid( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _setCurrentTableRecordUid()
  {
    $table = $this->_sCurrentTable;
    $uid = $this->_aTableSQLLastID[ $table ];
    $tableField = $table . '.uid';

    $this->_sCurrentTableRecordUid[ $table ] = $uid;
    $this->_aTables[ $this->_sCurrentTable ][ 'uid' ] = $uid;
    $this->_oCObj->data[ $tableField ] = $uid;
    $this->_DRSpromptData( array( $tableField => $uid ), __LINE__ );
  }

  /**
   * _setPowermailGP( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _setPowermailGP()
  {
    $this->_aPowermailGP = $this->_oParamsPowermail->getGP();
  }

  /**
   * _tables( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tables()
  {
    $this->_setCObjStart( 'fe_users' );
    $this->_oTables->setCObj( $this->_oCObj );

    foreach ( array_keys( ( array ) $this->_aTables ) AS $this->_sCurrentTable )
    {
      $this->_oTables->main( $this->_sCurrentTable, $this->settings );
      if ( empty( $this->_oTables->getKeyValues() ) )
      {
        $this->_dataActionError( 'No data transferred! Table: ' . $this->_sCurrentTable );
        continue;
      }

      $this->_tablesProcess();
    }
    $this->_tablesPostProcess();
  }

  /**
   * _tablesPostProcess( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesPostProcess()
  {
    $aTCATableField = $this->_oTCA->getTableField();
    foreach ( array_keys( ( array ) $aTCATableField ) AS $TCATable )
    {
      if ( !in_array( $TCATable, array_keys( ( array ) $this->_aTables ) ) )
      {
        $prompt = 'Nothing to do: ' . $TCATable . ' isn\'t any element of $_aTables';
        $this->_DRSprompt( $prompt, __LINE__ );
        continue;
      }
      $this->_tablesPostProcessFields( $TCATable );
    }
  }

  /**
   * _tablesPostProcessFields( ) :
   *
   * @param string $table
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesPostProcessFields( $table )
  {
    $aTCATableField = $this->_oTCA->getTableField();
    foreach ( ( array ) $aTCATableField[ $table ] AS $field => $properties )
    {
      if ( !is_array( $properties[ 'postProcess' ] ) )
      {
        continue;
      }
      switch ( $properties[ 'postProcess' ][ 'key' ] )
      {
        case( 'foreign_table'):
          $this->_processForeignTable( $table, $field );
          break;
        case( 'internal_type'):
          $this->_processInternalType( $table, $field );
          break;
        default:
          $tableField = $table . '.' . $field;
          $header = 'ERROR: undefined key';
          $key = $properties[ 'postProcess' ][ 'key' ];
          $text = $tableField . ': Key for postProcess isn\'t defined! Key is "' . $key . '"';
          $this->_zzDieWiPrompt( $header, $text, __METHOD__, __LINE__ );
          break;
      }
    }
  }

  /**
   * _tablesProcess( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesProcess()
  {
    switch ( TRUE )
    {
      case($this->_sCurrentTable == 'fe_users'):
        $this->_tablesProcessFeUsers();
        break;
      case($this->_sCurrentTable != 'fe_users'):
      default:
        $this->_tablesProcessMain();
        break;
    }
  }

  /**
   * _tablesProcessFeUsers( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesProcessFeUsers()
  {
    switch ( $this->_oTables->getIsLoggedIn() )
    {
      case(TRUE):
        $this->_tablesSQLUpdate();
        break;
      case(FALSE):
      default:
        $this->_tablesSQLInsert();
        break;
    }
  }

  /**
   * _tablesProcessMain( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesProcessMain()
  {
    $this->_tablesSQLInsert();
  }

  /**
   * _tablesSQLInsert( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesSQLInsert()
  {
    $insertData = $this->_oTables->getKeyValues();
    $table = $this->_sCurrentTable;

    $this->_SQLInsert( $table, $insertData );

    $this->_setCurrentTableRecordUid();

    //$this->_dataActionError( 'Update isn\'t possible.' );
    $uid = $this->_sCurrentTableRecordUid[ $table ];
    //$this->_dataActionSuccess( $table . ' data is inserted successfully with uid #' . $uid );
  }

  /**
   * _tablesSQLUpdate( ) :
   *
   * @return void
   * @access private
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _tablesSQLUpdate()
  {
    //$updateData = $this->_feUserRecordKeyValues;
    $updateData = $this->_oTables->getKeyValues();

    switch ( TRUE )
    {
      case( isset( $updateData[ 'uid' ] ) ):
        $uid = $updateData[ 'uid' ];
        unset( $updateData[ 'uid' ] );
        break;
      default:
        $table = 'Table: ' . $this->_sCurrentTable;
        $sUpdateData = 'Data: ' . implode( ',', $updateData );
        $sUpdateData = 'Data: ' . json_encode( $updateData );
        $header = 'SQL-ERROR: uid is missing';
        $text = 'Current data doesn\'t contain the uid! ' . $table . '. ' . $sUpdateData;
        $this->_zzDieWiPrompt( $header, $text, __METHOD__, __LINE__ );
        break;
    }

    $this->_SQLUpdate( $this->_sCurrentTable, $uid, $updateData, __LINE__ );

    $this->_setCurrentTableRecordUid();
    //$this->_dataActionError( 'Update isn\'t possible.' );
    $this->_dataActionSuccess( 'fe_users data is updated successfully' );
  }

  /**
   * _zzDieWiPrompt( ) :
   *
   * @access private
   * @return boolean
   * @version 7.4.0
   * @since 7.4.0
   */
  private function _zzDieWiPrompt( $header, $text, $method, $line )
  {
    $prompt = '
      <h1 style="color:red;">
        ' . $header . '
      </h1>
      ' . $text . '
      <p>
        Sorry for the trouble. Browser - TYPO3 without PHP<br />
        Error occures here: ' . $method . ' at #' . $line . '
      </p>
      <p>
        If you need any help, please visit the
        <a href="http://typo3-browser-forum.de/" target="_blank" title="TYPO3 Browser Forums. 500 TYPO3-integrators are registered.">
          TYPO3 Browser Forum &raquo;</a>
      </p>
      ';
    die( $prompt );
  }

}
