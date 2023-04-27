<?php

/**
 * Default Output for Unique Hit Counter Module
 *
 * @version $Id: default.php 1.0 March 2010$
 * @package UniqueHitCounter
 * @subpackage Modules
 * @Copyright (C) 2010 Gareth Flowers. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author Gareth Flowers
 * @link https://garethflowers.dev/joomla-mod-uniquehitcounter/
 */
// no direct access
defined( '_JEXEC' ) or exit( 'Restricted access' );

if ( !isset( $mod_uniquehitcounter_hitcount ) )
{
    $mod_uniquehitcounter_hitcount = '';
}

echo $mod_uniquehitcounter_hitcount;
