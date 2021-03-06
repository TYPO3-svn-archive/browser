<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2016 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 * The class tx_browser_tcemainprocdm bundles methods for evaluating data in backend forms
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage  browser
 *
 * @version 4.6.3
 * @since 4.5.7
 */

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   77: class tx_browser_tcemainprocdm
 *
 *              SECTION: Hook: processDatamap_postProcessFieldArray
 *  122:     public function processDatamap_postProcessFieldArray( $status, $table, $id, &$fieldArray, &$reference )
 *
 *              SECTION: Geo Update
 *  167:     private function geoupdate( &$fieldArray )
 *  218:     private function geoupdateGoogleAPI( &$fieldArray, $address )
 *  248:     private function geoupdateHandleData( &$fieldArray )
 *  334:     private function geoupdateHandleDataGetAddress( $fieldArray, $row )
 *  408:     private function geoupdateHandleDataGetAddressAreaLevel1( $fieldArray, $row )
 *  433:     private function geoupdateHandleDataGetAddressAreaLevel2( $fieldArray, $row )
 *  458:     private function geoupdateHandleDataGetAddressCountry( $fieldArray, $row )
 *  483:     private function geoupdateHandleDataGetAddressLocation( $fieldArray, $row )
 *  527:     private function geoupdateHandleDataGetAddressStreet( $fieldArray, $row )
 *  569:     private function geoupdateIsAddressUntouched( &$fieldArray )
 *  598:     private function geoupdateIsForbiddenByRecord( &$fieldArray )
 *  631:     private function geoupdateRequired( &$fieldArray )
 *  681:     private function geoupdateSetLabels( )
 *  728:     private function geoupdateSetPrompt( $prompt, &$fieldArray )
 *  770:     private function geoupdateSetRow( )
 *
 *              SECTION: Log
 *  864:     public function log( $prompt, $error=0, $action=2 )
 *
 *              SECTION: Route
 *  895:     private function route( &$fieldArray, &$reference )
 *  911:     private function routeGpx( &$fieldArray, &$reference )
 *  940:     private function routeGpxHandleData( &$fieldArray )
 * 1017:     private function routeGpxRequired( $fieldArray )
 *
 * TOTAL FUNCTIONS: 21
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_browser_tcemainprocdm
{

  // [String] status of the current process: update, edit, delete, moved
  private $prefixLog = 'tx_browser ';
  // [String] status of the current process: update, edit, delete, moved
  private $processStatus = null;
  // [String] label of the table of the current process
  private $processTable = null;
  // [String] record uid of the current process
  private $processId = null;
  // [Object] parent object
  private $pObj = null;
  // [String] Geo API URL
  private $googleApiUrl = 'http://maps.googleapis.com/maps/api/geocode/json?address=%address%&sensor=false';
  // [Array] Geoupdate lables from ext_tables.php
  private $geoupdatelabels = null;
  // [Array] Row of the current record with former data
  private $geoupdaterow = null;
  // [Array] Row of the current record with former data
  private $row = null;

  /*   * *********************************************
   *
   * Hook: processDatamap_postProcessFieldArray
   *
   * ******************************************** */

  /**
   * processDatamap_postProcessFieldArray( )
   *
   * @param    string        $status     : update, edit, delete, moved
   * @param    string        $table      : label of the current table
   * @param    integer        $id         : uid of the current record
   * @param    array        $fieldArray : modified fields - reference!
   * @param    object        $reference  : parent object - reference!
   * @return    void
   * @version   4.6.3
   * @since     4.5.7
   */
  public function processDatamap_postProcessFieldArray( $status, $table, $id, &$fieldArray, &$reference )
  {
    // RETURN : current table is without any tx_browser configuration
    if ( !is_array( $GLOBALS[ 'TCA' ][ $table ][ 'ctrl' ][ 'tx_browser' ] ) )
    {
      return;
    }
    // RETURN : current table is without any tx_browser configuration
    // Initial global variables
    $this->processStatus = $status;
    $this->processTable = $table;
    $this->processId = $id;
    $this->pObj = $reference;

    // #51478, 130829, dwildt
    if ( is_array( $GLOBALS[ 'TCA' ][ $table ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ] ) )
    {
      $this->geoupdate( $fieldArray, $reference );
    }

    if ( is_array( $GLOBALS[ 'TCA' ][ $table ][ 'ctrl' ][ 'tx_browser' ][ 'route' ] ) )
    {
      // #52166, 130921, dwildt
      $this->route( $fieldArray, $reference );
    }

    return;
  }

  /*   * *********************************************
   *
   * Geo Update
   *
   * ******************************************** */

  /**
   * geoupdate( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @return    void
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdate( &$fieldArray )
  {
    // RETURN : requirements aren't matched
    if ( !$this->geoupdateRequired( $fieldArray ) )
    {
//      $prompt = $this->processStatus . ': ' . $this->processTable . ': ' . $this->processId  . ': ' . var_export( $fieldArray, true );
//      $this->log( $prompt );
      return;
    }
    // RETURN : requirements aren't matched
    // Get lables from ext_tables.php.
    $this->geoupdateSetLabels();

    // RETURN : no address field is touched
    if ( $this->geoupdateIsAddressUntouched( $fieldArray ) )
    {
      return;
    }
    // RETURN : no address field is touched
    // RETURN : no address field is touched
    if ( $this->geoupdateIsForbiddenByRecord( $fieldArray ) )
    {
      return;
    }
    // RETURN : no address field is touched



    $arrResult = $this->geoupdateHandleData( $fieldArray );
    if ( $arrResult[ 'error' ] )
    {
      return;
    }

//    $prompt = $this->processStatus . ': ' . $this->processTable . ': ' . $this->processId  . ': ' . var_export( $fieldArray, true );
//    $this->log( $prompt, 1, 2, 1 );

    return;
  }

  /**
   * geoupdateGoogleAPI( )
   *
   * @param    array        $fieldArray : Array of modified fields * @param    string        $address    : Address
   * @param    [type]        $address: ...
   * @return    array        $geodata    : lon, lat
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateGoogleAPI( &$fieldArray, $address )
  {
    // Require map library
    require_once( PATH_typo3conf . 'ext/browser/lib/mapAPI/class.tx_browser_googleApi.php' );
    // Create object
    $objGoogleApi = new tx_browser_googleApi( );

    // Get data from API
    $result = $objGoogleApi->main( $address, $this );

    // Prompt to current record
    if ( isset( $result[ 'status' ] ) )
    {
      $prompt = $result[ 'status' ];
      $this->geoupdateSetPrompt( $prompt, $fieldArray );
    }
    // Prompt to current record
    // RETURN geodata
    return $result[ 'geodata' ];
  }

  /**
   * geoupdateHandleData( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @return    void
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleData( &$fieldArray )
  {
    // get lables for geodata
    $geodata = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ][ 'geodata' ];

    // Get former address data
    // 131223, dwilt, 1-
//    $row = $this->geoupdateSetRow( );
    // 131223, dwilt, 1+
    $row = $this->setRow();

    // Get address
    $address = $this->geoupdateHandleDataGetAddress( $fieldArray, $row );
    if ( empty( $address ) )
    {
      // update geodata
      $fieldArray[ $geodata[ 'lat' ] ] = null;
      $fieldArray[ $geodata[ 'lon' ] ] = null;

      // Prompt to the current record
      $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataRemoved' );
      $this->geoupdateSetPrompt( $prompt, $fieldArray );
      // Prompt to the current record
      // logging
      $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataRemoved' );
      $this->log( $prompt, 2, 2, 1 );
      // logging

      return;
    }

    // Get geodata
    $latLon = $this->geoupdateGoogleAPI( $fieldArray, $address );
    $lat = $latLon[ 'lat' ];
    $lon = $latLon[ 'lon' ];

    // RETURN : lan or lot is null
    switch ( true )
    {
      case( $lat == null ):
      case( $lon == null ):
        $prompt = 'WARNING: Returned latitude and/or longitude is null. Latitude and longitude aren\'t changed.';
        $this->log( $prompt, 3, 2, 1 );
        return;
        break;
      default:
        // follow the workflow
        break;
    }
    // RETURN : lan or lot is null
    // update geodata
    $fieldArray[ $geodata[ 'lat' ] ] = $lat;
    $fieldArray[ $geodata[ 'lon' ] ] = $lon;

    // Prompt to the current record
    $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataUpdate' );
    $this->geoupdateSetPrompt( $prompt, $fieldArray );
    // Prompt to the current record
    // logging
    $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataUpdate' );
    $this->log( $prompt, 2, 2, 1 );
    $prompt = 'Address: ' . $address;
    $this->log( $prompt, -1 );
    $prompt = 'latitude: ' . $lat . '; longigute: ' . $lon;
    $this->log( $prompt, -1 );

    // logging

    return;
  }

  /**
   * geoupdateHandleDataGetAddress( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @param    [type]        $row: ...
   * @return    string        $address    : Address
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleDataGetAddress( $fieldArray, $row )
  {
    $address = null;
    $arrAddress = array();

    // Set street
    $street = $this->geoupdateHandleDataGetAddressStreet( $fieldArray, $row );
    if ( $street )
    {
      $arrAddress[ 'street' ] = $street;
    }
    // Set street
    // Set location
    $location = $this->geoupdateHandleDataGetAddressLocation( $fieldArray, $row );
    if ( $location )
    {
      $arrAddress[ 'location' ] = $location;
    }
    // Set location
    // Set areaLevel2
    $areaLevel2 = $this->geoupdateHandleDataGetAddressAreaLevel2( $fieldArray, $row );
    if ( $areaLevel2 )
    {
      $arrAddress[ 'areaLevel2' ] = $areaLevel2;
    }
    // Set areaLevel2
    // Set areaLevel1
    $areaLevel1 = $this->geoupdateHandleDataGetAddressAreaLevel1( $fieldArray, $row );
    if ( $areaLevel1 )
    {
      $arrAddress[ 'areaLevel1' ] = $areaLevel1;
    }
    // Set areaLevel1
    // Set country
    $country = $this->geoupdateHandleDataGetAddressCountry( $fieldArray, $row );
    if ( $country )
    {
      $arrAddress[ 'country' ] = $country;
    }
    // Set country
    // 'Amphitheatre Parkway 1600, Mountain View, CA';
    $address = implode( ', ', $arrAddress );

    // Logging
    switch ( $address )
    {
      case( false ):
        $prompt = 'OK: address is empty.';
        $this->log( $prompt, 1, 2, 1 );
        break;
      case( true ):
      default:
        $prompt = 'OK: address is "' . $address . '"';
        $this->log( $prompt, -1 );
        break;
    }
    // Logging

    return $address;
  }

  /**
   * geoupdateHandleDataGetAddressAreaLevel1( )
   *
   * @param    array        $fieldArray   : Array of modified fields
   * @param    array        $row    : Array of former field values (from database)
   * @return    string        $country       : AreaLevel1
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleDataGetAddressAreaLevel1( $fieldArray, $row )
  {
    $areaLevel1 = null;

    if ( isset( $this->geoupdatelabels[ 'address' ][ 'areaLevel1' ] ) )
    {
      $areaLevel1 = $row[ $this->geoupdatelabels[ 'address' ][ 'areaLevel1' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'areaLevel1' ] ] ) )
      {
        $areaLevel1 = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'areaLevel1' ] ];
      }
    }

    return $areaLevel1;
  }

  /**
   * geoupdateHandleDataGetAddressAreaLevel2( )
   *
   * @param    array        $fieldArray   : Array of modified fields
   * @param    array        $row    : Array of former field values (from database)
   * @return    string        $country       : AreaLevel2
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleDataGetAddressAreaLevel2( $fieldArray, $row )
  {
    $areaLevel2 = null;

    if ( isset( $this->geoupdatelabels[ 'address' ][ 'areaLevel2' ] ) )
    {
      $areaLevel2 = $row[ $this->geoupdatelabels[ 'address' ][ 'areaLevel2' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'areaLevel2' ] ] ) )
      {
        $areaLevel2 = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'areaLevel2' ] ];
      }
    }

    return $areaLevel2;
  }

  /**
   * geoupdateHandleDataGetAddressCountry( )
   *
   * @param    array        $fieldArray   : Array of modified fields
   * @param    array        $row    : Array of former field values (from database)
   * @return    string        $country       : Country
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleDataGetAddressCountry( $fieldArray, $row )
  {
    $country = null;

    if ( isset( $this->geoupdatelabels[ 'address' ][ 'country' ] ) )
    {
      $country = $row[ $this->geoupdatelabels[ 'address' ][ 'country' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'country' ] ] ) )
      {
        $country = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'country' ] ];
      }
    }

    return $country;
  }

  /**
   * geoupdateHandleDataGetAddressLocation( )
   *
   * @param    array        $fieldArray   : Array of modified fields
   * @param    array        $row    : Array of former field values (from database)
   * @return    string        $location       : Location
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleDataGetAddressLocation( $fieldArray, $row )
  {
    // Get location
    $arrLocation = array();
    if ( isset( $this->geoupdatelabels[ 'address' ][ 'locationZip' ] ) )
    {
      $arrLocation[ 'zip' ] = $row[ $this->geoupdatelabels[ 'address' ][ 'locationZip' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'locationZip' ] ] ) )
      {
        $arrLocation[ 'zip' ] = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'locationZip' ] ];
      }
      if ( empty( $arrLocation[ 'zip' ] ) )
      {
        unset( $arrLocation[ 'zip' ] );
      }
    }

    if ( isset( $this->geoupdatelabels[ 'address' ][ 'locationCity' ] ) )
    {
      $arrLocation[ 'city' ] = $row[ $this->geoupdatelabels[ 'address' ][ 'locationCity' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'locationCity' ] ] ) )
      {
        $arrLocation[ 'city' ] = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'locationCity' ] ];
      }
      if ( empty( $arrLocation[ 'city' ] ) )
      {
        unset( $arrLocation[ 'city' ] );
      }
    }

    $location = implode( ' ', $arrLocation );

    return $location;
  }

  /**
   * geoupdateHandleDataGetAddressStreet( )
   *
   * @param    array        $fieldArray   : Array of modified fields
   * @param    array        $row    : Array of former field values (from database)
   * @return    string        $street       : Street
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateHandleDataGetAddressStreet( $fieldArray, $row )
  {
    // Get street
    $arrStreet = array();
    if ( isset( $this->geoupdatelabels[ 'address' ][ 'streetName' ] ) )
    {
      $arrStreet[ 'name' ] = $row[ $this->geoupdatelabels[ 'address' ][ 'streetName' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'streetName' ] ] ) )
      {
        $arrStreet[ 'name' ] = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'streetName' ] ];
      }
      if ( empty( $arrStreet[ 'name' ] ) )
      {
        unset( $arrStreet[ 'name' ] );
      }
    }
    if ( isset( $this->geoupdatelabels[ 'address' ][ 'streetNumber' ] ) )
    {
      $arrStreet[ 'number' ] = $row[ $this->geoupdatelabels[ 'address' ][ 'streetNumber' ] ];
      if ( isset( $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'streetNumber' ] ] ) )
      {
        $arrStreet[ 'number' ] = $fieldArray[ $this->geoupdatelabels[ 'address' ][ 'streetNumber' ] ];
      }
      if ( empty( $arrStreet[ 'number' ] ) )
      {
        unset( $arrStreet[ 'number' ] );
      }
    }

    $street = implode( ' ', $arrStreet );

    return $street;
  }

  /**
   * geoupdateIsAddressUntouched( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @return    boolean        $untouched  : true, if address data are untouched
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateIsAddressUntouched( &$fieldArray )
  {
    // RETURN : false, an address field is touched at least
    foreach ( $this->geoupdatelabels[ 'address' ] as $label )
    {
      if ( isset( $fieldArray[ $label ] ) )
      {
        return false;
      }
    }
    // RETURN : false, an address field is touched at least
//    $prompt = 'OK: Address data are untouched.';
//    $this->geoupdateSetPrompt( $prompt, $fieldArray );

    $prompt = 'OK: Address data are untouched.';
    $this->log( $prompt, -1 );

    return true;
  }

  /**
   * geoupdateIsForbiddenByRecord( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @return    boolean        $untouched  : true, if address data are untouched
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateIsForbiddenByRecord( &$fieldArray )
  {
    // Get former address data
    // 131223, dwilt, 1-
//    $row = $this->geoupdateSetRow( );
    // 131223, dwilt, 1+
    $row = $this->setRow();

    if ( !isset( $this->geoupdatelabels[ 'api' ][ 'forbidden' ] ) )
    {
      return false;
    }

    $forbidden = $row[ $this->geoupdatelabels[ 'api' ][ 'forbidden' ] ];
    if ( isset( $fieldArray[ $this->geoupdatelabels[ 'api' ][ 'forbidden' ] ] ) )
    {
      $forbidden = $fieldArray[ $this->geoupdatelabels[ 'api' ][ 'forbidden' ] ];
    }

    if ( $forbidden )
    {
      // Prompt to the current record
//      $prompt = '"' . $this->geoupdatelabels[ 'api' ][ 'forbidden' ] . '"' . PHP_EOL
//              . $GLOBALS['LANG']->sL('LLL:EXT:browser/lib/locallang.xml:promptGeodataIsForbiddenByRecord')
//              ;
      $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataIsForbiddenByRecord' );
      $this->geoupdateSetPrompt( $prompt, $fieldArray );
      // Prompt to the current record
      return true;
    }

    return false;
  }

  /**
   * geoupdateRequired( )
   *
   * @param    [type]        $&$fieldArray: ...
   * @return    boolean        $requirementsMatched  : true if requierements matched, false if not.
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateRequired( &$fieldArray )
  {
    $requirementsMatched = true;

    $address = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ][ 'address' ];
    $geodata = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ][ 'geodata' ];
    $update = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ][ 'update' ];

    switch ( true )
    {
      case(!$update ):
        // Prompt to the current record
        $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataDisabledByExttablesphp' );
        $this->geoupdateSetPrompt( $prompt, $fieldArray );
        // Prompt to the current record

        $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGeodataEnableByExtmngr' );
        $this->log( $prompt, 1, 2, 1 );
        $prompt = 'OK: $GLOBALS[TCA][' . $this->processTable . '][ctrl][tx_browser][geoupdate][update] is set to false. '
                . 'Geodata won\'t updated.'
        ;
        $this->log( $prompt, -1 );
        $requirementsMatched = false;
        return $requirementsMatched;
        break;
      case( empty( $address ) ):
      case( empty( $geodata ) ):
        $prompt = 'ERROR: $GLOBALS[TCA][' . $this->processTable . '][ctrl][tx_browser][geoupdate] is set, '
                . 'but the element [address] and/or [geodata] isn\'t configured! '
                . 'Please take care off a proper TCA configuration!'
        ;
        $this->log( $prompt, 4, 2, 1 );
        $requirementsMatched = false;
        return $requirementsMatched;
        break;
    }

    unset( $address );
    unset( $geodata );
    unset( $update );

    return $requirementsMatched;
  }

  /**
   * geoupdateSetLabels( )  : Set lables. Get lables from ext_tables.php.
   *
   * @return    void
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateSetLabels()
  {
    if ( $this->geoupdatelabels !== null )
    {
      return;
    }

    $tcaCtrlAddress = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ][ 'address' ];

    $labels = array(
      'address' => array(
        'areaLevel1' => $tcaCtrlAddress[ 'areaLevel1' ],
        'areaLevel2' => $tcaCtrlAddress[ 'areaLevel2' ],
        'country' => $tcaCtrlAddress[ 'country' ],
        'locationZip' => $tcaCtrlAddress[ 'location' ][ 'zip' ],
        'locationCity' => $tcaCtrlAddress[ 'location' ][ 'city' ],
        'streetName' => $tcaCtrlAddress[ 'street' ][ 'name' ],
        'streetNumber' => $tcaCtrlAddress[ 'street' ][ 'number' ]
      ),
      'api' => $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'geoupdate' ][ 'api' ]
    );

    // Remove empty labels
    foreach ( $labels as $groupKey => $group )
    {
      foreach ( $group as $labelKey => $label )
      {
        if ( empty( $label ) )
        {
          unset( $labels[ $groupKey ][ $labelKey ] );
        }
      }
    }
    // Remove empty labels

    $this->geoupdatelabels = $labels;
  }

  /**
   * geoupdateSetPrompt( )  : Set lables. Get lables from ext_tables.php.
   *
   * @param    string        $prompt     :
   * @param    array        $fieldArray : Array of modified fields
   * @return    void
   * @version   4.5.13
   * @since     4.5.13
   */
  private function geoupdateSetPrompt( $prompt, &$fieldArray )
  {
    $this->geoupdateSetLabels();

    // RETURN : no record field for prompting configured
    if ( !isset( $this->geoupdatelabels[ 'api' ][ 'prompt' ] ) )
    {
      $prompt = 'Geoupdate can\'t prompt to the record, because there is no prompt field configured.';
      $this->log( $prompt, 0, 2, 1 );
      return;
    }
    // RETURN : no record field for prompting configured
    // Get former address data
    // 131223, dwilt, 1-
//    $row = $this->geoupdateSetRow( );
    // 131223, dwilt, 1+
    $row = $this->setRow();

    $promptFromRow = $row[ $this->geoupdatelabels[ 'api' ][ 'prompt' ] ];
    if ( isset( $fieldArray[ $this->geoupdatelabels[ 'api' ][ 'prompt' ] ] ) )
    {
      $promptFromRow = $fieldArray[ $this->geoupdatelabels[ 'api' ][ 'prompt' ] ];
    }

    $date = date( 'Y-m-d H:i:s' );
    $browser = ' - ' . $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptBrowserPhrase' ) . ':';
    $prompt = '* ' . $date . $browser . PHP_EOL
            . '  ' . $prompt . PHP_EOL
            . $promptFromRow
    ;
    // 130902, dwildt, 1-
    //$prompt = $GLOBALS['TYPO3_DB']->quoteStr( $prompt, $this->processTable );

    $fieldArray[ $this->geoupdatelabels[ 'api' ][ 'prompt' ] ] = $prompt;
  }

  /*   * *********************************************
   *
   * Log
   *
   * ******************************************** */

  /**
   * log( )
   *
   * @param	string		$prompt : prompt
   * @param	integer		$status : -1 = no flash message, 0 = notice, 1 = info, 3 = OK, 4 = warn, 5 = error
   * @param	string		$action : 0=No category, 1=new record, 2=update record, 3= delete record, 4= move record, 5= Check/evaluate
   * @param	string		$header : 0=No header, 1=Geocoding by Browser - TYPO3 without PHP, 2=Browser - TYPO3 without PHP
   * @return	void
   * @access public
   * @version   4.8.5
   * @since     4.5.7
   */
  public function log( $prompt, $status = -1, $action = 2, $header = 2 )
  {
    $table = $this->processTable;
    $uid = $this->processId;
    $pid = null;

    $fmPrompt = $prompt;
    $logPrompt = '[' . $this->prefixLog . ' (' . $table . ':' . $uid . ')] ' . $prompt . PHP_EOL;

    switch ( $header )
    {
      case( 0 ):
        $fmHeader = '';
        break;
      case( 1 ):
        $fmHeader = 'Geocoding by ' . $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptBrowserPhrase' );
        break;
      case( 2 ):
      default:
        $fmHeader = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptBrowserPhrase' );
        break;
    }

    switch ( $status )
    {
      case( -1 ):
        $fmStatus = null;
        $logStatus = 0;
        break;
      case( 0 ):
        $fmStatus = t3lib_FlashMessage::NOTICE;
        $logStatus = 0;
        break;
      case( 1 ):
        $fmStatus = t3lib_FlashMessage::INFO;
        $logStatus = 0;
        break;
      case( 2 ):
        $fmStatus = t3lib_FlashMessage::OK;
        $logStatus = 0;
        break;
      case( 3 ):
        $fmPrompt = $prompt . '<br />
                      ' . $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptDetailsToSyslog' );
        $fmStatus = t3lib_FlashMessage::WARNING;
        $logStatus = 0;
        break;
      case( 4 ):
        $fmPrompt = $prompt . '<br />
                      ' . $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptDetailsToSyslog' );
        $fmStatus = t3lib_FlashMessage::ERROR;
        $logStatus = 0;
        break;
      default:
        $logStatus = 0;
        break;
    }

    $this->pObj->log( $table, $uid, $action, $pid, $logStatus, $logPrompt );

    // RETURN : Don't prompt to the backend
    if ( $status < 0 )
    {
      return;
    }
    // RETURN : Don't prompt to the backend

    $flashMessage = t3lib_div::makeInstance( 't3lib_FlashMessage', $fmPrompt, $fmHeader, $fmStatus );
    t3lib_FlashMessageQueue::addMessage( $flashMessage );
  }

  /*   * *********************************************
   *
   * Route
   *
   * ******************************************** */

  /**
   * route( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @param    object        $reference  : reference to parent object
   * @return    void
   * @version   4.6.3
   * @since     4.5.7
   */
  private function route( &$fieldArray, &$reference )
  {
    // #54575, 131222, dwildt, 4+
    if ( is_array( $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'category' ] ) )
    {
      $this->routeCategory( $fieldArray, $reference );
    }

    if ( $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'gpxfile' ] )
    {
      // #52166, 130921, dwildt
      $this->routeGpx( $fieldArray, $reference );
    }

    // #54575, 131222, dwildt, 4+
    if ( is_array( $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'marker' ] ) )
    {
      $this->routeMarker( $fieldArray, $reference );
    }

    // #54575, 131222, dwildt, 4+
    if ( is_array( $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'path' ] ) )
    {
      $this->routePath( $fieldArray, $reference );
    }

    return;
  }

  /**
   * routeCategory( )
   *
   * @param	[type]		$$fieldArray: ...
   * @return	boolean		$requirementsMatched  : true if requierements matched, false if not.
   * @version   4.8.5
   * @since     4.8.5
   */
  private function routeCategory( $fieldArray )
  {
    $fieldMarker = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'category' ][ 'marker' ];
    $fieldPath = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'category' ][ 'path' ];

    $valueMarker = $this->setValue( $fieldArray, $fieldMarker );
    $valuePath = $this->setValue( $fieldArray, $fieldPath );

    switch ( true )
    {
      case( empty( $valueMarker ) AND empty( $valuePath ) ):
        $prompt = 'OK: Category without any relation.';
        $this->log( $prompt, -1 );
        break;
      case( empty( $valueMarker ) AND $valuePath == 1 ):
        $prompt = 'OK: Category with an 1:1-relation to a path. No relation to a marker (POI).';
        $this->log( $prompt, -1 );
        break;
      case( $valueMarker >= 1 AND empty( $valuePath ) ):
        $prompt = 'OK: Category with an 1:n-relation to marker (POI). No relation to a path.';
        $this->log( $prompt, -1 );
        break;
      default:
        $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptCategoryRelationError' );
        $prompt = str_replace( '%marker%', $valueMarker, $prompt );
        $prompt = str_replace( '%path%', $valuePath, $prompt );
        $this->log( $prompt, 4 );
        break;
    }

    unset( $valueMarker );
    unset( $valuePath );
  }

  /**
   * setValue( )
   *
   * @param	array		$fieldArray : Array of modified fields
   * @return	string		$label      : label of the return field
   * @version   4.8.5
   * @since     4.8.5
   */
  private function setValue( $fieldArray, $label )
  {
    $row = $this->setRow();
    $value = null;

    $value = $row[ $label ];
    if ( isset( $fieldArray[ $label ] ) )
    {
      $value = $fieldArray[ $label ];
    }

    return $value;
  }

  /**
   * routeGpx( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @param    object        $reference  : reference to parent object
   * @return    void
   * @version   4.6.3
   * @since     4.5.7
   */
  private function routeGpx( &$fieldArray, &$reference )
  {

    // RETURN : requirements aren't matched
    if ( !$this->routeGpxRequired( $fieldArray ) )
    {
      return;
    }
    // RETURN : requirements aren't matched
    // #52166, 130921, dwildt
    $arrResult = $this->routeGpxHandleData( $fieldArray, $reference );
    if ( $arrResult[ 'error' ] )
    {
      return;
    }

    return;
  }

  /**
   * routeGpxHandleData( )
   *
   * @param    array        $fieldArray : Array of modified fields
   * @return    void
   * @version   4.5.7
   * @since     4.5.7
   */
  private function routeGpxHandleData( &$fieldArray )
  {
    // Get field labels
    $fieldGpxfile = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'gpxfile' ];
    $fieldGeodata = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'geodata' ];

    // Update TCA array of the current table
    if ( !is_array( $GLOBALS[ 'TCA' ][ $this->processTable ][ 'columns' ] ) )
    {
      t3lib_div::loadTCA( $this->processTable );
    }
    // Update TCA array of the current table
    // Get field configuration
    $confGpxfile = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'columns' ][ $fieldGpxfile ][ 'config' ];
    // 130829, dwildt, 1-
    //$confGeodata = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'columns' ][ $fieldGeodata ][ 'config' ];
    // Get the absoulte path of the uploaded file
    $uploadfolder = $confGpxfile[ 'uploadfolder' ];
    $absPath = t3lib_div::getIndpEnv( 'TYPO3_DOCUMENT_ROOT' ) . '/' . $uploadfolder . '/' . $fieldArray[ $fieldGpxfile ];

    // RETURN : file is missing
    if ( !file_exists( $absPath ) )
    {
      $prompt = 'ERROR: file is missing: ' . $absPath;
      $this->log( $prompt, 4, 2, 1 );
      return;
    }
    // RETURN : file is missing

    $gpxXml = simplexml_load_file( $absPath );
    $arrTrackpoint = array();
    $arrTrackpoints = array();
    $strGeodata = null;

    foreach ( $gpxXml->trk->trkseg->trkpt as $trackPoint )
    {
      foreach ( $trackPoint->attributes() as $key => $value )
      {
        $arrTrackPoint[ $key ] = $value;
      }
      $arrTrackpoints[] = $arrTrackPoint[ 'lon' ] . ',' . $arrTrackPoint[ 'lat' ];
    }

    $strGeodata = implode( PHP_EOL, ( array ) $arrTrackpoints );

    unset( $arrTrackpoint );
    unset( $arrTrackpoints );

    if ( empty( $strGeodata ) )
    {
      $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGpxError' );
      $this->log( $prompt, 4, 2, 1 );
      $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGpxInfo' );
      $this->log( $prompt, 1, 2, 1 );
      return;
    }

    $fieldArray[ $fieldGeodata ] = $strGeodata;

    $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptGpxUpdate' );
    $this->log( $prompt, 2, 2, 1 );
  }

  /**
   * routeGpx( )
   *
   * @param    [type]        $$fieldArray: ...
   * @return    boolean        $requirementsMatched  : true if requierements matched, false if not.
   * @version   4.5.7
   * @since     4.5.7
   */
  private function routeGpxRequired( $fieldArray )
  {
    $requirementsMatched = true;

    $fieldGpxfile = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'gpxfile' ];
    $fieldGeodata = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'geodata' ];

    switch ( true )
    {
      case(!isset( $fieldArray[ $fieldGpxfile ] ) ):
        $prompt = 'OK: No GPX file is uploaded. Nothing to do.';
        $this->log( $prompt, -1 );
        $requirementsMatched = false;
        return $requirementsMatched;
      //break;
      case( empty( $fieldArray[ $fieldGpxfile ] ) ):
        $prompt = 'OK: GPX file is removed. Nothing to do.';
        $this->log( $prompt, -1 );
        $requirementsMatched = false;
        return $requirementsMatched;
      //break;
      case( empty( $fieldGpxfile ) ):
      case( empty( $fieldGeodata ) ):
        $prompt = 'ERROR: $GLOBALS[TCA][' . $this->processTable . '][ctrl][tx_browser][route] is set, '
                . 'but the element [gpxfile] and/or [geodata] isn\'t configured! '
                . 'Please take care off a proper TCA configuration!'
        ;
        $this->log( $prompt, 4, 2, 1 );
        $requirementsMatched = false;
        return $requirementsMatched;
      //break;
    }

    unset( $fieldArray );
    unset( $fieldGpxfile );
    unset( $fieldGeodata );

    return $requirementsMatched;
  }

  /**
   * routeMarker( )
   *
   * @param	[type]		$$fieldArray: ...
   * @return	boolean		$requirementsMatched  : true if requierements matched, false if not.
   * @version   4.8.5
   * @since     4.8.5
   */
  private function routeMarker( $fieldArray )
  {
    $fieldCategory = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'marker' ][ 'category' ];
    $fieldPath = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'marker' ][ 'path' ];

    $valueCategory = $this->setValue( $fieldArray, $fieldCategory );
    $valuePath = $this->setValue( $fieldArray, $fieldPath );

    switch ( true )
    {
      case( $valueCategory >= 1 AND $valuePath == 1 ):
        $prompt = 'OK: Category with an 1:n-relation to marker (POI) and an 1:1-relation to a path.';
        $this->log( $prompt, -1 );
        break;
      default:
        $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptMarkerRelationError' );
        $prompt = str_replace( '%category%', $valueCategory, $prompt );
        $prompt = str_replace( '%path%', $valuePath, $prompt );
        $this->log( $prompt, 4 );
        break;
    }

    unset( $valueCategory );
    unset( $valuePath );
  }

  /**
   * routePath( )
   *
   * @param	[type]		$$fieldArray: ...
   * @return	boolean		$requirementsMatched  : true if requierements matched, false if not.
   * @version   4.8.5
   * @since     4.8.5
   */
  private function routePath( $fieldArray )
  {
    $fieldCategory = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'path' ][ 'category' ];
    $fieldMarker = $GLOBALS[ 'TCA' ][ $this->processTable ][ 'ctrl' ][ 'tx_browser' ][ 'route' ][ 'path' ][ 'marker' ];

    $valueCategory = ( int ) $this->setValue( $fieldArray, $fieldCategory );
    $valueMarker = ( int ) $this->setValue( $fieldArray, $fieldMarker );

    switch ( true )
    {
      case( $valueCategory == 1 AND $valueMarker >= 1 ):
        $prompt = 'OK: Path with an 1:1-relation to a category and an 1:n-relation to a marker (POI).';
        $this->log( $prompt, -1 );
        break;
      default:
        $prompt = $GLOBALS[ 'LANG' ]->sL( 'LLL:EXT:browser/lib/locallang.xml:promptPathRelationError' );
        $prompt = str_replace( '%category%', $valueCategory, $prompt );
        $prompt = str_replace( '%marker%', $valueMarker, $prompt );
        $this->log( $prompt, 4 );
        break;
    }

    unset( $valueCategory );
    unset( $valueMarker );
  }

  /**
   * setRow( ):  The method select the values of the given table and select and
   *                 returns the values as a marker array
   *
   * @return	array		$row :  Array with field-value pairs
   * @access private
   * @version  4.8.5
   * @since    4.8.5
   */
  private function setRow()
  {
    // RETURN null  : action is new record
    if ( ( ( int ) $this->processId ) !== $this->processId )
    {
      // f.e: uid = 'NEW52248e41babcf'
      return null;
    }
    // RETURN null  : action is new record
    // RETURN : row is set before
    if ( $this->row != null )
    {
      return $this->row;
    }
    // RETURN : row is set before

    // #i0216. 160105, dwildt, 1-/+11
    //$columns = array_keys( $GLOBALS[ 'TCA' ][ $this->processTable ][ 'columns' ] );
    foreach ( ( array ) $GLOBALS[ 'TCA' ][ $this->processTable ][ 'columns' ] AS $column => $properties )
    {
      switch( TRUE )
      {
        case( $properties[ 'config' ][ 'type' ] == 'user' ):
          // Do nothing;
          break;
        default:
          $columns[] = $column;
      }
    }

    $select_fields = implode( ', ', $columns );

    // RETURN : select fields are empty
    if ( empty( $select_fields ) )
    {
      return null;
    }
    // RETURN : select fields are empty
    // Set the query
    $from_table = $this->processTable;
    $where_clause = 'uid = ' . $this->processId;
    $groupBy = null;
    $orderBy = null;
    $limit = null;

    $query = $GLOBALS[ 'TYPO3_DB' ]->SELECTquery
            (
            $select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit
    );
    // Set the query
    // Execute the query
    $res = $GLOBALS[ 'TYPO3_DB' ]->exec_SELECTquery
            (
            $select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit
    );
    // Execute the query
    // RETURN : ERROR
    $error = $GLOBALS[ 'TYPO3_DB' ]->sql_error();
    if ( !empty( $error ) )
    {
      $prompt = 'ERROR: Unproper SQL query';
      $this->log( $prompt, 4, 2, 1 );
      $prompt = 'query: ' . $query;
      $this->log( $prompt, 0, 2, 1 );
      $prompt = 'prompt: ' . $error;
      $this->log( $prompt, 4, 2, 1 );

      return;
    }
    // RETURN : ERROR
    // Fetch first row only
    $this->row = $GLOBALS[ 'TYPO3_DB' ]->sql_fetch_assoc( $res );
    // Free the SQL result
    $GLOBALS[ 'TYPO3_DB' ]->sql_free_result( $res );

    return $this->row;
  }

}

if ( defined( 'TYPO3_MODE' ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/browser/lib/class.tx_browser_tcemainprocdm.php' ] )
{
  include_once($TYPO3_CONF_VARS[ TYPO3_MODE ][ 'XCLASS' ][ 'ext/browser/lib/class.tx_browser_tcemainprocdm.php' ]);
}
?>