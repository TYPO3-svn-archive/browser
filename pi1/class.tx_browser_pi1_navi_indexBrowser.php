<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2016 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 * The class tx_browser_pi1_navi_indexBrowser bundles methods for the index browser
 * or the page broser. It is part of the extension browser
 *
 * @author      Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package     TYPO3
 * @subpackage  browser
 * @version     6.0.7
 * @since       3.9.9
 */

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *  120: class tx_browser_pi1_navi_indexBrowser
 *  213:     public function __construct($parentObj)
 *
 *              SECTION: Main
 *  245:     public function get( $content )
 *
 *              SECTION: Requirements
 *  350:     private function localisation_init( )
 *  410:     private function localisation_consolidate( )
 *  528:     private function requirements_check( )
 *  606:     private function tableField_check( )
 *  657:     private function tableField_init( )
 *
 *              SECTION: Subparts
 *  746:     private function subpart( )
 *  792:     private function subpart_setContainer( )
 *  813:     private function subpart_setTabs( )
 *
 *              SECTION: Tabs
 *  911:     private function tabs_init( )
 * 1002:     private function tabs_initAttributes( $csvAttributes, $tabLabel, $tabId )
 * 1050:     private function tabs_initFindInSetForCurrentTab( )
 * 1137:     private function tabs_initProperties( $conf_tabs, $tabId, $tabLabel, $displayWoItems )
 * 1200:     private function tabs_initSpecialChars( $arrCsvAttributes )
 *
 *              SECTION: Count chars
 * 1261:     private function count_chars( )
 * 1304:     private function count_chars_addSumToTab( $res )
 * 1458:     private function count_chars_resSqlCount( $currSqlCharset )
 * 1515:     private function count_chars_resSqlCountDefLL( $strFindInSet, $currSqlCharset )
 * 1560:     private function count_chars_resSqlCountSelOrDefLL( $strFindInSet, $currSqlCharset )
 *
 *              SECTION: Count special chars
 * 1657:     private function count_specialChars( )
 * 1697:     private function count_specialChars_addSum( $row )
 * 1745:     private function count_specialChars_resSqlCount( $length, $arrfindInSet, $currSqlCharset )
 * 1798:     private function count_specialChars_resSqlCountDefLL( $length, $strFindInSet, $currSqlCharset )
 * 1857:     private function count_specialChars_resSqlCountSelOrDefLL( $length, $strFindInSet, $currSqlCharset )
 *
 *              SECTION: SQL statements
 * 1951:     private function sqlCharsetGet( )
 * 1984:     private function sqlCharsetSet( $sqlCharset )
 * 2008:     private function sqlStatement_from( $table )
 * 2035:     private function sqlStatement_where( $table, $andWhereFindInSet )
 * 2086:     private function sqlStatement_whereAndFindInSet( $where, $findInSet )
 *
 *              SECTION: Downward compatibility
 * 2134:     public function getMarkerIndexbrowser( )
 * 2180:     private function getMarkerIndexbrowserTabs( )
 *
 *              SECTION: Helper - ascii
 * 2238:     private function zz_specCharsToASCII( $string )
 *
 *              SECTION: Helper - SQL
 * 2273:     private function zz_sqlCountInitialsLL( $length, $uidListDefAndCurr, $currSqlCharset )
 * 2341:     private function zz_sqlIdsOfDefLL( $strFindInSet, $currSqlCharset )
 * 2416:     private function zz_sqlIdsOfTranslatedLL( $strFindInSet, $uidListOfDefLL, $currSqlCharset )
 *
 *              SECTION: Helper - SQL FIND IN SET
 * 2535:     private function zz_getFindInSetForAllByte( $row )
 * 2555:     private function zz_getFindInSetForMultibyte( $row )
 * 2576:     private function zz_getFindInSetFromLength( $row, $fromLength )
 * 2606:     private function zz_getSqlLengthAsRow( $arrChars )
 *
 *              SECTION: Helper - tabs
 * 2686:     private function zz_setTabClassSelected( $tabId )
 * 2738:     private function zz_setTabPiVars( $labelAscii, $label )
 * 2769:     private function zz_setTabPiVarsDefaultTab( $label )
 * 2802:     private function zz_tabClass( $lastTabId, $tab, $key )
 * 2835:     private function zz_tabDefaultLabel( )
 * 2853:     private function zz_tabDefaultLink( )
 * 2896:     private function zz_tabLinkLabel( $tab )
 * 2937:     private function zz_tabLastId( )
 * 2995:     private function zz_tabTitle( $sum )
 *
 * TOTAL FUNCTIONS: 49
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_browser_pi1_navi_indexBrowser
{

  //////////////////////////////////////////////////////
  //
    // Variables set by the pObj (by class.tx_browser_pi1.php)

  var $conf = false;
  // [Array] The current TypoScript configuration array
  var $mode = false;
  // [Integer] The current mode (from modeselector)
  var $view = false;
  // [String] 'list' or 'single': The current view
  var $conf_view = false;
  // [Array] The TypoScript configuration array of the current view
  var $conf_path = false;
  // [String] TypoScript path to the current view. I.e. views.single.1
  // Variables set by the pObj (by class.tx_browser_pi1.php)
  // [Array] piVars backup
  var $piVarsBak = null;
  // [Array] Array with tabIds and tabLabels
  var $indexBrowserTab = array();
//  'tabSpecial' =>
//    'default' => '0',
//    'all' => 0,
//    'others' => 25,
//    'selected' => 0,
//  'tabIds' =>
//    0 =>
//      'label' => 'Alle',
//      'displayWoItems' => '1',
//      'sum' => 0,
//      'special' => 'all',
//    1 =>
//    ...
//  'tabLabels' =>
//    'Alle' => 0,
//    '0-9' => 1,
//    'A' => 2,
//    ...
//  'attributes' =>
//    0 =>
//      'tabLabel' => '0-9',
//      'tabId' => 1,
//    ...
//    'Z' =>
//      'tabLabel' => 'XYZ',
//      'tabId' => 24,
  // [String] table.field of the index browser
  var $indexBrowserTableField = null;
  // [Array] Array with the find in set statements for special chars
  var $findInSet = array();
  // [String/CSV] Comma seperated list of all records of the current language and the default language,
  //              which aren't translated
  var $uidListDefaultAndCurrentLL = null;
  // [Boolean] true: don't localise the current SQL query, false: localise it
  var $bool_dontLocalise = null;
  // [Integer] number of the localisation mode
  var $int_localisation_mode = null;
  // [String] Subpart for the index browser
  var $subpart = null;
  // [String] Subpart for a tab within the index browser
  var $subpartTab = null;
  // [Boolean] Should the deafult tab get a link?
  var $linkDefaultTab = null;
  // [String] Label of the default tab
  var $tabDefaultLabel = null;
  // [Boolean] Run class code in language consolidation mode? true : yes; false : no.
  var $bool_LLconsolidationMode = false;

  /**
   * Constructor. The method initiate the parent object
   *
   * @param    object        The parent object
   * @return    void
   * @version  3.9.9
   * @since    3.9.9
   */
  public function __construct( $parentObj )
  {
    // Set the Parent Object
    $this->pObj = $parentObj;
    // 111023, uherrmann, #9912: t3lib_div::convUmlauts() is deprecated
    $this->t3lib_cs_obj = t3lib_div::makeInstance( 't3lib_cs' );
  }

  /*   * *********************************************
   *
   * Main
   *
   * ******************************************** */

  /**
   * get( ): Get the index browser. It has to replace the subpart in the current content.
   *
   * @param    string        $content: current content
   * @return    array
   * @version 3.9.12
   * @since   3.9.9
   */
  public function get( $content )
  {
    // Prompt the expired time to devlog
    $debugTrailLevel = 1;
    $this->pObj->timeTracking_log( $debugTrailLevel, 'begin' );

    $this->content = $content;
//    $arr_return['data']['content']  = $content;
    // RETURN: requirements aren't met
    $arr_return = $this->requirements_check();
    if ( !empty( $arr_return ) )
    {
      // Prompt the expired time to devlog
      $debugTrailLevel = 1;
      $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
      return $arr_return;
    }
    // RETURN: requirements aren't met
    // RETURN : table is not the local table
    $arr_return = $this->tableField_check();
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      // Prompt the expired time to devlog
      $debugTrailLevel = 1;
      $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
      return $arr_return;
    }
    // RETURN : table is not the local table
    // Backup $GLOBALS['TSFE']->id
    $globalTsfeId = $GLOBALS[ 'TSFE' ]->id;
    // Setup $GLOBALS['TSFE']->id temporarily
    if ( !empty( $this->pObj->objFlexform->int_viewsListPid ) )
    {
      $GLOBALS[ 'TSFE' ]->id = $this->pObj->objFlexform->int_viewsListPid;
    }
    // Setup $GLOBALS['TSFE']->id temporarily
    // Init the tabs
    $arr_return = $this->tabs_init();
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      // Reset $GLOBALS['TSFE']->id
      $GLOBALS[ 'TSFE' ]->id = $globalTsfeId;
      // Prompt the expired time to devlog
      $debugTrailLevel = 1;
      $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
      return $arr_return;
    }
    // Init the tabs
    // Render the tabs
    $arr_return = $this->subpart();
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      // Reset $GLOBALS['TSFE']->id
      $GLOBALS[ 'TSFE' ]->id = $globalTsfeId;
      // Prompt the expired time to devlog
      $debugTrailLevel = 1;
      $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
      return $arr_return;
    }
    // Render the tabs
    // If a tab is selected, store the SQL FIND IN SET
    $this->tabs_initFindInSetForCurrentTab();

    // Reset $GLOBALS['TSFE']->id
    $GLOBALS[ 'TSFE' ]->id = $globalTsfeId;
    // Prompt the expired time to devlog
    $debugTrailLevel = 1;
    $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
    return $arr_return;
  }

  /*   * *********************************************
   *
   * Requirements
   *
   * ******************************************** */

  /**
   * localisation_init( ):  Inits the localisation mode and localisation TS
   *                            Sets the class vars
   *                            * $int_localisation_mode
   *                            * bool_dontLocalise
   *
   * @return    void
   * @version 3.9.11
   * @since   3.9.11
   * @todo  120503: Remove $this->bool_dontLocalise from the method and from the class
   */
  private function localisation_init()
  {

    // Set class var $int_localisation_mode; init TS of pObj->objLocalise;
    if ( !isset( $this->int_localisation_mode ) )
    {
      $this->int_localisation_mode = $this->pObj->objLocalise->get_localisationMode();
      $this->pObj->objLocalise->init_typoscript();
    }

//
//      // Set class var $bool_dontLocalise
//      // SWITCH $int_localisation_mode
//    switch( $this->int_localisation_mode )
//    {
//      case( PI1_DEFAULT_LANGUAGE ):
//        $this->bool_dontLocalise = true;
//        $prompt = 'Localisation mode is PI1_DEFAULT_LANGUAGE. There isn\' any need to localise!';
//        break;
//      case( PI1_DEFAULT_LANGUAGE_ONLY ):
//        $this->bool_dontLocalise = true;
//        $prompt = 'Localisation mode is PI1_DEFAULT_LANGUAGE_ONLY. There isn\' any need to localise!';
//        break;
//      default:
//        $this->bool_dontLocalise = false;
//        $prompt = 'Localisation mode is enabled';
//        break;
//    }
//      // SWITCH $int_localisation_mode
//      // Set class var $bool_dontLocalise
    $this->bool_dontLocalise = false;

//      // DRS
//    if( $this->pObj->b_drs_navi || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
//    {
//      t3lib_div::devlog( '[INFO/NAVI+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
//    }
//      // DRS

    return;
  }

  /**
   * localisation_consolidate( )  : The method is called by tabs_init( ). If a localised language
   *                                is used by the website visitor, this method call again:
   *                                * $this->count_specialChars( )
   *                                * $this->count_chars( )
   *                                but for the default language only.
   *                                The counted hits will substracted of the hits, which were
   *                                counted before for the default language and the localised
   *                                language.
   *
   * @return    array        $arr_return: Contains an error message in case of an error
   * @version 3.9.13
   * @since   3.9.10
   * @internal  #36842
   * @todo      120506, dwildt: Method seem's to be waste.
   */
  private function localisation_consolidate()
  {
    // DRS
    if ( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Method localisation_consolidate( ) seem\'s to be waste!';
      t3lib_div::devlog( '[WARN/TODO] ' . $prompt, $this->pObj->extKey, 2 );
    }
    // DRS
    return;

//    if( $this->pObj->b_drs_navi )
//    {
//      $prompt = 'localisation_consolidate( )';
//      t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
//    }
//
//    static $thisMethodIsUsed = false;
//
//    // RETURN : method is called twice at least
//    if ( $thisMethodIsUsed )
//    {
//      return;
//    }
//    // RETURN : method is called twice at least
//    // Don't call method twice
//    $thisMethodIsUsed = true;
//
//    // SWITCH $int_localisation_mode
//    switch ( $this->int_localisation_mode )
//    {
//      case( PI1_DEFAULT_LANGUAGE ):
//        // RETURN : nothing to do
//        if ( $this->pObj->b_drs_localise || $this->pObj->b_drs_navi )
//        {
//          $prompt = 'Index browser doesn\'t need any localisation consolidation. Localisation is PI1_DEFAULT_LANGUAGE.';
//          t3lib_div::devlog( '[INFO/LOCALISATION+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
//        }
//        return false;
//        break;
//      case( PI1_DEFAULT_LANGUAGE_ONLY ):
//        if ( $this->pObj->b_drs_localise || $this->pObj->b_drs_navi )
//        {
//          $prompt = 'Index browser doesn\'t need any localisation consolidation. Localisation is PI1_DEFAULT_LANGUAGE_ONLY.';
//          t3lib_div::devlog( '[INFO/LOCALISATION+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
//        }
//        // RETURN : nothing to do
//        return false;
//        break;
//      case( $this->pObj->objFltr4x->get_selectedFilters() ):
//        if ( $this->pObj->b_drs_localise || $this->pObj->b_drs_navi )
//        {
//          $prompt = 'Index browser doesn\'t need any localisation consolidation. A filter is selected.';
//          t3lib_div::devlog( '[INFO/LOCALISATION+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
//        }
//        // RETURN : nothing to do
//        return false;
//        break;
//      case( PI1_SELECTED_OR_DEFAULT_LANGUAGE ):
//        if ( $this->pObj->b_drs_localise || $this->pObj->b_drs_navi )
//        {
//          $prompt = 'Index browser: Hits of the default language will substracted.';
//          t3lib_div::devlog( '[INFO/LOCALISATION+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
//        }
//        // Store current localisation mode
//        $curr_int_localisation_mode = $this->int_localisation_mode;
//        // Set all to default language
//        $this->int_localisation_mode = PI1_DEFAULT_LANGUAGE;
//        //$this->pObj->objLocalise->int_localisation_mode = PI1_DEFAULT_LANGUAGE;
//        $this->pObj->objLocalise->setLocalisationMode( PI1_DEFAULT_LANGUAGE );
//        $this->bool_LLconsolidationMode = true;
//        // Set all to default language
//        // Substract of special char tabs the hits of default language
//        $arr_return = $this->count_specialChars();
//        if ( !( empty( $arr_return ) ) )
//        {
//          // Restore former localisation mode
//          $this->bool_LLconsolidationMode = false;
//          $this->int_localisation_mode = $curr_int_localisation_mode;
//          //$this->pObj->objLocalise->int_localisation_mode = $curr_int_localisation_mode;
//          $this->pObj->objLocalise->setLocalisationMode( $curr_int_localisation_mode );
//          // Restore former localisation mode
//          // RETURN : Array with error prompt in case of an error
//          return $arr_return;
//        }
//        // Substract of special char tabs the hits of default language
//        // Substract of default char tabs the hits of default language
//        $arr_return = $this->count_chars();
//        // Restore former localisation mode
//        $this->bool_LLconsolidationMode = false;
//        $this->int_localisation_mode = $curr_int_localisation_mode;
//        //$this->pObj->objLocalise->int_localisation_mode = $curr_int_localisation_mode;
//        $this->pObj->objLocalise->setLocalisationMode( $curr_int_localisation_mode );
//        // Restore former localisation mode
//        // RETURN : Array with error prompt in case of an error
//        return $arr_return;
//        // Substract of default char tabs the hits of default language
//        break;
//      default:
//        // DIE
//        $this->pObj->objLocalise->zz_promptLLdie( __METHOD__, __LINE__ );
//        break;
//    }
//    // SWITCH $int_localisation_mode
  }

  /**
   * requirements_check( ): Checks
   *                        * configuration of the flexform
   *                        * configuration of TS tabs
   *                        It returns true, if a requirement isn't met
   *
   * @return    mixed        true or array, if a requirement isn't met
   * @version 4.8.5
   * @since   3.9.9
   * @todo  120503: Remove $this->bool_dontLocalise. It isn't needed.
   */
  private function requirements_check()
  {
    // RETURN true : index browser is disabled
    if ( !$this->pObj->objFlexform->bool_indexBrowser )
    {
      if ( $this->pObj->b_drs_navi )
      {
        $prompt = 'display.indexBrowser is false.';
        t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
      }
      return true;
    }
    // RETURN true : index browser is disabled

    if ( $this->requirementsRoute() )
    {
      return true;
    }

    $this->localisation_init();

    // RETURN true : index browser hasn't any configured tab
    $arr_conf_tabs = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'tabs.' ];
    if ( !is_array( $arr_conf_tabs ) )
    {
      // The index browser isn't configured
      if ( $this->pObj->b_drs_navi )
      {
        $prompt = 'navigation.indexBrowser.tabs hasn\'t any element.';
        t3lib_div::devlog( '[WARN/NAVIGATION] ' . $prompt, $this->pObj->extKey, 2 );
        $prompt = 'navigation.indexBrowser won\'t be processed.';
        t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
      }
      $arr_return = array();
      $arr_return[ 'error' ][ 'status' ] = true;
      $arr_return[ 'error' ][ 'header' ] = '<h1 style="color:red">Error Index Browser</h1>';
      $prompt = 'Index browser is enabled by the flexform or by TypoScript. ' .
              'But the TypoScript navigation.indexBrowser.tabs hasn\'t any element. ' .
              'Please take care of a proper TypoScript or disable the index browser.';
      $arr_return[ 'error' ][ 'prompt' ] = '<p style="color:red">' . $prompt . '</p>';
      return $arr_return;
    }
    // RETURN true : index browser hasn't any configured tab
    // RETURN false : requirements are OK
    return false;
  }

  /**
   * requirementsRoute( ):
   *
   * @return	boolean   true, if requirements are met; false if not
   * @internal #i0042
   * @version 4.8.5
   * @since   4.8.5
   */
  private function requirementsRoute()
  {
    // #i0042, 131225, dwildt, ~
    $this->pObj->objMap->init();
    switch ( $this->pObj->objMap->enabled )
    {
      case( 'Map +Routes' ) :
        if ( $this->pObj->b_drs_warn )
        {
          $prompt = 'Sorry, indexBrowser isn\'t possible. Map +Routes is used.';
          t3lib_div :: devLog( '[WARN/MAP/NAVI] ' . $prompt, $this->pObj->extKey, 2 );
        }
        return true;
      // map isn't enabled
      case( 1 ) :
      case( 'Map' ) :
      case( false ) :
      case( 'disabled' ) :
      default :
        if ( $this->pObj->b_drs_map || $this->pObj->b_drs_navi )
        {
          $prompt = 'indexBrowser is possible. Map status is "' . $this->pObj->objMap->enabled . '".';
          t3lib_div :: devLog( '[INFO/MAP/NAVI] ' . $prompt, $this->pObj->extKey, 0 );
        }
        return false;
    }

    return true;
  }

  /**
   * tableField_check( ): Checks, if the table.field of the index browser
   *                      corresponds with the local table.
   *                      Sets the class var $indexBrowserTableField.
   *
   * @return    array        $arr_return : Contains an error message in case of an error
   * @version 3.9.11
   * @since   3.9.9
   */
  private function tableField_check()
  {
    // Init the table.field
    $this->tableField_init();

    list( $table ) = explode( '.', $this->indexBrowserTableField );

    // RETURN : table is the local table
    if ( $table == $this->pObj->localTable )
    {
      return;
    }
    // RETURN : table is the local table
    // Error management
    $prompt_01 = 'Sorry, the index browser can\'t handle an index for foreign tables!';
    $prompt_02 = 'Current table.field is: ' . $this->indexBrowserTableField;
    $prompt_03 = 'Local table is: ' . $this->pObj->localTable;
    $prompt_04 = 'Please configure: ' . $this->conf_path . 'indexBrowser.field = ' . $this->pObj->localTable . '... ';
    if ( $this->pObj->b_drs_navi )
    {
      t3lib_div::devlog( '[ERROR/NAVIGATION] ' . $prompt_01, $this->pObj->extKey, 3 );
      t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt_02, $this->pObj->extKey, 0 );
      t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt_03, $this->pObj->extKey, 0 );
      t3lib_div::devlog( '[HELP/NAVIGATION] ' . $prompt_04, $this->pObj->extKey, 1 );
    }

    $arr_return = array();
    $arr_return[ 'error' ][ 'status' ] = true;
    $arr_return[ 'error' ][ 'header' ] = '<h1 style="color:red">Error Index-Browser</h1>';
    $prompt = $prompt_01 . '<br />' . PHP_EOL;
    $prompt = $prompt . $prompt_02 . '<br />' . PHP_EOL;
    $prompt = $prompt . $prompt_03 . '<br />' . PHP_EOL;
    $prompt = $prompt . $prompt_04 . '<br />' . PHP_EOL;
    $arr_return[ 'error' ][ 'prompt' ] = '<p style="color:red">' . $prompt . '</p>';
    // Error management
    // RETURN error message
    return $arr_return;
  }

  /**
   * tableField_init( ):  Set the class var $this->indexBrowserTableField
   *                      Value is the table.field for SQL queries
   *
   * @return    void
   * @version 3.9.11
   * @since   3.9.9
   */
  private function tableField_init()
  {

    // RETURN : table.field for the index browser form is set in the current view
    if ( isset( $this->conf_view[ 'navigation.' ][ 'indexBrowser.' ][ 'field' ] ) )
    {
      $this->indexBrowserTableField = $this->conf_view[ 'navigation.' ][ 'indexBrowser.' ][ 'field' ];
      if ( !empty( $this->indexBrowserTableField ) )
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = $this->conf_path . 'indexBrowser.field is ' . $this->indexBrowserTableField;
          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
        }
        return;
      }
    }
    // RETURN : table.field for the index browser form is set in the current view
    // RETURN : table.field for the index browser form is set in global configuration
    if ( isset( $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'field' ] ) )
    {
      $this->indexBrowserTableField = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'field' ];
      if ( !empty( $this->indexBrowserTableField ) )
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = 'indexBrowser.field is ' . $this->indexBrowserTableField;
          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
        }
        return;
      }
    }
    // RETURN : table.field  for the index browser form is set in global configuration
    // The user hasn't defined a table.field element.
    // We take the first one of the field views.list.X.select
    // Get the first table of the global arr_realTables_arrFields
    reset( $this->pObj->arr_realTables_arrFields );
    $table = key( $this->pObj->arr_realTables_arrFields );
    // First field of the current table
    $field = $this->pObj->arr_realTables_arrFields[ $table ][ 0 ];
    $this->indexBrowserTableField = $table . '.' . $field;
    // Get the first table of the global arr_realTables_arrFields
    // DIE : undefined error
    if ( empty( $this->indexBrowserTableField ) )
    {
      $header = 'FATAL ERROR!';
      $text = 'indexBrowserTableField is empty.';
      $this->pObj->drs_die( $header, $text );
    }
    // DIE : undefined error
    // DRS
    if ( $this->pObj->b_drs_navi )
    {
      $prompt = 'indexBrowser.field is the first table.field from ' .
              $this->conf_path . 'select: ' . $this->indexBrowserTableField;
      t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
      $prompt = 'If you need another table.field use ' . $this->conf_path . 'indexBrowser.field';
      t3lib_div::devlog( '[HELP/NAVIGATION] ' . $prompt, $this->pObj->extKey, 1 );
    }
    // DRS
  }

  /*   * *********************************************
   *
   * Subparts
   *
   * ******************************************** */

  /**
   * subpart( ): Returns the content for the index browser subpart
   *
   * @return    array        $arr_return : Content or an erreor message in case of an error
   * @version 3.9.12
   * @since   3.9.9
   */
  private function subpart()
  {
    $arr_return = array();

    // Set class vars subpart and $arr_return
    $marker = $this->getMarkerIndexBrowser();
    $this->subpart = $this->pObj->cObj->getSubpart( $this->content, $marker );
    $markerTabs = $this->getMarkerIndexbrowserTabs();
    $this->subpartTab = $this->pObj->cObj->getSubpart( $this->subpart, $markerTabs );
    // Set class vars subpart and $arr_return

    if ( empty( $this->subpart ) )
    {
      // #i0207, 151130, dwildt, 1+
      return null;
      // #i0207, 151130, dwildt, -
//      if ( $this->b_drs_error )
//      {
//        $prompt = 'Current template doesn\'t contain the subpart marker ###' . $marker . '###';
//        t3lib_div::devLog( '[ERROR/NAVIGATION+TEMPLATING] ' . $prompt, $this->pObj->extKey, 3 );
//      }
//      $str_header = '<h1 style="color:red;">' . $this->pObj->pi_getLL( 'error_readlog_h1' ) . '</h1>';
//      $str_prompt = '<p style="color:red;font-weight:bold;">' . $this->pObj->pi_getLL( 'error_template_indexbrowser_no_subpart' ) . '</p>';
//      $arr_return[ 'error' ][ 'status' ] = true;
//      $arr_return[ 'error' ][ 'header' ] = $str_header;
//      $arr_return[ 'error' ][ 'prompt' ] = $str_prompt;
//      return $arr_return;
    }

    // Set class var $tabDefaultLabel
    $this->zz_tabDefaultLabel();

    // Set the subpart for the tabs
    $arr_return = $this->subpart_setTabs();
    if ( !( empty( $arr_return ) ) )
    {
      return $arr_return;
    }
    // Set the subpart for the tabs
    // Set the whole subpart
    $arr_return = $this->subpart_setContainer();
    if ( !( empty( $arr_return ) ) )
    {
      return $arr_return;
    }
    // Set the whole subpart
    // Replace the subpart tabs in the whole subpart
    $content = $this->pObj->cObj->substituteSubpart( $this->subpart, $markerTabs, $this->subpartTab, true );

    // Retirn the content
    $arr_return[ 'data' ][ 'content' ] = $content;
    return $arr_return;
  }

  /**
   * subpart_setContainer( ): Replace markers in the subpart for the index browser
   *                          but not the subpart ###TABS###
   *
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.9
   */
  private function subpart_setContainer()
  {
    $markerArray[ '###MODE###' ] = $this->mode;
    $markerArray[ '###VIEW###' ] = $this->view;
    $markerArray[ '###MODE###' ] = $this->mode;
    $markerArray[ '###UL_MODE###' ] = $this->mode;
    $markerArray[ '###VIEW###' ] = $this->view;
    $markerArray[ '###UL_VIEW###' ] = $this->view;

    $this->subpart = $this->pObj->cObj->substituteMarkerArray( $this->subpart, $markerArray );
  }

  /**
   * subpart_setTabs( ): Set the content in the subpart for the tabs
   *
   * @return	void
   * @version 4.1.26
   * @since   3.9.12
   */
  private function subpart_setTabs()
  {
    $content = null;

    $this->linkDefaultTab = $this->zz_tabDefaultLink();
    $bool_dontLinkDefaultTab = false;
    if ( $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'defaultTab.' ][ 'display_in_url' ] == 0 )
    {
      $bool_dontLinkDefaultTab = true;
      // #7582, Bugfix, 100501
      if ( $this->pObj->objFlexform->bool_emptyAtStart )
      {
        $bool_dontLinkDefaultTab = false;
        // DRS - Development Reporting System
        if ( $this->pObj->b_drs_templating )
        {
          t3lib_div::devlog( '[WARN/TEMPLATING] Empty list by start is true and the default tab of the index browser shouldn\'t linked with a piVar. ' .
                  'This is not proper.', $this->pObj->extKey, 2 );
          t3lib_div::devlog( '[INFO/TEMPLATING] The default tab of the index browser will be linked with a piVar by the system!', $this->pObj->extKey, 0 );
        }
      }
    }
    // Get the tab array
    ( array ) $arrTabs = $this->indexBrowserTab[ 'tabIds' ];
    // get id of the last visible tab
    $lastTabId = $this->zz_tabLastId();

    // LOOP : tabs
    foreach ( ( array ) $this->indexBrowserTab[ 'tabIds' ] as $key => $tab )
    {
      if ( $tab[ 'sum' ] < 1 && !$tab[ 'displayWoItems' ] )
      {
        continue;
      }

      // Wrap the label
      if ( isset( $tab[ 'wrap' ] ) )
      {
        $tab[ 'label' ] = str_replace( '|', $tab[ 'label' ], $tab[ 'wrap' ] );
      }
      if ( !( isset( $tab[ 'wrap' ] ) ) )
      {
        $tab[ 'label' ] = str_replace
                (
                '|', $tab[ 'label' ], $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'defaultTabWrap' ]
        );
      }
      $markerArray = array();

      // Get class
      $class = $this->zz_tabClass( $lastTabId, $tab, $key );
      $markerArray[ '###CLASS###' ] = $class;
      $markerArray[ '###LI_CLASS###' ] = $class;

      // SWITCH : sum of hits of tab, display without items
      switch ( true )
      {
        case(!empty( $tab[ 'sum' ] ) ):
          // Tab with hits
          $markerArray[ '###TAB###' ] = $this->zz_tabLinkLabel( $tab );
          break;
        case( $tab[ 'displayWoItems' ] ):
          // Tab without hits
          // #43732, #i0109, 141214, dwildt
          //$class = 'class="ui-tabs-anchor without-href"';
          $class = 'class="' . $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'classes.' ][ 'a.' ][ 'empty' ] . '"';
          $tab[ 'label' ] = '<a ' . $class . '>' . $tab[ 'label' ] . '</a>';
