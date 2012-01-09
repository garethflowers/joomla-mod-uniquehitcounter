<?php

/**
 * Unique Hit Counter Module
 *
 * @version $Id: mod_uniquehitcounter.php 1.0 March 2010$
 * @package UniqueHitCounter
 * @subpackage Modules
 * @copyright (C) 2010 Gareth Flowers. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author Gareth Flowers (info@garethflowers.com)
 * @link http://garethflowers.com/joomlauniquehitcounter/
 */
// no direct access
defined( '_JEXEC' ) or exit( 'Restricted access' );

// Include the syndicate functions only once
require_once dirname( __FILE__ ) . DS . 'helper.php';

if ( !isset( $params ) )
{
    exit();
}

$mod_uniquehitcounter_ignorelist = array( );
$mod_uniquehitcounter_delims = array( ',', ':', ';', "\n", "\r", "\n\r", "\r\n", '  ', '   ' );

$mod_uniquehitcounter_ignoreips = trim( htmlspecialchars( $params->get( 'ignoreips' ) ) );
$mod_uniquehitcounter_ignoreips = str_replace( $mod_uniquehitcounter_delims, ' ', $mod_uniquehitcounter_ignoreips );

if ( strlen( $mod_uniquehitcounter_ignoreips ) > 0 )
{
    $mod_uniquehitcounter_ignorelist = explode( ' ', $mod_uniquehitcounter_ignoreips );
}

modUniqueHitCounterHelper::createTable();

modUniqueHitCounterHelper::incrementHitCount();

// get hit count
$mod_uniquehitcounter_hitcount = modUniqueHitCounterHelper::getHitCount( $mod_uniquehitcounter_ignorelist );

// apply offset
$mod_uniquehitcounter_hitcount += intval( $params->get( 'startoffset' ) );

// format to fill length
$mod_uniquehitcounter_hitcount = str_pad( (string) $mod_uniquehitcounter_hitcount, intval( $params->get( 'filllength' ) ), '0', STR_PAD_LEFT );

// set display type
if ( intval( $params->get( 'displaytype' ) ) > 0 )
{
    for ( $i = 0; $i <= 9; $i++ )
    {
        $image = '<img src="' . JURI::base() . 'modules' . DS . 'mod_uniquehitcounter' . DS . 'images' . DS . 'odometer' . (string) $i . '.png" alt="' . (string) $i . '" style="display:inline;border:none;padding:0;margin:0" />';
        $mod_uniquehitcounter_hitcount = str_replace( (string) $i, $image, $mod_uniquehitcounter_hitcount );
    }
}

// apply before and after content
$mod_uniquehitcounter_hitcount = '<div style="text-align:center">' . (string) $params->get( 'beforecontent' ) . $mod_uniquehitcounter_hitcount;
$mod_uniquehitcounter_hitcount .= (string) $params->get( 'aftercontent' ) . '</div>';

require JModuleHelper::getLayoutPath( 'mod_uniquehitcounter' );
