<?php
//
//  $Id: UnitTest.php,v 1.3 2004/12/21 17:06:02 dufuz Exp $
//

require_once 'DB.php';
require_once 'PHPUnit.php';

class UnitTest extends PhpUnit_TestCase
{
    function setUp()
    {
        // common setup, setup the table structure and data in the db
        // (this actually also does the tearDown, since we have the DROP TABLE queries in the setup too
        require 'sql.php'; 
        $db = DB::connect(DB_DSN);
        foreach ($dbStructure[$db->phptype]['setup'] as $aQuery) {
            if (DB::isError($ret = $db->query($aQuery))) {
                die($ret->getUserInfo());
            }
        }
        
        $this->setLooselyTyped(true);
    }

    function tearDown()
    {
/*        global $dbStructure;

        $querytool = new Common();
        foreach ($dbStructure[$querytool->db->phptype]['tearDown'] as $aQuery) {
//print "$aQuery<br><br>";        
            if (DB::isError($ret=$querytool->db->query($aQuery))) {
                die($ret->getUserInfo());
            }
        }
*/        
    }
    
    function &getMemoryDBnested()
    {
        $tree = Tree::setup('Memory_DBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $tree->setup();
        return $tree;
    }
    
    function &getDynamicDBnested()
    {
        $tree = Tree::setup('Dynamic_DBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        return $tree;
    }
 
    function &getMemoryMDBnested()
    {
        $tree = Tree::setup('Memory_MDBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $tree->setup();
        return $tree;
    }
    
    function &getDynamicMDBnested()
    {
        $tree = Tree::setup('Dynamic_MDBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        return $tree;
    } 
    
}

?>