//$this->pObj->dev_var_dump( $tab['label'] );
          $markerArray[ '###TAB###' ] = $tab[ 'label' ];
          break;
        default:
          continue;
      }
      // SWITCH : sum of hits of tab, display without items
      // Set the content
      $content = $content . $this->pObj->cObj->substituteMarkerArray( $this->subpartTab, $markerArray );
    }
    // LOOP : tabs
    // Set the class var subpartTab
    $this->subpartTab = $content;
  }

  /*   * *********************************************
   *
   * Tabs
   *
   * ******************************************** */

  /**
   * tabs_init( ):    Sets the class var $indexBrowserTab
   *
   * @return    array        $arr_return: Contains an error message in case of an error
   * @version 3.9.11
   * @since   3.9.10
   */
  private function tabs_init()
  {
    // Prompt the expired time to devlog
    $debugTrailLevel = 1;
    $this->pObj->timeTracking_log( $debugTrailLevel, 'begin' );

    $arrCsvAttributes = array();

    // Get tabSpecial property default
    $this->indexBrowserTab[ 'tabSpecial' ][ 'default' ] = null;
    if ( isset( $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'defaultTab' ] ) )
    {
      $this->indexBrowserTab[ 'tabSpecial' ][ 'default' ] = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'defaultTab' ];
    }
    // Get tabSpecial property default
    // Get default property display tabs without any item
    $defaultDisplayWoItems = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'display.' ][ 'tabWithoutItems' ];

    // LOOP tabs TS configuratione array
    $conf_tabs = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'tabs.' ];
    foreach ( ( array ) $conf_tabs as $tabId => $tabLabel )
    {
      // CONTINUE : key is an array
      if ( substr( $tabId, -1 ) == '.' )
      {
        continue;
      }
      // CONTINUE : key is an array
      // Get attributes
      $csvAttributes = $conf_tabs[ $tabId . '.' ][ 'valuesCSV' ];
      $csvAttributes = str_replace( ' ', null, $csvAttributes );
      $arrCsvAttributes[] = $csvAttributes;

      // Init tab attributes
      $this->tabs_initAttributes( $csvAttributes, $tabLabel, $tabId );
      // Init tab properties
      $this->tabs_initProperties( $conf_tabs, $tabId, $tabLabel, $defaultDisplayWoItems );
    }
    // LOOP tabs TS configuratione array
    // Init special chars
    $this->tabs_initSpecialChars( $arrCsvAttributes );

    // Count special chars
    $arr_return = $this->count_specialChars();
    // RETURN : error prompt
    if ( !( empty( $arr_return ) ) )
    {
      // Prompt the expired time to devlog
      $debugTrailLevel = 1;
      $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
      return $arr_return;
    }
    // RETURN : error prompt
    // Count special chars
    // Count chars
    $arr_return = $this->count_chars();
    // RETURN : error prompt
    if ( !( empty( $arr_return ) ) )
    {
      // Prompt the expired time to devlog
      $debugTrailLevel = 1;
      $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
      return $arr_return;
    }
    // RETURN : error prompt
    // Count chars
    // #36842, dwildt, 120504
    $this->localisation_consolidate();

    // Prompt the expired time to devlog
    $debugTrailLevel = 1;
    $this->pObj->timeTracking_log( $debugTrailLevel, 'end' );
  }

  /**
   * tabs_initAttributes( ):  Sets the array attributes of the class var $indexBrowserTab
   *
   * @param    string        $csvAttributes  : attributes
   * @param    string        $tabLabel       : label of the current tab
   * @param    integer        $tabId          : Id of the current tab
   * @return    array        $arr_return     : Contains an error message in case of an error
   * @version 3.9.11
   * @since   3.9.10
   */
  private function tabs_initAttributes( $csvAttributes, $tabLabel, $tabId )
  {
    // RETURN : no attributes
    if ( empty( $csvAttributes ) )
    {
      return;
    }
    // RETURN : no attributes
    // LOOP : attributes
    $attributes = explode( ',', $csvAttributes );
    foreach ( $attributes as $attribute )
    {
      // DRS : ERROR : attribute is part of two tabs at least
      if ( isset( $this->indexBrowserTab[ 'attributes' ][ $attribute ] ) )
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = 'The tab attribute ' . $attribute . ' is part of two tabs at least!';
          t3lib_div::devlog( '[ERROR/NAVI] ' . $prompt, $this->pObj->extKey, 3 );
          $prompt = 'You will get an unproper result for the index browser';
          t3lib_div::devlog( '[WARN/NAVI] ' . $prompt, $this->pObj->extKey, 2 );
          $prompt = $attribute . ' is part of tab[' . $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'tabLabel' ] . '] ' .
                  ' and of tab[' . $tabLabel . '] at least!';
          t3lib_div::devlog( '[WARN/NAVI] ' . $prompt, $this->pObj->extKey, 2 );
          $prompt = 'Please take care of a proper TypoScript configuration!';
          t3lib_div::devlog( '[HELP/NAVI] ' . $prompt, $this->pObj->extKey, 1 );
        }
      }
      // DRS : ERROR : attribute is part of two tabs at least
      // Set class var
      $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'tabLabel' ] = $tabLabel;
      $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'tabId' ] = $tabId;
    }
    // LOOP : attributes
  }

  /**
   * tabs_initFindInSetForCurrentTab( ) : Set the FIND IN SET SQL statement for the
   *                                      current tab. It is needed by the list view.
   *
   * @return    array        $ar_return  : Contains an error message in case of an error
   * @version 3.9.13
   * @since   3.9.13
   */
  private function tabs_initFindInSetForCurrentTab()
  {
    // RETURN : Any tab isn't selected
    if ( empty( $this->pObj->piVars[ 'indexBrowserTab' ] ) )
    {
      return;
    }
    // RETURN : Any tab isn't selected
    // Get the array id of the selected tab
    $labelAscii = $this->pObj->piVars[ 'indexBrowserTab' ];
    $tabId = $this->indexBrowserTab[ 'tabLabels' ][ $labelAscii ];
    // Get the array id of the selected tab
    // SWITCH : the special tab 'others'
    switch ( $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'special' ] )
    {
      case( 'others' ):
        // Get all defined attributes
        $attributes = $this->indexBrowserTab[ 'initials' ][ 'all' ];
        break;
      default:
        // Get the attributes of the selected tab
        $attributes = $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'attributes' ];
        break;
    }
    // SWITCH : the special tab 'others'
    // Get a row with the byte length og each attribute
    $arrChars = explode( ',', $attributes );
    $arr_return = $this->zz_getSqlLengthAsRow( $arrChars );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $row = $arr_return[ 'data' ][ 'row' ];
    // Get a row with the byte length og each attribute
    // RETURN : there isn't any SQL result
    if ( empty( $row ) )
    {
      return;
    }
    // RETURN : there isn't any SQL result
    // Get an array with all FIND IN SET statements
    $arrFindInSet = $this->zz_getFindInSetForAllByte( $row );
    if ( empty( $arrFindInSet ) )
    {
      return;
    }

    // Get the SQL statement for all FIND IN SET
    $orFindInSet = array();
    foreach ( $arrFindInSet as $length )
    {
      foreach ( $length as $statement )
      {
        $orFindInSet[] = $statement;
      }
    }
    $findInSet = implode( ' OR ', $orFindInSet );
    $findInSet = '( ' . $findInSet . ' )';
    // Get the SQL statement for all FIND IN SET
    // In case of special tab 'others' prepend a NOT
    if ( $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'special' ] == 'others' )
    {
      $findInSet = 'NOT ' . $findInSet;
    }
    // In case of special tab 'others' prepend a NOT
    // Set the class var $findInSetForCurrTab
    $this->findInSetForCurrTab = $findInSet;
  }

  /**
   * tabs_initProperties( ):  Sets the elements tabIds and tabLabels of the class var $indexBrowserTab
   *                          Updates the element tabSpecial.
   *
   * @param    array        $conf_tabs      : TS configuration array
   * @param    integer        $tabId          : Current tab ID for TS configuration array
   * @param    string        $tabLabel       : Label of the current tab
   * @param    boolean        $displayWoItems : Default value for displaying tabs without any hit
   * @return    array        $arr_return     : Contains an error message in case of an error
   * @version 3.9.11
   * @since   3.9.10
   */
  private function tabs_initProperties( $conf_tabs, $tabId, $tabLabel, $displayWoItems )
  {
    // Overwrite tab label in case of stdWrap
    if ( $conf_tabs[ $tabId . '.' ][ 'stdWrap.' ] )
    {
      $stdWrap = $conf_tabs[ $tabId . '.' ][ 'stdWrap.' ];
      $tabLabel = $this->pObj->objWrapper4x->general_stdWrap( $tabLabel, $stdWrap );
    }
    // Overwrite tab label in case of stdWrap
    // Overwrite property display without items
    if ( isset( $conf_tabs[ $tabId . '.' ][ 'displayWithoutItems' ] ) )
    {
      $displayWoItems = $conf_tabs[ $tabId . '.' ][ 'displayWithoutItems' ];
    }
    // Overwrite property display without items
    // Set labelAscii. Label for using in the URL
    $labelAscii = $this->zz_specCharsToASCII( $tabLabel );
    $attributes = $conf_tabs[ $tabId . '.' ][ 'valuesCSV' ];
    $attributes = trim( $attributes );
    $attributes = str_replace( ' ', null, $attributes );

    // Set tab array
    $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'label' ] = $tabLabel;
    $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'labelAscii' ] = $labelAscii;
    $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'displayWoItems' ] = $displayWoItems;
    $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'attributes' ] = $attributes;
    $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'sum' ] = 0;
    $this->indexBrowserTab[ 'tabLabels' ][ $labelAscii ] = $tabId;
    // Set tab selected
    $this->zz_setTabClassSelected( $tabId );
    // Set tab array
    // RETURN : tab with special value 'all'
    if ( $conf_tabs[ $tabId . '.' ][ 'special' ] == 'all' )
    {
      $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'special' ] = 'all';
      $this->indexBrowserTab[ 'tabSpecial' ][ 'all' ] = $tabId;
      return;
    }
    // RETURN : tab with special value 'all'
    // RETURN : tab with special value 'others'
    if ( $conf_tabs[ $tabId . '.' ][ 'special' ] == 'others' )
    {
      $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'special' ] = 'others';
      $this->indexBrowserTab[ 'tabSpecial' ][ 'others' ] = $tabId;
      return;
    }
    // RETURN : tab with special value 'others'
  }

  /**
   * tabs_initSpecialChars( ): Inits the array initials of the class var $indexBrowserTab
   *
   * @param    array        $arrCsvAttributes : initials from the tab TS configuration
   * @return    void
   * @version 3.9.11
   * @since   3.9.10
   */
  private function tabs_initSpecialChars( $arrCsvAttributes )
  {
    $matches = array();

    // Get initials unique
    $arrCsvAttributes = array_unique( ( array ) $arrCsvAttributes );
    $csvInitials = implode( ',', ( array ) $arrCsvAttributes );

    // Init vars with all initials
    $this->indexBrowserTab[ 'initials' ][ 'all' ] = $csvInitials;
    $this->indexBrowserTab[ 'initials' ][ 'specialChars' ] = null;
    $this->indexBrowserTab[ 'initials' ][ 'alphaNum' ] = null;

    // UTF-8 decode
    $subject = utf8_decode( $csvInitials );

    // Init var with special chars
    $pattern = '/[^0-9a-zA-Z,]/';
    if ( preg_match_all( $pattern, $subject, $matches ) )
    {
      $specialChars = implode( ',', $matches[ 0 ] );
      $this->indexBrowserTab[ 'initials' ][ 'specialChars' ] = utf8_encode( $specialChars );
    }
    // Init var with special chars
    // Init var with alpha numeric chars
    $pattern = '/[0-9a-zA-Z]/';
    if ( preg_match_all( $pattern, $subject, $matches ) )
    {
      $specialChars = implode( ',', $matches[ 0 ] );
      $this->indexBrowserTab[ 'initials' ][ 'alphaNum' ] = utf8_encode( $specialChars );
    }
    // Init var with alpha numeric chars
  }

  /*   * *********************************************
   *
   * Count chars
   *
   * ******************************************** */

  /**
   * count_chars( ): Updates sum / number of hits of chars (one byte)
   *
   * @return    array        $arr_return : Contains an erreor message in case of an error
   * @version 3.9.12
   * @since   3.9.11
   */
  private function count_chars()
  {
    // Get current SQL char set
    $currSqlCharset = $this->sqlCharsetGet();
    // Set SQL char set to latin1
    $this->sqlCharsetSet( 'latin1' );

    // SQL result with sum for records with one byte chars as first character
    $arr_return = $this->count_chars_resSqlCount( $currSqlCharset );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $res = $arr_return[ 'data' ][ 'res' ];
    // SQL result with sum for records with one byte chars as first character
    // Add the sum to the tabs
    $this->count_chars_addSumToTab( $res );

    // Free SQL result
    $GLOBALS[ 'TYPO3_DB' ]->sql_free_result( $res );

    // Reset SQL char set
    $this->sqlCharsetSet( $currSqlCharset );

    $arrUids = explode( ',', $this->uidListDefaultAndCurrentLL );
    sort( $arrUids, SORT_NUMERIC );
    $this->uidListDefaultAndCurrentLL = implode( ',', $arrUids );
  }

  /**
   * count_chars_addSumToTab( ) : Updates the sum in the arrays tabIds and attributes
   *                              of the class var $indexBrowserTab
   *
   * @param    array        $res  : SQL result
   * @return    void
   * @version 7.0.3
   * @since   3.9.11
   */
  private function count_chars_addSumToTab( $res )
  {
    // #i0139, 150311, dwildt, 4+
    if ( empty( $res ) )
    {
      return;
    }

    // WHILE $row
    while ( $row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res ) )
    {
      // Get values from the SQL row
      $attribute = $row[ 'initial' ];
      $rowSum = $row[ 'count' ];

      // Set attributes sum
      $sum = $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'sum' ];
      // #36842, dwildt, 120504
      if ( !$this->bool_LLconsolidationMode )
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = '$this->indexBrowserTab[attributes][' . $attribute . '][sum] : $sum = $rowSum (#' . $rowSum . ')';
          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
        }
        // Rows of the default language and a localised language optionally
        $sum = $rowSum;
      }
      else
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = '$this->indexBrowserTab[attributes][' . $attribute . '][sum] : $sum = $sum - $rowSum (#' .
                  $sum . ' - #' . $rowSum . ' = #' . ( $sum - $rowSum ) . ')';
          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
        }
        // Substract rows of the default language
        $sum = $sum - $rowSum;
      }
      $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'sum' ] = $sum;
      // Set attributes sum
      // Get id of the tab for all attributes
      $tabId = $this->indexBrowserTab[ 'tabSpecial' ][ 'all' ];
      // Get sum of the current tab
      $sum = $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'sum' ];
      // Add row sum to current sum
      // #36842, dwildt, 120504
      if ( !$this->bool_LLconsolidationMode )
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = '$this->indexBrowserTab[tabIds][' . $tabId . '][sum] : $sum = $sum + $rowSum (#' .
                  $sum . ' + #' . $rowSum . ' = #' . ( $sum + $rowSum ) . ')';
          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
        }
        // Rows of the default language and a localised language optionally
        $sum = $sum + $rowSum;
      }
      else
      {
        if ( $this->pObj->b_drs_navi )
        {
          $prompt = '$this->indexBrowserTab[tabIds][' . $tabId . '][sum] : $sum = $sum - $rowSum (#' .
                  $sum . ' - #' . $rowSum . ' = #' . ( $sum - $rowSum ) . ')';
          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
        }
        // Substract rows of the default language
        $sum = $sum - $rowSum;
      }



      // Allocates result to the current tab
      $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'sum' ] = $sum;

      // Get id of the tab others or of the tab with the current attribute
      if ( isset( $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'tabId' ] ) )
      {
        $tabId = $this->indexBrowserTab[ 'attributes' ][ $attribute ][ 'tabId' ];
      }
      else
      {
        $tabId = $this->indexBrowserTab[ 'tabSpecial' ][ 'others' ];
      }
      // Get id of the tab others or of the tab with the current attribute
      // Get sum of the current tab
      $sum = $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'sum' ];
      // Add row sum to current sum
      // #36842, dwildt, 120504
      if ( !$this->bool_LLconsolidationMode )
      {
//        if( $this->pObj->b_drs_navi )
//        {
//          $prompt = '$this->indexBrowserTab[tabIds][' . $tabId . '][sum] : $sum = $sum + $rowSum (#' . $sum . ' + #' . $rowSum . ')';
//          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
//        }
        // Rows of the default language and a localised language optionally
        $sum = $sum + $rowSum;
      }
      else
      {
//        if( $this->pObj->b_drs_navi )
//        {
//          $prompt = '$this->indexBrowserTab[tabIds][' . $tabId . '][sum] : $sum = $sum - $rowSum (#' . $sum . ' - #' . $rowSum . ')';
//          t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
//        }
        // Substract rows of the default language
        $sum = $sum - $rowSum;
      }
      // Allocates result to the current tab

      $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'sum' ] = $sum;
    }
    // WHILE $row

    if ( $this->pObj->b_drs_navi )
    {
      foreach ( ( array ) $this->indexBrowserTab[ 'attributes' ] as $attribute => $arrAttribute )
      {
        $sum = $arrAttribute[ 'sum' ];
        $prompt = '$this->indexBrowserTab[attributes][' . $attribute . '][sum] = #' . $sum;
        switch ( true )
        {
          case( $sum > 0 ) :
            t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
            break;
          case( $sum < 0 ) :
            t3lib_div::devlog( '[ERROR/NAVIGATION] ' . $prompt, $this->pObj->extKey, 3 );
            break;
        }
      }
      foreach ( ( array ) $this->indexBrowserTab[ 'tabIds' ] as $tabId => $arrTabId )
      {
        $sum = $arrTabId[ 'sum' ];
        $prompt = '$this->indexBrowserTab[tabIds][' . $tabId . '][sum] = #' . $sum;
        switch ( true )
        {
          case( $sum > 0 ) :
            t3lib_div::devlog( '[INFO/NAVIGATION] ' . $prompt, $this->pObj->extKey, 0 );
            break;
          case( $sum < 0 ) :
            t3lib_div::devlog( '[ERROR/NAVIGATION] ' . $prompt, $this->pObj->extKey, 3 );
            break;
        }
      }
    }
  }

  /**
   * count_chars_resSqlCount( ): SQL query and execution for counting initials
   *
   * @param    string        $currSqlCharset : Current SQL charset for reset in error case
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 3.9.13
   * @since   3.9.11
   */
  private function count_chars_resSqlCount( $currSqlCharset )
  {
    // Build FIND IN SET
    $strFindInSet = null;
    foreach ( $this->findInSet as $arrfindInSet )
    {
      $strFindInSet = $strFindInSet . implode( " OR ", $arrfindInSet );
    }
    if ( !empty( $strFindInSet ) )
    {
      $strFindInSet = "NOT (" . $strFindInSet . ")";
    }
    // Build FIND IN SET
    // SWITCH $int_localisation_mode
    switch ( $this->int_localisation_mode )
    {
      case( PI1_DEFAULT_LANGUAGE ):
      case( PI1_DEFAULT_LANGUAGE_ONLY ):
        $arr_return = $this->count_chars_resSqlCountDefLL( $strFindInSet, $currSqlCharset );
        break;
      case( PI1_SELECTED_OR_DEFAULT_LANGUAGE ):
        $arr_return = $this->count_chars_resSqlCountSelOrDefLL( $strFindInSet, $currSqlCharset );
        break;
      default:
        // DIE
        $this->pObj->objLocalise->zz_promptLLdie( __METHOD__, __LINE__ );
        break;
    }
    // SWITCH $int_localisation_mode

    return $arr_return;
  }

  /**
   * count_chars_resSqlCountDefLL( ):
   *
   * @param    string        $strFindInSet : Current SQL charset for reset in error case
   * @param    [type]        $currSqlCharset: ...
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 4.8.7
   * @since   3.9.11
   */
  private function count_chars_resSqlCountDefLL( $strFindInSet, $currSqlCharset )
  {
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );
    $tableUid = $table . ".uid";

    $caseSensitive = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'caseSensitive' ];
    switch ( $caseSensitive )
    {
      case( true ) :
        // 140227, dwildt, 1-
//        $uid      = $tableUid;
        $initial = $tableField;
        break;
      case( false ) :
      default:
        // #41051, 120918, dwildt, 2-
//        $uid      = "UPPER ( " . $tableUid . " )";
//        $initial  = "UPPER ( " . $tableField . " )";
        // #44125, 121218, dwildt, 3-
//          // #41051, 120918, dwildt, 2+
//        $uid      = "upper ( " . $tableUid . " )";
//        $initial  = "upper ( " . $tableField . " )";
        // #44125, 121218, dwildt, 3+
        // #41051, 120918, dwildt, 2+
        // 140227, dwildt, 1-
//        $uid      = "upper( " . $tableUid . " )";
        $initial = "upper( " . $tableField . " )";
        break;
    }

    // Query for all filter items
    // #44125, 121218, dwildt, 1-
