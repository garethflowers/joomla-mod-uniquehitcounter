<?php

/**
 * Helper class for Unique Hit Counter Module
 *
 * @version $Id: helper.php 1.0 March 2010$
 * @package UniqueHitCounter
 * @subpackage Modules
 * @Copyright (C) 2010 Gareth Flowers. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author Gareth Flowers (info@garethflowers.com)
 * @link http://garethflowers.com/joomlauniquehitcounter/
 */
class modUniqueHitCounterHelper
{

    /**
     * Creates the required data tables
     *
     * @return array Query Results
     * @access public
     * @static
     */
    public static function createTable()
    {
        // get a reference to the database
        $db = &JFactory::getDBO();

        // generate the create table query
        $query = 'CREATE TABLE IF NOT EXISTS `#__uniquehitcounter` (';
        $query .= '`ip` VARCHAR( 50 ) NOT NULL default \'\',';
        $query .= '`count` MEDIUMINT(9) NOT NULL default \'0\',';
        $query .= 'PRIMARY KEY  (`ip`)';
        $query .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT=\'Unique Hit Counter Module Data\';';

        // execute query
        @$db->setQuery( $query );

        // get results
        @$db->loadObjectList();
    }

    /**
     * Increments and returns the current hit count
     *
     * @access public
     * @static
     */
    public static function incrementHitCount()
    {
        // get a reference to the database
        $db = &JFactory::getDBO();

        if ( !empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            // generate query to insert new ip address if not already exists
            $query = 'INSERT INTO `#__uniquehitcounter` ( `ip`, `count` )';
            $query .= ' VALUES ( \'' . strtolower( trim( $_SERVER['REMOTE_ADDR'] ) ) . '\', 1 )';
            $query .= ' ON DUPLICATE KEY UPDATE `count` = `count` + 1;';

            // execute query
            @$db->setQuery( $query );

            // get results
            @$db->loadObjectList();
        }
    }

    /**
     * Get the current hit count
     *
     * @param array $params An object containing the module parameters
     * @return array Query Results
     * @access public
     * @static
     */
    public static function getHitCount( $ignorelist )
    {
        // get a reference to the database
        $db = &JFactory::getDBO();

        // create a query to get a list of $userCount randomly ordered users
        $query = 'SELECT COUNT( `ip` ) as hitcount';
        $query .= ' FROM `#__uniquehitcounter`';
        if ( is_array( $ignorelist ) && count( $ignorelist ) > 0 )
        {
            $query .= ' WHERE `ip` NOT LIKE \'%' . implode( '%\' AND `ip` NOT LIKE \'%', $ignorelist ) . '%\'';
        }
        $query .= ';';

        // execute query
        @$db->setQuery( $query );

        // get results
        $items = @$db->loadObjectList();

        return $items ? intval( $items[0]->hitcount ) : 0;
    }

}
