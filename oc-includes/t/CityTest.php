<?php

    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */

    define('DB_HOST', 'localhost') ;
    define('DB_USER', 'root') ;
    define('DB_PASSWORD', '') ;
    define('DB_NAME', 'osclass') ;
    define('DB_TABLE_PREFIX', 'oc_') ;

    require_once '../osclass/classes/data/DBConnectionClass.php' ;
    require_once '../osclass/classes/data/DBCommandClass.php' ;
    require_once '../osclass/classes/data/DBRecordsetClass.php' ;
    require_once '../osclass/classes/data/DAO.php' ;

    require_once '../osclass/model/new_model/City.php' ;

    /**
     * Run: $> phpunit PreferenceTest.php
     */
    class PreferenceTest extends PHPUnit_Framework_TestCase
    {
        private $cityDAO ;
        
        public function __construct()
        {
            parent::__construct() ;
            $this->cityDAO = new City() ;
        }

        public function testFindByPrimaryKey()
        {
            $city = $this->cityDAO->find_by_primary_key('3') ;
            $this->assertEquals('Sabadell', $city['s_name'], $this->cityDAO->dao->last_query() ) ;
            
            $city = $this->cityDAO->find_by_primary_key('10000') ;
            $this->assertEquals(false, $city, $this->cityDAO->dao->last_query() ) ;
        }
        
    }
    
?>