//    $select = "COUNT( DISTINCT " . $uid . " ) AS 'count', LEFT ( " . $initial . ", 1 ) AS 'initial'";
    // 140227, dwildt, 2-
//      // #44125, 121218, dwildt, 1+
//    $select = "COUNT( DISTINCT " . $uid . " ) AS 'count', LEFT( " . $initial . ", 1 ) AS 'initial'";
    // 140227, dwildt, 1+
    $select = "COUNT( DISTINCT " . $tableUid . " ) AS 'count', LEFT( " . $initial . ", 1 ) AS 'initial'";
    // #56329, 140226, dwildt, 1+
    $selectSubQuery = $tableUid . " AS '" . $tableUid . "'";
    $from = $this->sqlStatement_from( $table );
    $where = $this->sqlStatement_where( $table, $strFindInSet );
    // #44125, 121218, dwildt, 3-
//    $select = "COUNT( DISTINCT " . $uid . " ) AS 'count', LEFT ( " . $initial . ", 1 ) AS 'initial'";
//    $groupBy  = "LEFT ( " . $initial . ", 1 )";
//    $orderBy  = "LEFT ( " . $initial . ", 1 )";
    // #44125, 121218, dwildt, 3+
    $groupBy = "LEFT( " . $initial . ", 1 )";
    $orderBy = "LEFT( " . $initial . ", 1 )";
    $limit = null;

