<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2012 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * The class tx_browser_pi1_filter_4x bundles methods for rendering and processing filters and category menues.
 * 4x means: with SQL engine 4.x
 *
 * @author       Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package      TYPO3
 * @subpackage   browser
 *
 * @version      3.9.9
 * @since        3.9.9
 */

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   90: class tx_browser_pi1_filter_4x
 *  136:     function __construct($pObj)
 *
 *              SECTION: Main
 *  170:     public function get_htmlFilters( )
 *  241:     private function get_marker( )
 *
 *              SECTION: Main
 *  308:     private function init( )
 *
 *              SECTION: SQL ressources - base for rows
 *  367:     private function rows( )
 *  455:     private function sql_resAllItems( )
 *  532:     private function sql_resWiHitsOnly( )
 *  609:     private function sql_select( $bool_count )
 *
 *              SECTION: SQL select
 *  700:     private function sql_select_addLL( )
 *  735:     private function sql_select_addLL_sysLanguage( )
 *  810:     private function sql_select_addLL_lang_ol(  )
 *  876:     private function sql_select_addTreeview( )
 *
 *              SECTION: SQL from, groupBy, orderBy, limit
 *  979:     private function sql_from( )
 * 1017:     private function sql_groupBy( )
 * 1042:     private function sql_orderBy( )
 * 1098:     private function sql_limit( )
 *
 *              SECTION: SQL where
 * 1137:     private function sql_whereAllItems( )
 * 1178:     private function sql_whereWiHitsOnly( )
 * 1210:     private function sql_andWhere_enableFields( )
 * 1237:     private function sql_andWhere_fromTS( )
 * 1263:     private function sql_andWhere_pidList( )
 * 1316:     private function sql_andWhere_sysLanguage( )
 *
 *              SECTION: Rows
 * 1392:     private function sql_resToRows( $res )
 * 1432:     private function sql_resToRows_allItemsWiHits( $res, $rows_wiHitsOnly )
 *
 *              SECTION: TypoScript
 * 1504:     private function ts_displayWithoutAnyHit( )
 *
 * TOTAL FUNCTIONS: 25
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_browser_pi1_filter_4x {


    //////////////////////////////////////////////////////
    //
    // Variables set by the pObj (by class.tx_browser_pi1.php)

    // [Array] The current TypoScript configuration array
  var $conf       = false;
    // [Integer] The current mode (from modeselector)
  var $mode       = false;
    // [String] 'list' or 'single': The current view
  var $view       = false;
    // [Array] The TypoScript configuration array of the current view
  var $conf_view  = false;
    // [String] TypoScript path to the current view. I.e. views.single.1
  var $conf_path  = false;
    // Variables set by the pObj (by class.tx_browser_pi1.php)


    // [BOOLEAN] true: don't localise the current SQL query, false: localise it
  var $bool_dontLocalise      = null;
    // [INTEGER] number of the localisation mode
  var $int_localisation_mode  = null;
    // [STRING] Current table
  var $curr_tableField        = null;
    // [ARRAY] tables with the fields, which are used in the SQL query
  var $sql_filterFields       = null;












  /**
 * Constructor. The method initiate the parent object
 *
 * @param	object		The parent object
 * @return	void
 */
  function __construct($pObj) {
    $this->pObj = $pObj;
  }









 /***********************************************
  *
  * Main
  *
  **********************************************/









/**
 * get_htmlFilters( ):  It renders filters and category menus in HTML.
 *                    A rendered filter can be a category menu, a checkbox, radiobuttons and a selectbox
 *
 * @return	array
 * @version 3.9.9
 * @since   3.9.9
 */
  public function get_htmlFilters( )
  {
      // Prompt the expired time to devlog
    $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'begin' );

      // Init localisation
    $this->init( );

      // LOOP each filter
    foreach( ( array ) $this->conf_view['filter.'] as $tableWiDot => $fields )
    {
      foreach( ( array ) $fields as $field => $confField )
      {
        if( rtrim($field, '.') != $field )
        {
          continue;
        }
        $this->curr_tableField = $tableWiDot . $field;

          // Get table
        list( $table ) = explode( '.', $this->curr_tableField );
          // Load TCA
        $this->pObj->objZz->loadTCA( $table );

        $arr_return = $this->get_marker( );
        if( $arr_return['error']['status'] )
        {
          $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
          return $arr_return;
        }
      }
    }
      // LOOP each filter

      // DRS :TODO:
    if( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Area?';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
      $prompt = 'Check the effect of TypoScript sql.andWhere!';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS :TODO:

//    $this->pObj->dev_var_dump( __METHOD__, __LINE__, $this->sql_filterFields );

    $str_header  = '<h1 style="color:red;">' . __METHOD__ . '</h1>';
    $str_prompt  = '<p style="color:red;font-weight:bold;">Development ' . $this->curr_tableField . '</p>';
    $arr_return['error']['status'] = true;
    $arr_return['error']['header'] = $str_header;
    $arr_return['error']['prompt'] = $str_prompt;

      // Prompt the expired time to devlog
    $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
    return $arr_return;
  }









 /***********************************************
  *
  * Init
  *
  **********************************************/









/**
 * init( ):  Inits the localisation mode. Set the class var $this->int_localisation_mode.
 *
 * @return	void
 * @version 3.9.9
 * @since   3.9.9
 */
  private function init( )
  {

    if( ! isset( $this->int_localisation_mode ) )
    {
      $this->int_localisation_mode = $this->pObj->objLocalise->localisationConfig( );
    }

    switch( $this->int_localisation_mode )
    {
      case( PI1_DEFAULT_LANGUAGE ):
        $this->bool_dontLocalise = true;
        $prompt = 'Localisation mode is PI1_DEFAULT_LANGUAGE. There isn\' any need to localise!';
        break;
      case( PI1_DEFAULT_LANGUAGE_ONLY ):
        $this->bool_dontLocalise = true;
        $prompt = 'Localisation mode is PI1_DEFAULT_LANGUAGE_ONLY. There isn\' any need to localise!';
        break;
      default:
        $this->bool_dontLocalise = false;
        $prompt = 'Localisation mode is enabled';
        break;
    }
    if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
    {
      t3lib_div::devlog( '[INFO/FILTER+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
    }
    // Do we need translated/localised records?
  }









 /***********************************************
  *
  * Marker
  *
  **********************************************/









/**
 * get_marker( ):  It renders filters and category menus in HTML.
 *                    A rendered filter can be a category menu, a checkbox, radiobuttons and a selectbox
 *
 * @return	array
 * @version 3.9.9
 * @since   3.9.9
 */
  private function get_marker( )
  {
      // Prompt the expired time to devlog
    $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'begin' );

      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // RETURN condition isn't met
    if( ! $this->ts_condition( ) )
    {
      $marker = '###' . strtoupper( $this->curr_tableField ) . '###';
      $arr_return['data']['marker'][$marker] = null;
      $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
      return $arr_return;
    }
      // RETURN condition isn't met

      // Get filter rows
    $arr_return = $this->rows( );
    if( $arr_return['error']['status'] )
    {
      $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
      return $arr_return;
    }
    $rows = $arr_return['data']['rows'];
    unset( $arr_return );
      // Get filter rows



    $this->pObj->dev_var_dump( __METHOD__, __LINE__, $rows );
      // DRS :TODO:
    if( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Render rows as HTML object';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS :TODO:



  // Set HTML object

      // Prompt the expired time to devlog
    $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
    return $arr_return;
  }









 /***********************************************
  *
  * Rows
  *
  **********************************************/









/**
 * rows( ):  Get the SQL ressource for a filter
 *
 * @return	array		$arr_return : Array with the SQL ressource or an error message
 * @version 3.9.9
 * @since   3.9.9
 */
  private function rows( )
  {
      // Prompt the expired time to devlog
    $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'begin' );

      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Get SQL ressource for filter items with one hit at least
    $arr_return = $this->sql_resWiHitsOnly( );
    if( $arr_return['error']['status'] )
    {
      $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
      return $arr_return;
    }
    $res = $arr_return['data']['res'];
    unset( $arr_return );
      // Get SQL ressource for filter items with one hit at least

      // Get rows
    $rows_wiHitsOnly = $this->sql_resToRows( $res );

      // Display all items?
    $display_without_any_hit  = $this->ts_displayWithoutAnyHit( );

      // Display items with one hit at least only
    if( ! $display_without_any_hit )
    {
      $arr_return['data']['rows'] = $rows_wiHitsOnly;
        // Prompt the expired time to devlog
      $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
      return $arr_return;
    }
      // Display items with one hit at least only

      // Display all items
      // SWITCH localTable versus foreignTable
    switch( true )
    {
      case( $table != $this->pObj->localTable ):
          // foreign table
          // Get SQL ressource for all filter items
        $arr_return = $this->sql_resAllItems( );
        if( $arr_return['error']['status'] )
        {
          $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
          return $arr_return;
        }
        $res = $arr_return['data']['res'];
        unset( $arr_return );
          // Get SQL ressource for all filter items
          // Get rows
        $rows = $this->sql_resToRows_allItemsWiHits( $res, $rows_wiHitsOnly );
        break;
          // foreign table
      case( $table == $this->pObj->localTable ):
      default:
          // local table
        $rows = $rows_wiHitsOnly;
        break;
          // local table
    }
      // SWITCH localTable versus foreignTable
      // Display all items


    $arr_return['data']['rows'] = $rows;

      // Prompt the expired time to devlog
    $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
    return $arr_return;
  }









 /***********************************************
  *
  * SQL ressources
  *
  **********************************************/








/**
 * sql_resAllItems( ):  Get the SQL ressource for a filter with all items.
 *                      Hits won't counted.
 *
 * @return	array		$arr_return : Array with the SQL ressource or an error message
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_resAllItems( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Don't count hits
    $bool_count = false;

      // Query for all filter items
    $select   = $this->sql_select( $bool_count );
    $from     = $table;
    $where    = $this->sql_whereAllItems( );
    $groupBy  = $this->curr_tableField;
    $orderBy  = $this->sql_orderBy( );
    $limit    = $this->sql_limit( );

      // Get query
    $query  = $GLOBALS['TYPO3_DB']->SELECTquery
                                    (
                                      $select,
                                      $from,
                                      $where,
                                      $groupBy,
                                      $orderBy,
                                      $limit
                                    );
      // Get query
      // Execute query
    $res    = $GLOBALS['TYPO3_DB']->exec_SELECTquery
                                    (
                                      $select,
                                      $from,
                                      $where,
                                      $groupBy,
                                      $orderBy,
                                      $limit
                                    );
      // Execute query

      // Error management
    $error = $GLOBALS['TYPO3_DB']->sql_error( );
    if( $error )
    {
      $this->pObj->objSqlFun->query = $query;
      $this->pObj->objSqlFun->error = $error;
      $arr_return = $this->pObj->objSqlFun->prompt_error( );
      return $arr_return;
    }
      // Error management

      // DRS
    if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql )
    {
      $prompt = $query;
      t3lib_div::devlog( '[OK/FILTER+SQL] ' . $prompt, $this->pObj->extKey, -1 );
    }
      // DRS

    $arr_return['data']['res'] = $res;
    return $arr_return;
  }








/**
 * sql_resWiHitsOnly( ):  Get the SQL ressource for a filter with items with hits only.
 *                        Hits will counted.
 *
 * @return	array		$arr_return : Array with the SQL ressource or an error message
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_resWiHitsOnly( )
  {
      // Count hits
    $bool_count = true;

      // Get query parts
    $select   = $this->sql_select( $bool_count );
    $from     = $this->sql_from( );
    $where    = $this->sql_whereWiHitsOnly( );
    $groupBy  = $this->sql_groupBy( );
    $orderBy  = $this->sql_orderBy( );
    $limit    = $this->sql_limit( );

      // Get query
    $query  = $GLOBALS['TYPO3_DB']->SELECTquery
                                    (
                                      $select,
                                      $from,
                                      $where,
                                      $groupBy,
                                      $orderBy,
                                      $limit
                                    );
      // Get query
      // Execute query
    $res    = $GLOBALS['TYPO3_DB']->exec_SELECTquery
                                    (
                                      $select,
                                      $from,
                                      $where,
                                      $groupBy,
                                      $orderBy,
                                      $limit
                                    );
      // Execute query

      // Error management
    $error = $GLOBALS['TYPO3_DB']->sql_error( );
    if( $error )
    {
      $this->pObj->objSqlFun->query = $query;
      $this->pObj->objSqlFun->error = $error;
      $arr_return = $this->pObj->objSqlFun->prompt_error( );
      return $arr_return;
    }
      // Error management

      // DRS
    if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql )
    {
      $prompt = $query;
      t3lib_div::devlog( '[OK/FILTER+SQL] ' . $prompt, $this->pObj->extKey, -1 );
    }
      // DRS

    $arr_return['data']['res'] = $res;
    return $arr_return;
  }









 /***********************************************
  *
  * SQL ressources to rows
  *
  **********************************************/








/**
 * sql_resToRows( ):  Handle the SQL result, free it. Return rows.
 *
 * @param	ressource		$res  : current SQL ressource
 * @return	array     $rows : rows
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_resToRows( $res )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Get the field label of the uid
    $uidField = $this->sql_filterFields[$table]['uid'];

      // LOOP build the rows
    while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc( $res ) )
    {
      $rows[ ( string ) $row[ $uidField ] ] = $row;
    }
      // LOOP build the rows

      // Free SQL result
    $GLOBALS['TYPO3_DB']->sql_free_result( $this->res );

      // RETURN rows
    return $rows;
  }








/**
 * sql_resToRows_allItemsWiHits( ): Handle the SQL result, free it. If param $rows_wiHitsOnly contains
 *                                  rows, the hit of each row will override the hit in the current row.
 *                                  Hit in the current row is 0 by default.
 *
 * @param	ressource		$res              : current SQL ressource
 * @param	array       $rows_wiHitsOnly  : rows with hits
 * @return	array     $rows_wiAllItems  : rows with all filter items
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_resToRows_allItemsWiHits( $res, $rows_wiHits )
  {
      // Get all rows - get all filter items
    $rows_wiAllItems = $this->sql_resToRows( $res );

      // RETURN all rows are empty
    if( empty ( $rows_wiAllItems ) )
    {
      return null;
    }
      // RETURN all rows are empty

      // RETURN all rows, there isn't any row with a hit
    if( empty ( $rows_wiHits ) )
    {
      return $rows_wiAllItems;
    }
      // RETURN all rows, there isn't any row with a hit

      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Get label of the hits field
    $hitsField = $this->sql_filterFields[$table]['hits'];

      // LOOP all items
    foreach( ( array ) $rows_wiAllItems as $uid => $row )
    {
        // If there is an hit, take it over
      if( isset ( $rows_wiHits[ $uid ] ) )
      {
        $hits = $rows_wiHits[ $uid ][ $hitsField ];
        $rows_wiAllItems[ $uid ][ $hitsField ] = $hits;
      }
        // If there is an hit, take it over
    }
      // LOOP all items

      // RETURN rows
    return $rows_wiAllItems;
  }









 /***********************************************
  *
  * SQL select
  *
  **********************************************/









/**
 * sql_select( ): Get the SELECT statement for the current filter (the current tableField).
 *                Statement will contain fields for localisation and treeview, if there is
 *                any need.
 *
 * @param	boolean		$bool_count : true: hits are counted, false: any hit isn't counted
 * @return	string		$select     : SELECT statement
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_select( $bool_count )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // EXIT wrong TS configuration
    $conf_view = $this->conf_view;
    if( ! empty ( $conf_view['filter.'][$table . '.'][$field . '.']['sql.']['select'] ) )
    {
      $prompt  = '
                  <h1 style="color:red;">
                    ERROR: filter
                  </h1>
                  <p style="color:red;font-weight:bold;">
                    Sorry: filter.' . $this->curr_tableField . '.sql.select isn\'t supported from TYPO3-Browser version 4.x<br />
                    <br />
                    Please remove the TypoScript code filter.' . $this->curr_tableField . '.sql.select.<br />
                    <br />
                    Method: ' . __METHOD__ . '<br />
                    Line: ' . __LINE__ . '
                  </p>';
      echo $prompt;
      exit;
    }
      // EXIT wrong TS configuration

      // select
    switch( $bool_count )
    {
      case( true ):
        $count = "count(*)";
        break;
      case( false ):
      default:
        $count = "0";
        break;
    }
    $select = $count . " AS 'hits', " .
              $table . ".uid AS '" . $table . ".uid', " .
              $this->curr_tableField . " AS '" . $this->curr_tableField . "'";
      // select

      // Set class var sql_filterFields
    $this->sql_filterFields[$table]['hits']   = 'hits';
    $this->sql_filterFields[$table]['uid']    = $table . '.uid';
    $this->sql_filterFields[$table]['value']  = $this->curr_tableField;
      // Set class var sql_filterFields

      // Add treeview field to select
    $select = $select . $this->sql_select_addTreeview( );

      // Add localisation fields to select
    $select = $select . $this->sql_select_addLL( );

      // RETURN select
    return $select;
  }









/**
 * sql_select_addLL( ): Returns an addSelect with the localisation fields,
 *                      if there are localisation needs.
 *                      Localisation fields depends on case
 *                      * local table   (sys_language record)
 *                      * foreign table (language overlay)
 *
 * @return	string		$addSelect  : the addSelect with the localisation fields
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_select_addLL( )
  {
      // RETURN no localisation
    if( $this->bool_dontLocalise )
    {
      return;
    }
      // RETURN no localisation

      // Get addSelect
    $addSelect = $this->sql_select_addLL_sysLanguage( );
    $addSelect = $addSelect . $this->sql_select_addLL_lang_ol( );
      // Get addSelect

      // RETURN addSelect
    return $addSelect;
  }









/**
 * sql_select_addLL_sysLanguage( ): Returns an addSelect with the localisation fields,
 *                                  if there are localisation needs.
 *                                  Method handles the local table (sys_language record) only.
 *
 * @return	string		$addSelect  : the addSelect with the localisation fields
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_select_addLL_sysLanguage( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // RETURN no languageField
    if( ! isset( $GLOBALS['TCA'][$table]['ctrl']['languageField'] ) )
    {
      if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
      {
        $prompt = $table . ' isn\'t a localised localTable: TCA.' . $table . 'ctrl.languageField is missing.';
        t3lib_div::devlog( '[INFO/FILTER+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
      }
      return;
    }
      // RETURN no languageField

      // RETURN no transOrigPointerField
    if( ! isset( $GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField'] ) )
    {
      if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
      {
        $prompt = $table . ' isn\'t a localised localTable: TCA.' . $table . 'ctrl.transOrigPointerField is missing.';
        t3lib_div::devlog( '[INFO/FILTER+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
      }
      return;
    }
      // RETURN no transOrigPointerField

      // Get field labels
    $languageField          = $GLOBALS['TCA'][$table]['ctrl']['languageField'];
    $languageField          = $table . '.' . $languageField;
    $transOrigPointerField  = $GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField'];
    $transOrigPointerField  = $table . '.' . $transOrigPointerField;
      // Get field labels

      // addSelect
    $addSelect  = ", " .
                  $languageField . " AS '" . $languageField . "', " .
                  $transOrigPointerField . " AS '" . $transOrigPointerField . "'";
      // addSelect

      // Add $languageField and $transOrigPointerField to the class var sql_filterFields
    $this->sql_filterFields[$table]['languageField']          = $languageField;
    $this->sql_filterFields[$table]['transOrigPointerField']  = $transOrigPointerField;

      // DRS
    if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
    {
      $prompt = $table . ' is a localised localTable. SELECT is localised.';
      t3lib_div::devlog( '[INFO/FILTER+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS

      // RETURN addSelect
    return $addSelect;
  }









/**
 * sql_select_addLL_lang_ol( ): Returns an addSelect with the localisation fields,
 *                              if there are localisation needs.
 *                              Method handles the foreign table (language overlay) only.
 *
 * @return	string		$addSelect  : the addSelect with the localisation fields
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_select_addLL_lang_ol(  )
  {
      // get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Load TCA
    $this->pObj->objZz->loadTCA( $table );

      // Get language overlay appendix
    $lang_ol        = $this->pObj->objLocalise->conf_localisation['TCA.']['field.']['appendix'];

      // Label of the  field for language overlay
    $field_lang_ol  = $field . $lang_ol;

      // RETURN no field for language overlay
    if( ! isset ($GLOBALS['TCA'][$table]['columns'][$field_lang_ol] ) )
    {
        // DRS
      if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
      {
        $prompt = $table . ' isn\'t a localised foreignTable: ' .
                  'TCA.' . $table . 'columns.' . $field_lang_ol . ' is missing.';
        t3lib_div::devlog( '[INFO/FILTER+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
      }
        // DRS
      return;
    }
      // RETURN no field for language overlay

      // addSelect
    $tableField_ol  = $table . '.' . $field_lang_ol;
    $addSelect      = ", " . $tableField_ol . " AS '" . $tableField_ol . "'";
      // addSelect

      // Add field to the class var sql_filterFields
    $this->sql_filterFields[$table]['lang_ol'] = $tableField_ol;

      // DRS
    if( $this->pObj->b_drs_filter || $this->pObj->b_drs_sql || $this->pObj->b_drs_localisation )
    {
      $prompt = $table . ' is a localised foreignTable. SELECT is localised.';
      t3lib_div::devlog( '[INFO/FILTER+SQL+LOCALISATION] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS

      // RETURN addSelect
    return $addSelect;
  }









/**
 * sql_select_addTreeview( ): Returns an addSelect with the treeParentField,
 *                            if there is a treeParentField
 *
 * @return	string		$addSelect  : the addSelect with the treeParentField
 * @internal #32223, 120119
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_select_addTreeview( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // #32223, 120120, dwildt+
      // Get $treeviewEnabled
    $conf_view        = $this->conf_view;
    $cObj_name        = $conf_view['filter.'][$table . '.'][$field . '.']['treeview.']['enabled'];
    $cObj_conf        = $conf_view['filter.'][$table . '.'][$field . '.']['treeview.']['enabled.'];
    $treeviewEnabled  = $this->pObj->cObj->cObjGetSingle( $cObj_name, $cObj_conf );
      // Get $treeviewEnabled

      // RETURN no treeview
    if( ! $treeviewEnabled )
    {
      if( $this->pObj->b_drs_filter )
      {
        $prompt = 'treeview is disabled. Has an effect only in case of cps_tcatree and a proper TCA configuration.';
        t3lib_div :: devlog( '[INFO/FILTER] ' . $prompt, $this->pObj->extKey, 0 );
      }
      return;
    }
      // RETURN no treeview

      // DRS
    if( $this->pObj->b_drs_filter )
    {
      $prompt = 'treeview is enabled. Has an effect only in case of cps_tcatree and a proper TCA configuration.';
      t3lib_div :: devlog( '[INFO/FILTER] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS

      // Load the TCA for the current table
    $this->pObj->objZz->loadTCA( $table );

      // RETURN table hasn't any treeParentField in the TCA
    if( ! isset( $GLOBALS['TCA'][$table]['ctrl']['treeParentField'] ) )
    {
      if( $this->pObj->b_drs_filter )
      {
        $prompt = 'TCA.' . $table . '.ctrl.treeParentField isn\'t set.';
        t3lib_div :: devlog( '[INFO/FILTER] ' . $prompt, $this->pObj->extKey, 0 );
      }
        // Prompt the expired time to devlog
      $this->pObj->timeTracking_log( __METHOD__, __LINE__,  'end' );
      return;
    }
      // RETURN table hasn't any treeParentField in the TCA

      // Get $tableTreeParentField
    $treeParentField      = $GLOBALS['TCA'][$table]['ctrl']['treeParentField'];
    $tableTreeParentField = $table . "." . $treeParentField;

      // Add $tableTreeParentField to the SELECT statement
    $addSelect = ", " . $tableTreeParentField . " AS '" . $tableTreeParentField . "'";

      // Add $tableTreeParentField to the class var array
    $this->sql_filterFields[$table]['treeParentField']  = $tableTreeParentField;

      // Add table to arr_tablesWiTreeparentfield
    $this->pObj->objFilter->arr_tablesWiTreeparentfield[] = $table;

      // DRS
    if( $this->pObj->b_drs_filter )
    {
      $prompt = 'TCA.' . $table . '.ctrl.treeParentField is set. ' . $table . ' is configured for a tree view.';
      t3lib_div :: devlog( '[INFO/FILTER] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS

    return $addSelect;
  }









 /***********************************************
  *
  * SQL from, groupBy, orderBy, limit
  *
  **********************************************/









/**
 * sql_from( ): Get the FROM statement ...
 *
 * @return	string		$from : FROM statement
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_from( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

    switch( true )
    {
      case( $this->pObj->localTable != $table ):
          // foreign table
        $from = $this->pObj->objSql->sql_query_statements['rows']['from'];
        break;
      case( $this->pObj->localTable == $table ):
      default:
          // local table
        $from = $table;
        break;
    }
      // Get FROM statement

      // RETURN FROM statement
    return $from;
  }









/**
 * sql_groupBy( ): Get the GROUP BY statement ...
 *
 * @return	string		$from : GROUP BY statement
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_groupBy( )
  {
      // Get WHERE statement
    $groupBy = $this->curr_tableField;

      // RETURN GROUP BY statement without GROUP BY
    return $groupBy;
  }









/**
 * sql_orderBy( ):  Get the ORDER BY statement. It depends on the TS configuration
 *                  filter.table.field.order
 *
 * @return	string		$orderBy : ORDER BY statement without ORDER BY
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_orderBy( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Short var
    $arr_order  = $this->conf_view['filter.'][$table . '.'][$field . '.']['order.'];

      // Order field
    switch( true )
    {
      case( $arr_order['field'] == 'uid' ):
        $orderField = $this->sql_filterFields[$table]['uid'];
        break;
      case( $arr_order['field'] == 'value' ):
      default:
        $orderField = $this->sql_filterFields[$table]['value'];
        break;
    }
      // Order field

      // Order flag
    switch( true )
    {
      case( $arr_order['orderFlag'] == 'DESC' ):
        $orderFlag = 'DESC';
        break;
      case( $arr_order['orderFlag'] == 'ASC' ):
      default:
        $orderFlag = 'ASC';
        break;
    }
      // Order flag

      // Get ORDER BY statement
    $orderBy = $orderField . ' ' . $orderFlag;

      // RETURN ORDER BY statement
    return $orderBy;
  }









/**
 * sql_limit( ): Get the LIMIT statement ...
 *
 * @return	string		$limit : LIMIT statement
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_limit( )
  {
      // Get LIMIT statement
    $limit = null;

      // RETURN LIMIT statement
    return $limit;
  }









 /***********************************************
  *
  * SQL where
  *
  **********************************************/









/**
 * sql_whereAllItems( ):  Get the WHERE statement for all items.
 *                        All items means: idenependent of any hit.
 *
 * @return	string		$where : WHERE statement without WHERE
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_whereAllItems( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

    //$this->pObj->dev_var_dump( __METHOD__, __LINE__, $this->pObj->arr_realTables_arrFields );

      // DRS :TODO:
    if( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Add andWhere from TS.';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS :TODO:

    $where  = '1 ' .
              $this->sql_andWhere_pidList( ) .
              $this->sql_andWhere_enableFields( ) .
              $this->sql_andWhere_fromTS( ) .
              $this->sql_andWhere_sysLanguage( );
      // Get WHERE statement

      // RETURN WHERE statement without a WHERE
    return $where;
  }









/**
 * sql_whereWiHitsOnly( ):  Get the WHERE statement for a filter, which should diplay
 *                          flter items with a hit only.
 *
 * @return	string		$where : WHERE statement without WHERE
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_whereWiHitsOnly( )
  {
      // DRS :TODO:
    if( $this->pObj->b_drs_devTodo )
    {
      $prompt = 'Add andWhere from TS.';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS :TODO:

      // Get WHERE statement
    $where = $this->pObj->objSql->sql_query_statements['rows']['where'] .
             $this->sql_andWhere_fromTS( );

      // RETURN WHERE statement without a WHERE
    return $where;
  }









/**
 * sql_andWhere_enableFields( ): Get the AND WHERE statement with the enabled fields.
 *
 * @return	string		$andWhere : AND WHERE statement with an AND
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_andWhere_enableFields( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

    $andWhere = $this->pObj->cObj->enableFields( $table );

      // RETURN AND WHERE statement
    return $andWhere;
  }









/**
 * sql_andWhere_fromTS( ):  Get the AND WHERE statement from the TS configuration.
 *                          See sql.andWhere.
 *
 * @return	string		$andWhere : AND WHERE statement with an AND
 * @version 3.9.9
 * @since   3.9.9
 */


  private function sql_andWhere_fromTS( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Get TS value
    $andWhere = $this->conf_view['filter.'][$table . '.'][$field . '.']['sql.andWhere.']['andWhere'];

    if( ! empty ( $andWhere ) )
    {
      $andWhere = " AND " . $andWhere;
    }

      // RETURN AND WHERE statement
    return $andWhere;
  }









/**
 * sql_andWhere_pidList( ): Get the AND WHERE statement with the pid list.
 *
 * @return	string		$andWhere : AND WHERE statement with an AND
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_andWhere_pidList( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

    if( empty ( $this->pObj->pidList ) )
    {
        // DRS
      if( $this->pObj->b_drs_warn )
      {
        $prompt = 'There isn\'t any pid list for the records of ' . $table . '. Maybe this is an error.';
        t3lib_div::devlog( '[WARN/FILTER+SQL] ' . $prompt, $this->pObj->extKey, 2 );
      }
        // DRS
      return;
    }

    $fieldsOfTable = $this->pObj->arr_realTables_arrFields[$table];
    if( ! in_array( 'pid', $fieldsOfTable ) )
    {
        // DRS
      if( $this->pObj->b_drs_warn )
      {
        $prompt = $table . ' shouldn\'t have any pid field. Maybe this is an error.';
        t3lib_div::devlog( '[WARN/FILTER+SQL] ' . $prompt, $this->pObj->extKey, 2 );
      }
        // DRS
      return;
    }

    $andWhere = " AND " . $table . ".pid IN (" . $this->pObj->pidList . ")";

      // RETURN AND WHERE statement
    return $andWhere;
  }









/**
 * sql_andWhere_sysLanguage( ): Get the AND WHERE statement with gthe sys_language_uid.
 *                              It is an AND WHERE for tables which have a record for each
 *                              language.
 *
 * @return	string		$andWhere : AND WHERE statement with an AND
 * @version 3.9.9
 * @since   3.9.9
 */
  private function sql_andWhere_sysLanguage( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

    if( ! isset( $this->sql_filterFields[$table]['languageField'] ) )
    {
      return;
    }

    $languageField  = $this->sql_filterFields[$table]['languageField'];
    $languageId     = $GLOBALS['TSFE']->sys_language_content;

      // DRS :TODO:
    if( $this->pObj->b_drs_devTodo )
    {
      $prompt = '$this->int_localisation_mode PI1_SELECTED_OR_DEFAULT_LANGUAGE: for each language a query!';
      t3lib_div::devlog( '[INFO/TODO] ' . $prompt, $this->pObj->extKey, 0 );
    }
      // DRS :TODO:

    switch( $this->int_localisation_mode )
    {
      case( PI1_DEFAULT_LANGUAGE ):
        $andWhere = " AND " . $languageField . " <= 0 ";
        break;
      case( PI1_SELECTED_OR_DEFAULT_LANGUAGE ):
        $andWhere = " AND ( " .
                      $languageField . " <= 0 OR " .
                      $languageField . " = " . intval( $languageId ) .
                    " ) ";
        break;
      case( PI1_SELECTED_LANGUAGE_ONLY ):
        $andWhere = " AND " . $languageField . " = " . intval( $languageId ) . " ";
        break;
      default:
        $andWhere = null;
        break;
    }

      // RETURN AND WHERE statement
    return $andWhere;
  }









 /***********************************************
  *
  * TypoScript
  *
  **********************************************/









  /**
 * ts_condition( ):  Render the filter condition
 *
 * @return	boolean		True, if filter should displayed, false if filter shouldn't diplayed
 * @version 3.9.3
 * @since   3.9.3
 */
  private function ts_condition( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );
    $tableField = $this->curr_tableField;

      // Get TS configuration array
    $coa_name = $this->conf_view['filter.'][$table . '.'][$field . '.']['condition'];
    $coa_conf = $this->conf_view['filter.'][$table . '.'][$field . '.']['condition.'];

      // RETURN true: any condition isn't defined
    if( empty ( $coa_name ) )
    {
      if ( $this->pObj->b_drs_filter )
      {
        $prompt = $tableField . ' hasn\'t any condition. Filter will displayed.';
        t3lib_div :: devLog('[INFO/FILTER] ' . $prompt , $this->pObj->extKey, 0);
      }
      return true;
    }
      // RETURN true: any condition isn't defined

      // Get condition result
    $value = $this->pObj->cObj->cObjGetSingle($coa_name, $coa_conf);
    switch( $value )
    {
      case( false ):
        $bool_condition = false;
        if ( $this->pObj->b_drs_filter )
        {
          $prompt = 'Condition of ' . $tableField . ' is false. Filter won\'t displayed.';
          t3lib_div :: devLog('[INFO/FILTER] ' . $prompt , $this->pObj->extKey, 0);
        }
        break;
      case( true ):
      default;
        $bool_condition = true;
        if ( $this->pObj->b_drs_filter )
        {
          $prompt = 'Condition of ' . $tableField . ' is true. Filter will displayed.';
          t3lib_div :: devLog('[INFO/FILTER] ' . $prompt , $this->pObj->extKey, 0);
        }
        break;
    }
      // Get condition result

      // RETURN condition result
    return $bool_condition;
  }









