<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2013 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
* The class tx_browser_pi1_cObjData bundles methods for handle cObj->data
*
* @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
* @package    TYPO3
* @subpackage  browser
* @internal   #44858 
*
* @version  4.4.4
* @since    4.4.4
*/

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   69: class tx_browser_pi1_cObjData
 *
 */
class tx_browser_pi1_cObjData
{
    // [OBJECT] parent object
  private $pObj = null;
  
    // Backup of cObj->data
  private $bakCObjData = null;
  
    // Backup of $GLOBALS['TSFE']->cObj->data
  private $bakTsfeData = null;



  /**
 * Constructor. The method initiate the parent object
 *
 * @param	object		The parent object
 * @return	void
 */
  function __construct($pObj)
  {
    $this->pObj = $pObj;
  }



  /***********************************************
  *
  * Main
  *
  **********************************************/

/**
 * mainUpdate( ): Adds the elements of the given array to cObjData and
 *                adds the elements from TypoScript
 * @param    array    $keyValues  : key value pairs
 * @param    boolean  $drs        : Should key value pairs prompt to DRS?
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
  public function add( $keyValues, $drs = true )
  {
    $this->backup( );
    $this->addArray( $keyValues, $drs );
    $this->addTsValues( );
  }

/**
 * mainRemove( ): Removes the elements of the given array of cObjData and
 *               removes elements from TypoSCript
 * @param    array    $keyValues  : key value pairs
 * @param    boolean  $drs        : Should key value pairs prompt to DRS
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
//  public function mainRemove( $keyValues )
  public function reset( )
  {
    $this->pObj->cObj->data = $this->bakCObjData;
    $GLOBALS['TSFE']->cObj->data = $this->bakTsfeData;
//    $this->removeArray( $keyValues );
//    $this->removeTsValues( );
  }

/**
 * mainSet( ): Sets the elements of the given array as cObjData and
 *             adds the elements from TypoScript
 * @param    array    $keyValues  : key value pairs
 * @param    boolean  $drs        : Should key value pairs prompt to DRS?
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
  public function set( $keyValues, $drs = true )
  {
    $this->backup( );
    $this->setArray( $keyValues, $drs );
    $this->addTsValues( );
  }
  
  
  
  /***********************************************
  *
  * Add
  *
  **********************************************/

/**
 * addArray( ): Adds the elements of the given array to cObjData
 *
 * @param    array
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
  private function addArray( $keyValues, $drs )
  {
      // FOREACH  : element
    foreach( ( array ) $keyValues as $key => $value )
    {
        // CONTINUE : key is empty
      if( empty( $key ) )
      {
        continue;
      }
        // CONTINUE : key is empty

        // Adds element to cObjData
      $this->pObj->cObj->data[ $key ] = $value;
    }
      // FOREACH  : element
    
//    $GLOBALS['TSFE']->cObj->data['tx_browser_pi1'] = $this->pObj->cObj->data;
    $GLOBALS['TSFE']->cObj->data = $this->pObj->cObj->data;

      // DRS
    if( $drs )
    {
      if( $this->pObj->b_drs_cObjData )
      {
        $prompt = 'This fields are added to cObject: ' . implode( ', ', array_keys( $keyValues ) );
        t3lib_div :: devLog( '[INFO/COBJDATA] ' . $prompt , $this->pObj->extKey, 0 );
        $prompt = 'I.e: you can use the content in TypoScript with: field = ' . key( $keyValues );
        t3lib_div :: devLog( '[INFO/COBJDATA] ' . $prompt , $this->pObj->extKey, 0 );
      }
    }
      // DRS

  }

/**
 * addTsValues( ): Adds values of plugin.tx_browser_pi1.cObjData to cObjData
 *
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
  private function addTsValues( )
  {
      // FOREACH  : plugin.tx_browser_pi1.cObjData
    foreach( ( array ) array_keys( $this->pObj->conf['cObjData.'] ) as $tsValue )
    {
        // CONTINUE : current value is an array
      if( substr( $tsValue, -1, 1 ) == '.' )
      {
        continue;
      }
        // CONTINUE : current value is an array

        // Render the content
      $cObj_name  = $this->pObj->conf['cObjData.'][$tsValue];
      $cObj_conf  = $this->pObj->conf['cObjData.'][$tsValue . '.'];
      $content    = $this->pObj->cObj->cObjGetSingle($cObj_name, $cObj_conf);
        // Render the content

        // Adds element to cObjData
      $this->pObj->cObj->data[ 'tx_browser_pi1.cObjData.' . $tsValue ] = $content;
//      $GLOBALS['TSFE']->cObj->data['tx_browser_pi1'][ 'tx_browser_pi1.cObjData.' . $tsValue ] = $content;
      $GLOBALS['TSFE']->cObj->data[ 'tx_browser_pi1.cObjData.' . $tsValue ] = $content;

      if( $this->pObj->b_drs_cObjData )
      {
        if( empty ( $content ) )
        {
          $prompt = 'cObjData.' . $tsValue . ' is empty. Probably this is an error!';
          t3lib_div :: devLog( '[WARN/COBJDATA] ' . $prompt , $this->pObj->extKey, 3 );
        }
        else
        {
          $prompt = 'Added to cObject[' . $tsValue . ']: ' . $content;
          t3lib_div :: devLog( '[INFO/COBJDATA] ' . $prompt , $this->pObj->extKey, 0 );
          $prompt = 'You can use the content in TypoScript with: field = tx_browser_pi1.cObjData.' . $tsValue;
          t3lib_div :: devLog( '[INFO/COBJDATA] ' . $prompt , $this->pObj->extKey, 0 );
        }
      }
    }
      // FOREACH  : plugin.tx_browser_pi1.cObjData
    
  }
  
  
  
  /***********************************************
  *
  * Backup
  *
  **********************************************/

/**
 * backup( ): 
 *
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
  private function backup(  )
  {
    if( ! ( $this->bakCObjData === null ) )
    {
      return;
    }
    $this->bakCObjData = $this->pObj->cObj->data;
    $this->bakTsfeData = $GLOBALS['TSFE']->cObj->data;
  }
  
  
  
//  /***********************************************
//  *
//  * Remove
//  *
//  **********************************************/
//
///**
// * removeArray( ): Removes the given key value pairs from cObjData
// *
// * @param     array   $keyValue : array with key value pairs
// * @return    void
// * @version 4.4.4
// * @since   4.4.4
// */
//  private function removeArray( $keyValue )
//  {
//      // FOREACH  : element
//    foreach( array_keys( $keyValue ) as $key )
//    {
//        // CONTINUE : key is empty
//      if( empty( $key ) )
//      {
//        continue;
//      }
//        // CONTINUE : key is empty
//
//        // Remove value from cObjData
//      unset( $this->pObj->cObj->data[ $key ] );
//    }
//      // FOREACH  : element
//
//    unset( $GLOBALS['TSFE']->cObj->data['tx_browser_pi1'] );
//  }
//
///**
// * removeTsValues( ): Removes values of plugin.tx_browser_pi1.cObjData from cObjData
// *
// * @return    void
// * @version 4.4.4
// * @since   4.4.4
// */
//  private function removeTsValues( )
//  {
//      // FOREACH  : plugin.tx_browser_pi1.cObjData
//    foreach( array_keys( $this->pObj->conf['cObjData.'] ) as $tsValue )
//    {
//        // CONTINUE : current value is an array
//      if( substr( $tsValue, -1, 1 ) == '.' )
//      {
//        continue;
//      }
//        // CONTINUE : current value is an array
//
//        // Remove value from cObjData
//      unset( $this->pObj->cObj->data[ 'tx_browser_pi1.cObjData.' . $tsValue ] );
//      unset( $GLOBALS['TSFE']->cObj->data['tx_browser_pi1'][ 'tx_browser_pi1.cObjData.' . $tsValue ] );
//    }
//      // FOREACH  : plugin.tx_browser_pi1.cObjData
//  }
  
  
  
  /***********************************************
  *
  * Set
  *
  **********************************************/

/**
 * setArray( ): Set the elements of the given array to cObjData
 *
 * @param    array
 * @return    void
 * @version 4.4.4
 * @since   4.4.4
 */
  private function setArray( $keyValues, $drs )
  {
    unset( $this->pObj->cObj->data );
    $this->addArray( $keyValues, $drs );
  }

  
  
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/browser/pi1/class.tx_browser_pi1_cObjData.php']) {
  include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/browser/pi1/class.tx_browser_pi1_cObjData.php']);
}
?>