//      // Execute the query
//    $arr_return = $this->pObj->objSqlFun->exec_SELECTquery
//                  (
//                    $select,
//                    $from,
//                    $where,
//                    $groupBy,
//                    $orderBy,
//                    $limit
//                  );
    // Get queries
    $query = $GLOBALS[ 'TYPO3_DB' ]->SELECTquery
            (
            $select, $from, $where, $groupBy, $orderBy, $limit
    );
    // #56329, 140226, dwildt, 6+
    $groupBy = null;
    $orderBy = null;
    $subQueryTemplate = $GLOBALS[ 'TYPO3_DB' ]->SELECTquery
            (
            $selectSubQuery, $from, $where, $groupBy, $orderBy, $limit
    );
    // Get queries
    // #56329, 140226, dwildt, 1+
    $query = $this->pObj->objViewlist->queryWiAndFilter( $query, $limit, $subQueryTemplate );
    //$this->pObj->dev_var_dump(str_replace('\'', '"', $query));
    // Execute query
    $promptOptimise = 'Maintain the performance? Reduce the relations: reduce the filter. ' .
            'Don\'t use the query in a localised context.';
    $debugTrailLevel = 1;
    $arr_return = $this->pObj->objSqlFun->sql_query( $query, $promptOptimise, $debugTrailLevel );
    // Execute query
    // Error management
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      $this->sqlCharsetSet( $currSqlCharset );
    }

    return $arr_return;
  }

  /**
   * count_chars_resSqlCountSelOrDefLL( ) : SQL query and execution for counting initials
   *
   * @param    string        $currSqlCharset : Current SQL charset for reset in error case
   * @param    [type]        $currSqlCharset: ...
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 3.9.13
   * @since   3.9.11
   */
  private function count_chars_resSqlCountSelOrDefLL( $strFindInSet, $currSqlCharset )
  {
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );

    // Label of field with the uid of the record with the default language
    $parentUid = $GLOBALS[ 'TCA' ][ $table ][ 'ctrl' ][ 'transOrigPointerField' ];

    // RETURN : table isn't localised
    if ( empty( $parentUid ) )
    {
      if ( $this->pObj->b_drs_localisation || $this->pObj->b_drs_navi )
      {
        $prompt = 'Index browser won\'t be localised, because ' . $table . ' hasn\'t any transOrigPointerField.';
        t3lib_div::devlog( '[INFO/LOCALISATION+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
      }
      $arr_return = $this->count_chars_resSqlCountDefLL( $strFindInSet, $currSqlCharset );
    }

    // Get Ids of all (!) default language records
    $arr_return = $this->zz_sqlIdsOfDefLL( $strFindInSet, $currSqlCharset );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $arr_rows = $arr_return[ 'data' ][ 'rows' ];
    $uidListOfDefLL = implode( ',', ( array ) $arr_rows );
//    var_dump( __METHOD__, __LINE__, $uidListOfDefLL );
    // Get Ids of all (!) default language records
    // Get Ids of all (!) translated language records
    $arr_return = $this->zz_sqlIdsOfTranslatedLL( $strFindInSet, $uidListOfDefLL, $currSqlCharset );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $arr_rowsLL = $arr_return[ 'data' ][ 'rows' ];
//    $uidListOfCurrLanguage  = implode( ',', ( array ) $arr_rowsLL['uid'] );
//    var_dump( __METHOD__, __LINE__, $uidListOfCurrLanguage );
    // Get Ids of all (!) translated language records
    // Substract uids of default language records, which are translated
    $arr_rowsDefWoTranslated = array_diff( ( array ) $arr_rows, ( array ) $arr_rowsLL[ $parentUid ] );


//    var_dump( __METHOD__, __LINE__, 'array_diff' );
//    var_dump( __METHOD__, __LINE__, $arr_rows );
//    var_dump( __METHOD__, __LINE__, $arr_rowsLL[$parentUid] );
//    var_dump( __METHOD__, __LINE__, $arr_rowsDefWoTranslated );
    // Add uids of translated recors
    $arr_rowsDefWiCurr = array_merge( ( array ) $arr_rowsDefWoTranslated, ( array ) $arr_rowsLL[ 'uid' ] );

//    var_dump( __METHOD__, __LINE__, 'array_merge' );
//    var_dump( __METHOD__, __LINE__, $arr_rowsDefWoTranslated );
//    var_dump( __METHOD__, __LINE__, $arr_rowsLL['uid'] );
//    var_dump( __METHOD__, __LINE__, $arr_rowsDefWiCurr );
    // Sort the array of uids
    sort( $arr_rowsDefWiCurr, SORT_NUMERIC );

    // Get list of uids from the array
    $uidListDefAndCurr = implode( ',', ( array ) $arr_rowsDefWiCurr );

    // Count initials
    $length = 1;
    $arr_return = $this->zz_sqlCountInitialsLL( $length, $uidListDefAndCurr, $currSqlCharset );

    // RETURN : the sql result
    return $arr_return;
  }

  /*   * *********************************************
   *
   * Count special chars
   *
   * ******************************************** */

  /**
   * count_specialChars( ): Updates sum / number of hits of sepcial chars (multy byte)
   *
   * @return    array        $arr_return : Contains an erreor message in case of an error
   * @version 3.9.12
   * @since   3.9.10
   */
  private function count_specialChars()
  {
    // RETURN : no special chars
    if ( empty( $this->indexBrowserTab[ 'initials' ][ 'specialChars' ] ) )
    {
      return;
    }
    // RETURN : no special chars
    // Get a row with the SQL length for each special char
    $arrSpecialChars = explode( ',', $this->indexBrowserTab[ 'initials' ][ 'specialChars' ] );
    $arr_return = $this->zz_getSqlLengthAsRow( $arrSpecialChars );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $row = $arr_return[ 'data' ][ 'row' ];
    unset( $arr_return );
    // Get a row with the SQL length for each special char
    // Get the sum for each special char initial
    $arr_return = $this->count_specialChars_addSum( $row );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    // Get the sum for each special char initial
  }

  /**
   * count_specialChars_addSum( ): Updates sum / number of hits of sepcial chars
   *
   * @param    array        $row        : Row with special chars and their SQL length
   * @return    array        $arr_return : Contains an erreor message in case of an error
   * @version 3.9.12
   * @since   3.9.10
   */
  private function count_specialChars_addSum( $row )
  {
    // Get current SQL char set
    $currSqlCharset = $this->sqlCharsetGet();
    // Set SQL char set to latin1
    $this->sqlCharsetSet( 'latin1' );

    // Set class var findInSet
    $this->findInSet = $this->zz_getFindInSetForMultibyte( $row );
    //$this->findInSet[$length][] = "FIND_IN_SET( LEFT ( " . $tableField . ", " . $length . " ), '" . $char . "' )";
    // LOOP : find in set for each special char length group
    foreach ( ( array ) $this->findInSet as $length => $arrfindInSet )
    {
      // SQL result with sum for records with a sepecial char as first character
      $arr_return = $this->count_specialChars_resSqlCount( $length, $arrfindInSet, $currSqlCharset );
      if ( $arr_return[ 'error' ][ 'status' ] )
      {
        return $arr_return;
      }
      $res = $arr_return[ 'data' ][ 'res' ];
      // SQL result with sum for records with a sepecial char as first character
      // Add the sum to the tab with the special char attribute
      $this->count_chars_addSumToTab( $res );

      // Free SQL result
      $GLOBALS[ 'TYPO3_DB' ]->sql_free_result( $res );
    }
    // LOOP : find in set for each special char length group
    // Reset SQL char set
    $this->sqlCharsetSet( $currSqlCharset );
  }

  /**
   * count_specialChars_resSqlCount( ): SQL query and execution for counting
   *                                    special char initials
   *
   * @param    integer        $length         : SQL length of special chars group
   * @param    array        $arrfindInSet   : FIND IN SET statement with proper length
   * @param    string        $currSqlCharset : Current SQL charset for reset in error case
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 4.3.1
   * @since   3.9.10
   */
  private function count_specialChars_resSqlCount( $length, $arrfindInSet, $currSqlCharset )
  {
    // 121218, dwildt, 3-
//      // Get current table.field of the index browser
//    $tableField     = $this->indexBrowserTableField;
//    list( $table )  = explode( '.', $tableField );

    $strFindInSet = "(" . implode( " OR ", $arrfindInSet ) . ")";

    // SWITCH $int_localisation_mode
    switch ( $this->int_localisation_mode )
    {
      case( PI1_DEFAULT_LANGUAGE ):
      case( PI1_DEFAULT_LANGUAGE_ONLY ):
        $arr_return = $this->count_specialChars_resSqlCountDefLL( $length, $strFindInSet, $currSqlCharset );
        break;
      case( PI1_SELECTED_OR_DEFAULT_LANGUAGE ):
        $arr_return = $this->count_specialChars_resSqlCountSelOrDefLL( $length, $strFindInSet, $currSqlCharset );
        break;
      default:
        // DIE
        $this->pObj->objLocalise->zz_promptLLdie( __METHOD__, __LINE__ );
        break;
    }
    // SWITCH $int_localisation_mode
    // Return SQL result
    return $arr_return;
  }

  /**
   * count_specialChars_resSqlCountDefLL( ): SQL query and execution for counting
   *                                    special char initials
   *
   * @param    integer        $length         : SQL length of special chars group
   * @param    array        $strFindInSet   : FIND IN SET statement with proper length
   * @param    string        $currSqlCharset : Current SQL charset for reset in error case
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 4.8.7
   * @since   3.9.13
   */
  private function count_specialChars_resSqlCountDefLL( $length, $strFindInSet, $currSqlCharset )
  {
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );
    $tableUid = $table . '.uid';

    // Query for all filter items
    // #44125, 121218, dwildt, 2-