/**
 * ts_displayWithoutAnyHit( ):  Get the TS configuration for displaying items without hits.
 *                              If current filter is a tree view, return value is true.
 *
 * @return	string		$display_without_any_hit : value from TS configuration
 * @version 3.9.9
 * @since   3.9.9
 */
  private function ts_displayWithoutAnyHit( )
  {
      // Get table and field
    list( $table, $field ) = explode( '.', $this->curr_tableField );

      // Short var
    $currFilterWrap = $this->conf_view['filter.'][$table . '.'][$field . '.']['wrap.'];

      // Get TS value
    $display_without_any_hit = $currFilterWrap['item.']['display_without_any_hit'];

      // RETURN ts value directly: filter isn't a tree view filter
    if ( ! in_array( $table, $this->pObj->objFilter->arr_tablesWiTreeparentfield ) )
    {
      return $display_without_any_hit;
    }
      // RETURN ts value directly: filter isn't a tree view filter

      // RETURN true: filter is a tree view filter
      // DRS - Development Reporting System
    if( $this->pObj->b_drs_filter )
    {
      if( $display_without_any_hit == false )
      {
        $prompt = 'wrap.item.display_without_any_hit is false. But ' . $this->curr_tableField . ' is displayed in a tree view: display_without_any_hit is set to true!';
        t3lib_div :: devlog('[INFO/FILTER] ' . $prompt, $this->pObj->extKey, 0);
      }
    }
      // DRS - Development Reporting System

      // RETURN
    return true;
      // RETURN true: filter is a tree view filter
  }









}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/browser/pi1/class.tx_browser_pi1_filter_4x.php']) {
  include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/browser/pi1/class.tx_browser_pi1_filter_4x.php']);
}
?>