//    $select       = "COUNT( DISTINCT " . $table . ".uid ) AS 'count', " .
//                    "LEFT ( " . $tableField . ", " . $length . " ) AS 'initial'";
    // #44125, 121218, dwildt, 2+
    $select = "COUNT( DISTINCT " . $tableUid . " ) AS 'count', " .
            "LEFT( " . $tableField . ", " . $length . " ) AS 'initial'";
    // #56329, 140226, dwildt, 1+
    $selectSubQuery = $tableUid . " AS '" . $tableUid . "'";
    $from = $this->sqlStatement_from( $table );
    $where = $this->sqlStatement_where( $table, $strFindInSet );
    // #44125, 121218, dwildt, 2-
//    $groupBy      = "LEFT ( " . $tableField . ", " . $length . " )";
//    $orderBy      = "LEFT ( " . $tableField . ", " . $length . " )";
    // #44125, 121218, dwildt, 2+
    $groupBy = "LEFT( " . $tableField . ", " . $length . " )";
    $orderBy = "LEFT( " . $tableField . ", " . $length . " )";
    $limit = null;

//      // Execute the query
//    $arr_return = $this->pObj->objSqlFun->exec_SELECTquery
//                  (
//                    $select,
//                    $from,
//                    $where,
//                    $groupBy,
//                    $orderBy,
//                    $limit
//                  );
    // Get queries
    $query = $GLOBALS[ 'TYPO3_DB' ]->SELECTquery
            (
            $select, $from, $where, $groupBy, $orderBy, $limit
    );
    // #56329, 140226, dwildt, 6+
    $groupBy = null;
    $orderBy = null;
    $subQueryTemplate = $GLOBALS[ 'TYPO3_DB' ]->SELECTquery
            (
            $selectSubQuery, $from, $where, $groupBy, $orderBy, $limit
    );
    // Get queries
    // #56329, 140226, dwildt, 1+
    $query = $this->pObj->objViewlist->queryWiAndFilter( $query, $limit, $subQueryTemplate );
    //$this->pObj->dev_var_dump(str_replace('\'', '"', $query));
    // Execute query
    $promptOptimise = 'Maintain the performance? Reduce the relations: reduce the filter. ' .
            'Don\'t use the query in a localised context.';
    $debugTrailLevel = 1;
    $arr_return = $this->pObj->objSqlFun->sql_query( $query, $promptOptimise, $debugTrailLevel );
    // Execute query
    // Error management
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      $this->sqlCharsetSet( $currSqlCharset );
    }

    return $arr_return;
  }

  /**
   * count_specialChars_resSqlCountSelOrDefLL( ): SQL query and execution for counting
   *                                    special char initials
   *
   * @param    integer        $length         : SQL length of special chars group
   * @param    array        $strFindInSet   : FIND IN SET statement with proper length
   * @param    string        $currSqlCharset : Current SQL charset for reset in error case
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 3.9.13
   * @since   3.9.13
   */
  private function count_specialChars_resSqlCountSelOrDefLL( $length, $strFindInSet, $currSqlCharset )
  {
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );

    // Label of field with the uid of the record with the default language
    $parentUid = $GLOBALS[ 'TCA' ][ $table ][ 'ctrl' ][ 'transOrigPointerField' ];

    // RETURN : table isn't localised
    if ( empty( $parentUid ) )
    {
      if ( $this->pObj->b_drs_localisation || $this->pObj->b_drs_navi )
      {
        $prompt = 'Index browser won\'t be localised, because ' . $table . ' hasn\'t any transOrigPointerField.';
        t3lib_div::devlog( '[INFO/LOCALISATION+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
      }
      $arr_return = $this->count_chars_resSqlCountDefLL( $strFindInSet, $currSqlCharset );
    }

    // Get Ids of all (!) default language records
    $arr_return = $this->zz_sqlIdsOfDefLL( $strFindInSet, $currSqlCharset );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $arr_rows = $arr_return[ 'data' ][ 'rows' ];
    $uidListOfDefLL = implode( ',', ( array ) $arr_rows );
//    var_dump( __METHOD__, __LINE__, $uidListOfDefLL );
    // Get Ids of all (!) default language records
    // Get Ids of all (!) translated language records
    $arr_return = $this->zz_sqlIdsOfTranslatedLL( $strFindInSet, $uidListOfDefLL, $currSqlCharset );
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      return $arr_return;
    }
    $arr_rowsLL = $arr_return[ 'data' ][ 'rows' ];
//    $uidListOfCurrLanguage  = implode( ',', ( array ) $arr_rowsLL['uid'] );
//    var_dump( __METHOD__, __LINE__, $uidListOfCurrLanguage );
    // Get Ids of all (!) translated language records
    // Substract uids of default language records, which are translated
    $arr_rowsDefWoTranslated = array_diff( ( array ) $arr_rows, ( array ) $arr_rowsLL[ $parentUid ] );

//    var_dump( __METHOD__, __LINE__, 'array_diff' );
//    var_dump( __METHOD__, __LINE__, $arr_rows );
//    var_dump( __METHOD__, __LINE__, ( array ) $arr_rowsLL[$parentUid] );
//    var_dump( __METHOD__, __LINE__, $arr_rowsDefWoTranslated );
    // Add uids of translated recors
    $arr_rowsDefWiCurr = array_merge( ( array ) $arr_rowsDefWoTranslated, ( array ) $arr_rowsLL[ 'uid' ] );

//    var_dump( __METHOD__, __LINE__, 'array_merge' );
//    var_dump( __METHOD__, __LINE__, $arr_rowsDefWoTranslated );
//    var_dump( __METHOD__, __LINE__, $arr_rowsLL['uid'] );
//    var_dump( __METHOD__, __LINE__, $arr_rowsDefWiCurr );
    // Sort the array of uids
    sort( $arr_rowsDefWiCurr, SORT_NUMERIC );

    // Get list of uids from the array
    $uidListDefAndCurr = implode( ',', ( array ) $arr_rowsDefWiCurr );

    // Count initials
    $arr_return = $this->zz_sqlCountInitialsLL( $length, $uidListDefAndCurr, $currSqlCharset );

    // RETURN : the sql result
    return $arr_return;
  }

  /*   * *********************************************
   *
   * SQL statements
   *
   * ******************************************** */

  /**
   * sqlCharsetGet( ):  Get the current SQL charset like latin1 or utf8.
   *
   * @return    string        $charset  : current charset
   * @version 3.9.9
   * @since   3.9.9
   */
  private function sqlCharsetGet()
  {
    // Query
    $query = "SHOW VARIABLES LIKE 'character_set_client';";
    // Execute
    $res = $GLOBALS[ 'TYPO3_DB' ]->sql_query( $query );

    // RETURN
    $row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res );

    if ( empty( $row ) )
    {
      $header = 'FATAL ERROR!';
      $text = 'row is empty. Query: ' . $query;
      $this->pObj->drs_die( $header, $text );
    }

    $charset = $row[ 'Value' ];
    if ( empty( $charset ) )
    {
      $header = 'FATAL ERROR!';
      $text = 'row[value] is empty. Query: ' . $query;
      $this->pObj->drs_die( $header, $text );
    }
    return $charset;
  }

  /**
   * sqlCharsetSet( ):  Execute SET NAMES with given charset
   *
   * @param    string        $sqlCharset : SQL charset like latin1 or utf8
   * @return    [type]        ...
   * @version 3.9.9
   * @since   3.9.9
   */
  private function sqlCharsetSet( $sqlCharset )
  {
    // #51494, 130911, dwildt, 5+
    $workaround = $this->conf_view[ 'navigation.' ][ 'indexBrowser.' ][ 'workaround.' ][ 'latin1' ];
    if ( !$workaround )
    {
      return;
    }

    $query = "SET NAMES " . $sqlCharset . ";";
    $GLOBALS[ 'TYPO3_DB' ]->sql_query( $query );

    // DRS
    if ( $this->pObj->b_drs_navi || $this->pObj->b_drs_sql )
    {
      $prompt = $query;
      t3lib_div::devlog( '[OK/FILTER+SQL] ' . $prompt, $this->pObj->extKey, -1 );
    }
    // DRS
  }

  /**
   * sqlStatement_from( ): SQL statement FROM without a FROM
   *
   * @param    string        $table  : The current from table
   * @return    string        $from   : FROM statement without a from
   * @version 3.9.25
   * @since   3.9.12
   */
  private function sqlStatement_from( $table )
  {
    switch ( true )
    {
      // 3.9.25, 120506, dwildt+
      case(!empty( $this->pObj->conf_sql[ 'andWhere' ] ) ):
      case(!$this->pObj->objSqlAut->b_left_join ) :
      case( isset( $this->pObj->piVars[ 'sword' ] ) ):
      case( $this->pObj->objFltr4x->get_selectedFilters() ):
        $from = $this->pObj->objSqlInit->statements[ 'listView' ][ 'from' ];
        break;
      default:
        $from = $table;
        break;
    }

    return $from;
  }

  /**
   * sqlStatement_where( ): SQL statement WHERE without a WHERE
   *
   * @param    string        $table              : The current from table
   * @param    string        $andWhereFindInSet  : FIND IN SET
   * @return    string        $where            : WHERE statement without a WHERE
   * @version 3.9.25
   * @since   3.9.12
   */
  private function sqlStatement_where( $table, $andWhereFindInSet )
  {
    switch ( true )
    {
      // 3.9.25, 120506, dwildt+
      case(!empty( $this->pObj->conf_sql[ 'andWhere' ] ) ):
      case(!$this->pObj->objSqlAut->b_left_join ) :
      case( isset( $this->pObj->piVars[ 'sword' ] ) ):
      case( $this->pObj->objFltr4x->get_selectedFilters() ):
        $where = $this->pObj->objSqlInit->statements[ 'listView' ][ 'where' ];
        $where = $this->sqlStatement_whereAndFindInSet( $where, $andWhereFindInSet );
        $llWhere = $this->pObj->objLocalise->localisationFields_where( $table );
        // 3.9.25, 120605, dwildt+
        $where = $this->pObj->objSqlFun->zz_concatenateWithAnd( $where, $llWhere );
        // 3.9.25, 120605, dwildt-
//        if( $llWhere )
//        {
//          $where  = $where . " AND " . $llWhere;
//        }
//        $where  = $where . $this->pObj->objFltr4x->andWhereFilter;
        // 3.9.25, 120605, dwildt+
        $andWhere = $this->pObj->objFltr4x->andWhereFilter;
//$this->pObj->dev_var_dump( $andWhere );
        $where = $this->pObj->objSqlFun->zz_concatenateWithAnd( $where, $andWhere );
        break;
      default:
        // 3.9.25, 120605: dwildt+
        $where = $this->pObj->cObj->enableFields( $table );
        $andWhere = $this->pObj->objSqlFun->get_andWherePid( $table );
        $where = $this->pObj->objSqlFun->zz_concatenateWithAnd( $where, $andWhere );
        // 120703, dwildt, 1-
        //$andWhere = $this->pObj->objLocalise3x->localisationFields_where( $table );
        // 120703, dwildt, 1+
        $andWhere = $this->pObj->objLocalise->localisationFields_where( $table );
        $where = $this->pObj->objSqlFun->zz_concatenateWithAnd( $where, $andWhere );
        $where = $this->pObj->objSqlFun->zz_concatenateWithAnd( $where, $andWhereFindInSet );
        // 3.9.25, 120605: dwildt+
        // 3.9.25, 120605: dwildt-
        // 120421, dwildt, 1+
//        $where  = "1";
//        $andEnableFields = $this->pObj->cObj->enableFields( $table );
//        $where  = $where . $andEnableFields;
//        $where  = $where . $this->pObj->objSqlFun->get_andWherePid( $table );
//        $where  = $this->sqlStatement_whereAndFindInSet( $where, $andWhereFindInSet );
//        if( empty ( $where ) )
//        {
//          $where = "1";
//        }
//        $llWhere  = $this->pObj->objLocalise->localisationFields_where( $table );
//        if( $llWhere )
//        {
//          $where  = $where . " AND " . $llWhere;
//        }
        // 3.9.25, 120605: dwildt-
        break;
    }

    return $where;
  }

  /**
   * sqlStatement_whereAndFindInSet( ): SQL statement AND WHERE without an AND
   *                                    especially for FIND IN SET
   *
   * @param    string        $where              : The current WHERE statement
   * @param    string        $findInSet  : FIND IN SET
   * @return    string        $where            : AND WHERE statement without an AND
   * @version 3.9.12
   * @since   3.9.12
   */
  private function sqlStatement_whereAndFindInSet( $where, $findInSet )
  {
    // RETURN : there isn't any FIND IN SET
    if ( !$findInSet )
    {
      return $where;
    }
    // RETURN : there isn't any FIND IN SET

    switch ( true )
    {
      case( $where ):
        $where = $where . " AND " . $findInSet;
        break;
      case( empty( $where ) ):
      default:
        $where = $findInSet;
        break;
    }

    return $where;
  }

  /*   * *********************************************
   *
   * Downward compatibility
   *
   * ******************************************** */

  /**
   * getMarkerIndexbrowser( ): Downward compatibility for ###INDEXBROWSER###
   *                           If ###AZSELECTOR### is used in an HTML template
   *                           ###AZSELECTOR### will return
   *                           * Feature: #35032
   *
   * @return    string        ###INDEXBROWSER### || ###AZSELECTOR###
   * @version  3.9.10
   * @since    3.9.10
   */
  public function getMarkerIndexbrowser()
  {
    // DRS
    if ( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Task #35037: Don\'t support the marker ###AZSELECTOR### from version 5.x';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
    // DRS
    // get th current content
    $template = $this->content;

    // RETURN ###AZSELECTOR###, if ###AZSELECTOR### is part of the current content
    $pos = strpos( $template, '###AZSELECTOR###' );
    if ( !( $pos === false ) )
    {
      if ( $this->pObj->b_drs_warn )
      {
        $prompt = 'The current template contains the marker ###AZSELECTOR###';
        t3lib_div::devlog( '[WARN/DEPRECATED] ' . $prompt, $this->pObj->extKey, 2 );
        $prompt = '###AZSELECTOR### won\'t supported from version 5.x';
        t3lib_div::devlog( '[WARN/DEPRECATED] ' . $prompt, $this->pObj->extKey, 1 );
        $prompt = 'Please move it from ###AZSELECTOR### to ###INDEXBROWSER###';
        t3lib_div::devlog( '[TODO/DEPRECATED] ' . $prompt, $this->pObj->extKey, 1 );
      }
      return '###AZSELECTOR###';
    }
    // RETURN ###AZSELECTOR###, if ###AZSELECTOR### is part of the current content
    // RETURN ###INDEXBROWSER###
    return '###INDEXBROWSER###';
  }

  /**
   * getMarkerIndexbrowserTabs( ): Downward compatibility for ###INDEXBROWSERTABS###
   *                               If ###AZSELECTORTABS### is used in an HTML template
   *                               ###AZSELECTORTABS### will return
   *                               * Feature: #35032
   *
   * @return    string        ###INDEXBROWSERTABS### || ###AZSELECTORTABS###
   * @version  3.9.10
   * @since    3.9.10
   */
  private function getMarkerIndexbrowserTabs()
  {
    // DRS
    if ( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Task #35037: Don\'t support the marker ###AZSELECTORTABS### from version 5.x';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
    // DRS
    // get th current content
    $template = $this->content;

    // RETURN ###AZSELECTORTABS###, if ###AZSELECTORTABS### is part of the current content
    $pos = strpos( $template, '###AZSELECTORTABS###' );
    if ( !( $pos === false ) )
    {
      if ( $this->pObj->b_drs_warn )
      {
        $prompt = 'The current template contains the marker ###AZSELECTORTABS###';
        t3lib_div::devlog( '[WARN/DEPRECATED] ' . $prompt, $this->pObj->extKey, 2 );
        $prompt = '###AZSELECTORTABS### won\'t supported from version 5.x';
        t3lib_div::devlog( '[WARN/DEPRECATED] ' . $prompt, $this->pObj->extKey, 1 );
        $prompt = 'Please move it from ###AZSELECTORTABS### to ###INDEXBROWSERTABS###';
        t3lib_div::devlog( '[TODO/DEPRECATED] ' . $prompt, $this->pObj->extKey, 1 );
      }
      return '###AZSELECTORTABS###';
    }
    // RETURN ###AZSELECTORTABS###, if ###AZSELECTORTABS### is part of the current content
    // RETURN ###INDEXBROWSERTABS###
    return '###INDEXBROWSERTABS###';
  }

  /*   * *********************************************
   *
   * Helper - ascii
   *
   * ******************************************** */

  /**
   * zz_specCharsToASCII( ): Convert labels to ascii labels
   *
   * @param    string        $string:  the string for conversion
   * @return    string        $ascii:   the converted string
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_specCharsToASCII( $string )
  {
    $ascii = strip_tags( html_entity_decode( $string ) );
    $ascii = $this->t3lib_cs_obj->specCharsToASCII( $this->bool_utf8, $ascii );
    $ascii = strtolower( preg_replace( '/[^a-zA-Z0-9-_.]*/', null, $ascii ) );

    return $ascii;
  }

  /*   * *********************************************
   *
   * Helper - SQL
   *
   * ******************************************** */

  /**
   * zz_sqlCountInitialsLL( ) : SQL query and execution for counting initials by given uids
   *
   * @param    integer        $length             : SQL length of special chars group
   * @param    string        $uidListDefAndCurr  : Record uids of translated records and default language records, which aren't translated
   * @param    string        $currSqlCharset     : Current SQL charset like 'latin1'
   * @return    array        $arr_return         : SQL ressource or an error message in case of an error
   * @version 4.3.1
   * @since   3.9.11
   */
  private function zz_sqlCountInitialsLL( $length, $uidListDefAndCurr, $currSqlCharset )
  {
    if ( empty( $uidListDefAndCurr ) )
    {
      // DRS
      if ( $this->pObj->b_drs_localisation || $this->pObj->b_drs_navi || $this->pObj->b_drs_sql )
      {
        $prompt = '$uidListDefAndCurr is empty';
        t3lib_div::devlog( '[WARN/LL+NAVI+SQL] ' . $prompt, $this->pObj->extKey, 2 );
      }
      // DRS
      return false;
    }

    if ( empty( $this->uidListDefaultAndCurrentLL ) )
    {
      $this->uidListDefaultAndCurrentLL = $uidListDefAndCurr;
    }
    else
    {
      $this->uidListDefaultAndCurrentLL = $this->uidListDefaultAndCurrentLL . ',' . $uidListDefAndCurr;
    }

    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );
    $tableUid = $table . ".uid";

    $caseSensitive = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'caseSensitive' ];
    switch ( $caseSensitive )
    {
      case( true ) :
        $uid = $tableUid;
        $initial = $tableField;
        break;
      case( false ) :
      default:
        // #41051, 120918, dwildt, 2-
//        $uid      = "UPPER ( " . $tableUid . " )";
//        $initial  = "UPPER ( " . $tableField . " )";
        // #44125, 121218, dwildt, 3-
//          // #41051, 120918, dwildt, 2+
//        $uid      = "upper ( " . $tableUid . " )";
//        $initial  = "upper ( " . $tableField . " )";
        // #44125, 121218, dwildt, 3+
        // #41051, 120918, dwildt, 2+
        $uid = "upper( " . $tableUid . " )";
        $initial = "upper( " . $tableField . " )";
        break;
    }

    // Configure the query
//    $select   = "COUNT( DISTINCT " . $table . ".uid ) AS 'count', " .
//                "LEFT ( " . $tableField . ", " . $length . " ) AS 'initial'";
//    $from     = $table;
//    $where    = $table . ".uid IN (" . $uidListDefAndCurr . ")";
//    $groupBy  = "LEFT ( " . $tableField . ", " . $length . " )";
//    $orderBy  = "LEFT ( " . $tableField . ", " . $length . " )";
//    $limit    = null;
    // #44125, 121218, dwildt, 2-
//    $select   = "COUNT( DISTINCT " . $uid . " ) AS 'count', " .
//                "LEFT ( " . $initial . ", " . $length . " ) AS 'initial'";
    // #44125, 121218, dwildt, 2+
    $select = "COUNT( DISTINCT " . $uid . " ) AS 'count', " .
            "LEFT( " . $initial . ", " . $length . " ) AS 'initial'";
    $from = $table;
    $where = $table . ".uid IN (" . $uidListDefAndCurr . ")";
    // #44125, 121218, dwildt, 2-
//    $groupBy  = "LEFT ( " . $initial . ", " . $length . " )";
//    $orderBy  = "LEFT ( " . $initial . ", " . $length . " )";
    // #44125, 121218, dwildt, 2+
    $groupBy = "LEFT( " . $initial . ", " . $length . " )";
    $orderBy = "LEFT( " . $initial . ", " . $length . " )";
    $limit = null;
    // Query for all filter items
    // Execute the query
    $arr_return = $this->pObj->objSqlFun->exec_SELECTquery
            (
            $select, $from, $where, $groupBy, $orderBy, $limit
    );

    // Error management
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      $this->sqlCharsetSet( $currSqlCharset );
    }

    return $arr_return;
  }

  /**
   * zz_sqlIdsOfDefLL( ) : Get Ids of all (!) default language records
   *
   * @param    string        $strFindInSet   : FIND IN SET( )
   * @param    string        $currSqlCharset : Current SQL charset like 'latin1'
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 3.9.13
   * @since   3.9.13
   */
  private function zz_sqlIdsOfDefLL( $strFindInSet, $currSqlCharset )
  {
//    if( ! ( $this->idsOfAllDefaultLLrecords === null ) )
//    {
//      $arr_return['data']['rows'] = $this->idsOfAllDefaultLLrecords;
//$this->pObj->dev_var_dump( $this->idsOfAllDefaultLLrecords );
//      return $arr_return;
//    }
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );

    // Store current localisation mode
    $curr_int_localisation_mode = $this->int_localisation_mode;
    // Set localisation mode to default language
    //$this->pObj->objLocalise->int_localisation_mode = PI1_DEFAULT_LANGUAGE;
    $this->pObj->objLocalise->setLocalisationMode( PI1_DEFAULT_LANGUAGE );

    // Configure the query
    $select = $table . ".uid";
    $from = $this->sqlStatement_from( $table );
    $where = $this->sqlStatement_where( $table, $strFindInSet );
    $groupBy = null;
    $orderBy = $table . ".uid";
    $limit = null;

    // Reset localisation mode to current language mode
    //$this->pObj->objLocalise->int_localisation_mode = $curr_int_localisation_mode;
    $this->pObj->objLocalise->setLocalisationMode( $curr_int_localisation_mode );
    // Execute the query
    $arr_return = $this->pObj->objSqlFun->exec_SELECTquery
            (
            $select, $from, $where, $groupBy, $orderBy, $limit
    );

    // Error management
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      $this->sqlCharsetSet( $currSqlCharset );
      return $arr_return;
    }

    $res = $arr_return[ 'data' ][ 'res' ];
    while ( $row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res ) )
    {
      // Get values from the SQL row
//      $this->idsOfAllDefaultLLrecords[] = $row['uid'];
      $idsOfAllDefaultLLrecords[] = $row[ 'uid' ];
    }


//    $arr_return['data']['rows'] = $this->idsOfAllDefaultLLrecords;
//$this->pObj->dev_var_dump( $this->idsOfAllDefaultLLrecords );
    $arr_return[ 'data' ][ 'rows' ] = $idsOfAllDefaultLLrecords;
//$this->pObj->dev_var_dump( $idsOfAllDefaultLLrecords );
    return $arr_return;
  }

  /**
   * zz_sqlIdsOfTranslatedLL( ) : Get Ids of all (!) translated language records
   *
   * @param    string        $currSqlCharset : Current SQL charset for reset in error case
   * @param    [type]        $currSqlCharset: ...
   * @param    [type]        $currSqlCharset: ...
   * @return    array        $arr_return     : SQL ressource or an error message in case of an error
   * @version 3.9.13
   * @since   3.9.11
   */
  private function zz_sqlIdsOfTranslatedLL( $strFindInSet, $uidListOfDefLL, $currSqlCharset )
  {
    if ( empty( $uidListOfDefLL ) )
    {
      // DRS
      if ( $this->pObj->b_drs_localisation || $this->pObj->b_drs_navi || $this->pObj->b_drs_sql )
      {
        $prompt = '$uidListOfDefLL is empty';
        t3lib_div::devlog( '[INFO/LL+NAVI+SQL] ' . $prompt, $this->pObj->extKey, 0 );
      }
      // DRS
      return;
    }
//    if( ! ( $this->idsOfAllTranslatedLLrecords === null ) )
//    {
//      $arr_return['data']['rows'] = $this->idsOfAllTranslatedLLrecords;
//$this->pObj->dev_var_dump( $this->idsOfAllTranslatedLLrecords );
//      return $arr_return;
//    }
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;
    list( $table ) = explode( '.', $tableField );

    // Label of field with the uid of the record with the default language
    $parentUid = $GLOBALS[ 'TCA' ][ $table ][ 'ctrl' ][ 'transOrigPointerField' ];

    // Store current localisation mode
    $curr_int_localisation_mode = $this->int_localisation_mode;
    // Set localisation mode to translated language
    //$this->pObj->objLocalise->int_localisation_mode = PI1_SELECTED_LANGUAGE_ONLY;
    $this->pObj->objLocalise->setLocalisationMode( PI1_SELECTED_LANGUAGE_ONLY );
    // Get where for localisation
    $whereLL = $this->pObj->objLocalise->localisationFields_where( $table );
    if ( empty( $whereLL ) )
    {
      $header = 'FATAL ERROR!';
      $text = 'whereLL is empty. <br />'
              . 'Probably ' . $table . ' hasn\'t any localisation fields. <br />'
              . 'If error occurs in context with the index browser, please disable the index browser in the Brower flexform/plugin.<br />'
              . 'Maybe ' . $table . ' isn\'t the proper local table. '
      ;
      $this->pObj->drs_die( $header, $text );
    }
    if ( !empty( $whereLL ) )
    {
      $whereLL = " AND " . $whereLL;
    }
    // Get where for localisation
    // Reset localisation mode to current language mode
    //$this->pObj->objLocalise->int_localisation_mode = $curr_int_localisation_mode;
    $this->pObj->objLocalise->setLocalisationMode( $curr_int_localisation_mode );

    // Configure the query
    $select = $table . ".uid, " . $table . "." . $parentUid;
    $from = $this->sqlStatement_from( $table );
    $where = $table . "." . $parentUid . " IN (" . $uidListOfDefLL . ") " . $whereLL;
    $where = $this->sqlStatement_whereAndFindInSet( $where, $strFindInSet );
    $andEnableFields = $this->pObj->cObj->enableFields( $table );
    $where = $where . $andEnableFields;
    $groupBy = null;
    $orderBy = $table . ".uid";
    $limit = null;

    // Execute the query
    $arr_return = $this->pObj->objSqlFun->exec_SELECTquery
            (
            $select, $from, $where, $groupBy, $orderBy, $limit
    );

    // Error management
    if ( $arr_return[ 'error' ][ 'status' ] )
    {
      $this->sqlCharsetSet( $currSqlCharset );
      return $arr_return;
    }

    // 141214, dwildt, 1+
    $idsOfAllTranslatedLLrecords = null;
    $res = $arr_return[ 'data' ][ 'res' ];
    while ( $row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res ) )
    {
      // Get values from the SQL row
//      $this->idsOfAllTranslatedLLrecords['uid'][]       = $row['uid'];
//      $this->idsOfAllTranslatedLLrecords[$parentUid][]  = $row[$parentUid];
      $idsOfAllTranslatedLLrecords[ 'uid' ][] = $row[ 'uid' ];
      $idsOfAllTranslatedLLrecords[ $parentUid ][] = $row[ $parentUid ];
    }

//    $arr_return['data']['rows'] = $this->idsOfAllTranslatedLLrecords;
//$this->pObj->dev_var_dump( $this->idsOfAllTranslatedLLrecords );
    $arr_return[ 'data' ][ 'rows' ] = $idsOfAllTranslatedLLrecords;
//$this->pObj->dev_var_dump( $idsOfAllTranslatedLLrecords );
    return $arr_return;
  }

  /*   * *********************************************
   *
   * Helper - SQL FIND IN SET
   *
   * ******************************************** */

  /**
   * zz_getFindInSetForAllByte( ): Set the FIND IN SET statement for each special char group.
   *                                        A special char group is grouped by the length of a special
   *                                        char.
   *
   * @param    array        $row  : Row with special chars and their SQL length
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.10
   */
  private function zz_getFindInSetForAllByte( $row )
  {
    // Chars from one byte to unlimited bytes
    $fromLength = 1;
    return $this->zz_getFindInSetFromLength( $row, $fromLength );
  }

  /**
   * zz_getFindInSetForMultibyte( ): Set the FIND IN SET statement for each special char group.
   *                                        A special char group is grouped by the length of a special
   *                                        char.
   *
   * @param    array        $row  : Row with special chars and their SQL length
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.10
   */
  private function zz_getFindInSetForMultibyte( $row )
  {
    // Chars from two bytes only to unlimited bytes
    $fromLength = 2;
    return $this->zz_getFindInSetFromLength( $row, $fromLength );
  }

  /**
   * zz_getFindInSetFromLength( ): Set the FIND IN SET statement for each special char group.
   *                                        A special char group is grouped by the length of a special
   *                                        char.
   *
   * @param    array        $row  : Row with special chars and their SQL length
   * @param    [type]        $fromLength: ...
   * @return    [type]        ...
   * @version 4.3.1
   * @since   3.9.10
   */
  private function zz_getFindInSetFromLength( $row, $fromLength )
  {
    // Get current table.field of the index browser
    $tableField = $this->indexBrowserTableField;

    // LOOP : generate a find in set statement for each special char
    $findInSet = null;
    foreach ( $row as $char => $length )
    {
      if ( $length < $fromLength )
      {
        continue;
      }
      // #44125, 121218, dwildt, 1-
//      $findInSet[$length][] = "FIND_IN_SET( LEFT ( " . $tableField . ", " . $length . " ), '" . $char . "' )";
      // #44125, 121218, dwildt, 1-
      $findInSet[ $length ][] = "FIND_IN_SET( LEFT( " . $tableField . ", " . $length . " ), '" . $char . "' )";
    }
    // LOOP : generate a find in set statement for each special char

    return $findInSet;
  }

  /**
   * zz_getSqlLengthAsRow( ): Return a row with the SQL length of the given chars
   *
   * @param    array        $arrChars  : array with the chars
   * @return    array        $arr_return       : row with all special chars and their SQL length
   * @version 4.3.1
   * @since   3.9.10
   */
  private function zz_getSqlLengthAsRow( $arrChars )
  {
    // RETURN : $arrChars is empty
    if ( empty( $arrChars ) )
    {
      return;
    }
    // RETURN : $arrChars is empty
    // Build the select statement parts for the length of each special char
    $arrStatement = array();
    foreach ( ( array ) $arrChars as $specialChar )
    {
      // #44125, 121218, dwildt, 1-
//      $arrStatement[] = "LENGTH ( '" . $specialChar . "' ) AS '" . $specialChar . "'";
      // #44125, 121218, dwildt, 1+
      $arrStatement[] = "LENGTH( '" . $specialChar . "' ) AS '" . $specialChar . "'";
    }
    // Build the select statement parts for the length of each special char
    // DIE : undefined error
    if ( empty( $arrStatement ) )
    {
      $header = 'FATAL ERROR!';
      $text = '$arrStatement is empty. ';
      $this->pObj->drs_die( $header, $text );
    }
    // DIE : undefined error
    // Execute query for the length of each special char
    $query = "SELECT " . implode( ', ', $arrStatement );
    $res = $GLOBALS[ 'TYPO3_DB' ]->sql_query( $query );

    // Error management
    $error = $GLOBALS[ 'TYPO3_DB' ]->sql_error();
    if ( $error )
    {
      $level = 1;
      $arr_return = $this->pObj->objSqlFun->prompt_error( $query, $error, $level );
      return $arr_return;
    }
    // Error management
    // DRS
    if ( $this->pObj->b_drs_navi || $this->pObj->b_drs_sql )
    {
      $prompt = $query;
      t3lib_div::devlog( '[OK/NAVI+SQL] ' . $prompt, $this->pObj->extKey, -1 );
    }
    // DRS
    // Get the row
    $row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res );
    // SQL free result
    $GLOBALS[ 'TYPO3_DB' ]->sql_free_result( $res );

    $arr_return[ 'data' ][ 'row' ] = $row;
    return $arr_return;
  }

  /*   * *********************************************
   *
   * Helper - tabs
   *
   * ******************************************** */

  /**
   * zz_setTabClassSelected( ): Sets the class property selected, if the current tab
   *                      is selected. Sets the class var indexBrowserTab.
   *
   * @param    integer        $tabId    : Current tab ID for TS configuration array
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_setTabClassSelected( $tabId )
  {
//$this->pObj->dev_var_dump( $tabLabel, $this->pObj->piVar_indexBrowserTab );
//$this->pObj->dev_var_dump( $tabId, $this->indexBrowserTab['tabSpecial']['default'] );
    // IF : piVar
    if ( $this->pObj->piVar_indexBrowserTab )
    {
      $label = $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'label' ];
      $labelAscii = $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'labelAscii' ];

      // IF : current tab is selected
      if ( $label == $this->pObj->piVar_indexBrowserTab )
      {
        $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'selected' ] = true;
        $this->indexBrowserTab[ 'tabSpecial' ][ 'selected' ] = $tabId;
        return;
      }
      // IF : current tab is selected
      // IF : current tab is selected
      if ( $labelAscii == $this->pObj->piVar_indexBrowserTab )
      {
        $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'selected' ] = true;
        $this->indexBrowserTab[ 'tabSpecial' ][ 'selected' ] = $tabId;
        return;
      }
      // IF : current tab is selected
      // Don't follow workflow
      return;
    }
    // IF : piVar
    // no piVar
    if ( $tabId == $this->indexBrowserTab[ 'tabSpecial' ][ 'default' ] )
    {
      $this->indexBrowserTab[ 'tabIds' ][ $tabId ][ 'selected' ] = true;
      $this->indexBrowserTab[ 'tabSpecial' ][ 'selected' ] = $tabId;
    }
  }

  /**
   * zz_setTabPiVars( ):  Makes a backup of the current piVars. Than it removes some
   *                      elements, which shouldn't be part of a index browser link.
   *
   * @param    string        $labelAscii : label of the current tab in ascii format
   * @param    string        $label      : label of the current tab
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_setTabPiVars( $labelAscii, $label )
  {
    // Backup piVars
    $this->piVarsBak = $this->pObj->piVars;

    // Unset the pointer
    $pageBrowserPointerLabel = $this->conf[ 'navigation.' ][ 'pageBrowser.' ][ 'pointer' ];
    if ( isset( $this->pObj->piVars[ $pageBrowserPointerLabel ] ) )
    {
      unset( $this->pObj->piVars[ $pageBrowserPointerLabel ] );
    }

    // Set indexBrowserTab
    $this->pObj->piVars[ 'indexBrowserTab' ] = $labelAscii;

    // Handle default tab
    $this->zz_setTabPiVarsDefaultTab( $label );
  }

  /**
   * zz_setTabPiVarsDefaultTab( ):  Removes the piVar indexBrowserTab in case of
   *                                the default tab, if default tab should get a
   *                                link
   *
   * @param    string        $label: label of the current tab
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_setTabPiVarsDefaultTab( $label )
  {
    // RETURN : default tab should get a link
    if ( $this->linkDefaultTab )
    {
      return;
    }

    // RETURN : current tab isn't the default tab
    if ( $label != $this->tabDefaultLabel )
    {
      return;
    }

    // Unset piVars['indexBrowserTab']
    if ( isset( $this->pObj->piVars[ 'indexBrowserTab' ] ) )
    {
      unset( $this->pObj->piVars[ 'indexBrowserTab' ] );
    }
  }

  /**
   * zz_tabClass( ): Returns the tab class like ' class="tab-u tab-29 selected last"'
   *
   * @param    integer        $lastTabId  : id of the last visible tab
   * @param    array        $tab        : array with elements of the current tab
   * @param    integer        $key        : id of the tab from the TS configuration
   * @return    string        $class      : complete class tag
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_tabClass( $lastTabId, $tab, $key )
  {
    #43732
    // Default class
    // #i0109, 141214, dwildt 1-/+
    //$class = 'ui-state-default ui-corner-top tab-' . $tab[ 'labelAscii' ] . ' tab-' . $key;
    $classDefault = $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'classes.' ][ 'tab.' ][ 'default' ];
    $classDefault = str_replace( '###KEY###', $key, $classDefault );
    $classDefault = str_replace( '###TAB###', $tab[ 'labelAscii' ], $classDefault );
//    if( empty( $classDefault ))
//    {
//      $classDefault = 'ui-state-default ui-corner-top tab-' . $tab[ 'labelAscii' ] . ' tab-' . $key;
//    }
    $classActive = $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'classes.' ][ 'tab.' ][ 'active' ];
    $classActive = str_replace( '###KEY###', $key, $classActive );
    $classActive = str_replace( '###TAB###', $tab[ 'labelAscii' ], $classActive );
//    if( empty( $classActive ))
//    {
//      $classActive = 'ui-state-default ui-corner-top tab-' . $tab[ 'labelAscii' ] . ' tab-' . $key . ' ui-tabs-active ui-state-active selected';
//    }
    // Selected tab
    $class = $classDefault;
    if ( !empty( $tab[ 'selected' ] ) )
    {
      $class = $classActive;
    }
    // Selected tab
    // Last visible tab
    if ( $key == $lastTabId )
    {
      $class = $class . ' last';
    }
    // Last visible tab

    $class = ' class="' . $class . '"';

    return $class;
  }

  /**
   * zz_tabDefaultLabel( ): Set class var $tabDefaultLabel
   *
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_tabDefaultLabel()
  {
    $defaultTab_key = $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'defaultTab' ];
    $defaultTab_label = $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'tabs.' ][ $defaultTab_key ];
    $defaultTab_stdWrap = $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'tabs.' ][ $defaultTab_key . '.' ][ 'stdWrap.' ];
    $this->tabDefaultLabel = $this->pObj->objWrapper4x->general_stdWrap( $defaultTab_label, $defaultTab_stdWrap );
  }

  /**
   * zz_tabDefaultLink( ):  Set the boolean class var linkDefaultTab: Should
   *                        the default tab get a link?
   *
   * @return    [type]        ...
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_tabDefaultLink()
  {
    $boolLink = true;

    // IF don't display in URL
    if ( empty( $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'defaultTab.' ][ 'display_in_url' ] ) )
    {
      $boolLink = false;

      // IF empty list at start
      // #7582, Bugfix, 100501
      if ( $this->pObj->objFlexform->bool_emptyAtStart )
      {
        $boolLink = true;
        // DRS - Development Reporting System
        if ( $this->pObj->b_drs_templating || $this->pObj->b_drs_navi )
        {
          $prompt = 'Empty list by start is true and the default tab of the index browser ' .
                  'shouldn\'t linked with a piVar. This is not proper.';
          t3lib_div::devlog( '[WARN/TEMPLATING+NAVI] ' . $prompt, $this->pObj->extKey, 2 );
          $prompt = 'The default tab of the index browser will be linked with a piVar by the system!';
          t3lib_div::devlog( '[INFO/TEMPLATING+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
        }
        // DRS - Development Reporting System
      }
      // IF empty list at start
    }
    // IF don't display in URL
    // Set the class var
    $this->linkDefaultTab = $boolLink;
  }

  /**
   * zz_tabLinkLabel( ): Links the label of the current tab
   *
   * @param    array        $tab            : array with elements of the current tab
   * @return    string        $tabLinkedLabel : the linked label
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_tabLinkLabel( $tab )
  {
    // Init typolink
    $typolink[ 'parameter' ] = $GLOBALS[ 'TSFE' ]->id;

    // Get the property title
    $title = $this->zz_tabTitle( $tab[ 'sum' ] );
    if ( $title )
    {
      // #43732, #i0109, 141214, dwildt
      $class = $this->pObj->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'classes.' ][ 'a.' ][ 'default' ];
      $typolink[ 'parameter' ] = $typolink[ 'parameter' ] . ' - "' . $class . '" "' . $title . '"';
    }
    // Get the property title
    // Set piVars
    $this->zz_setTabPiVars( $tab[ 'labelAscii' ], $tab[ 'label' ] );
    // Init array with piVars
    $tabLinkedLabel = $this->pObj->objZz->linkTP_keepPIvars
            (
            $tab[ 'label' ], $typolink, $this->pObj->piVars, $this->pObj->boolCache
    );

    // RESET piVars
    $this->pObj->piVars = $this->piVarsBak;

    return $tabLinkedLabel;
  }

  /**
   * zz_tabLastId( ): Returns the id of the last visible tab. A tab is visible,
   *                  if the property displayWoItems is true or of the tab has
   *                  one hit at least
   *
   * @return    integer        $id: Id of the last visible tab
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_tabLastId()
  {
    // Get tab array
    $arrTabs = $this->indexBrowserTab[ 'tabIds' ];
    // Get last tab
    end( $arrTabs );

    // Security counter
    $i = 0;
    $iMax = 1000;
    // DO WHILE : a tab should displayed without items or a tab has a hit at least
    do
    {
      // Get key
      $id = key( $arrTabs );

      // DIE : undefined error - key doesn't exist
      if ( !isset( $arrTabs[ $id ] ) )
      {
        $header = 'FATAL ERROR!';
        $text = 'Undefined key for index browser tabs!';
        $this->pObj->drs_die( $header, $text );
      }
      // DIE : undefined error - key doesn't exist
      // SWITCH display without items or one item at least
      switch ( true )
      {
        case( $arrTabs[ $id ][ 'displayWoItems' ] ):
        case( $arrTabs[ $id ][ 'sum' ] > 0 ):
          break 2;
        default:
      }
      // SWITCH display without items or one item at least
      // Go to the rpevious tab
      prev( $arrTabs );
      // Security counter
      $i++;
    }
    while ( $i < $iMax );
    // DO WHILE : a tab should displayed without items or a tab has a hit at least
    // RETURN : id of last visible tab
    return $id;
  }

  /**
   * zz_tabTitle( ): Returns the value for the title property. Something like
   *                 "1 item" or "12 items"
   *
   * @param    integer        $sum    : Amount of hits of the current tab
   * @return    string        $title  :    The title value
   * @version 3.9.12
   * @since   3.9.12
   */
  private function zz_tabTitle( $sum )
  {
    // DRS
    static $drsPrompt_01 = true;
    static $drsPrompt_02 = true;

    // RETURN : title shouldn't displayed
    $displayTitle = $this->conf[ 'navigation.' ][ 'indexBrowser.' ][ 'display.' ][ 'tabHrefTitle' ];
    if ( !$displayTitle )
    {
      return;
    }
    // RETURN : title shouldn't displayed
    // SWITCH : sum of hits
    switch ( true )
    {
      case( $sum > 1 ):
        // Get localised title for more than one item
        $title = htmlspecialchars( $this->pObj->pi_getLL( 'browserItems', 'Items', true ) );
        // DRS
        if ( $drsPrompt_02 )
        {
          if ( $this->pObj->b_drs_localisation || $this->pObj->b_drs_navi )
          {
            // Get the current language key
            $langKey = $GLOBALS[ 'TSFE' ]->lang;
            $prompt = 'Label for a tab with items is: ' . $title;
            t3lib_div::devlog( '[INFO/LOCALLANG+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
            $prompt = 'If you want another label, please configure ' .
                    '_LOCAL_LANG.' . $langKey . '.browserItems';
            t3lib_div::devlog( '[HELP/LOCALLANG+NAVI] ' . $prompt, $this->pObj->extKey, 1 );
            $drsPrompt_02 = false;
          }
        }
        // DRS
        break;
      default:
        // Get localised title for one item exactly
        $title = htmlspecialchars( $this->pObj->pi_getLL( 'browserItem', 'Item', true ) );
        // DRS
        if ( $drsPrompt_01 )
        {
          if ( $this->pObj->b_drs_localisation || $this->pObj->b_drs_navi )
          {
            // Get the current language key
            $langKey = $GLOBALS[ 'TSFE' ]->lang;
            $prompt = 'Label for a tab with one item is: ' . $title;
            t3lib_div::devlog( '[INFO/LOCALLANG+NAVI] ' . $prompt, $this->pObj->extKey, 0 );
            $prompt = 'If you want another label, please configure ' .
                    '_LOCAL_LANG.' . $langKey . '.browserItem';
            t3lib_div::devlog( '[HELP/LOCALLANG+NAVI] ' . $prompt, $this->pObj->extKey, 1 );
            $drsPrompt_01 = false;
          }
        }
        // DRS
        break;
    }
    // SWITCH : sum of hits
    // RETURN the title value
    $title = $sum . ' ' . $title;
    return $title;
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/browser/pi1/class.tx_browser_pi1_navi_indexBrowser.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/browser/pi1/class.tx_browser_pi1_navi_indexBrowser.php' ]);
}
?>