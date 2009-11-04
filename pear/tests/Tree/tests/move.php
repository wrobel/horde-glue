<?php
//
//  $Id: move.php,v 1.2 2004/12/21 17:06:02 dufuz Exp $
//

require_once 'UnitTest.php';

class tests_move extends UnitTest
{
    // check if we get the right ID, for the given path
    function test_MemoryDBnested()
    {
        $tree = $this->getMemoryDBnested();        
        $ret = $tree->move(5, 1);
        $tree->setup();

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the move succeeded, by checking the new parentId
        $this->assertEquals(1,$tree->getParentId(5));
    }

    function test_MemoryMDBnested()
    {
        $tree = $this->getMemoryMDBnested();        
        $ret = $tree->move(5, 1);
        $tree->setup();

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the move succeeded, by checking the new parentId
        $this->assertEquals(1, $tree->getParentId(5));
    }

    function test_MemoryDBnestedNoAction()
    {
        $tree = $this->getMemoryDBnested();        
//        $id = $tree->getIdByPath('/Root/child 2/child 2_2');
        $parentId = $tree->getParentId(5);
        $ret = $tree->move(5, 5);
        $tree->setup();
        // be sure true is returned
        $this->assertTrue($ret);
        $this->assertEquals($parentId, $tree->getParentId(5));
    }

    function test_MemoryMDBnestedNoAction()
    {
        $tree = $this->getMemoryMDBnested();        
//        $id = $tree->getIdByPath('/Root/child 2/child 2_2');
        $parentId = $tree->getParentId(5);
        $ret = $tree->move(5, 5);
        $tree->setup();
        // be sure true is returned
        $this->assertTrue($ret);
        $this->assertEquals($parentId, $tree->getParentId(5));
    }

    // do this for XML
            
    // do this for Filesystem

    // do this for DBsimple
    
    // do this for DynamicDBnested
    function test_DynamicDBnested()
    {
        $tree =& $this->getDynamicDBnested();
        $ret = $tree->move(5, 1);

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the move succeeded, by checking the new parentId
        $this->assertEquals(1, $tree->getParentId(5));
    }

    function test_DynamicMDBnested()
    {
        $tree =& $this->getDynamicDBnested();
        $ret = $tree->move(5, 1);

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the move succeeded, by checking the new parentId
        $this->assertEquals(1, $tree->getParentId(5));
    }

    function test_DynamicDBnestedNoAction()
    {
        $tree =& $this->getDynamicDBnested();
//        $id = $tree->getIdByPath('/Root/child 2/child 2_2');
        $parentId = $tree->getParentId(5);
        $ret = $tree->move(5, 5);
        // be sure true is returned
        $this->assertTrue($ret);
        $this->assertEquals($parentId, $tree->getParentId(5));
    }

    function test_DynamicMDBnestedNoAction()
    {
        $tree =& $this->getDynamicMDBnested();
//        $id = $tree->getIdByPath('/Root/child 2/child 2_2');
        $parentId = $tree->getParentId(5);
        $ret = $tree->move(5, 5);
        // be sure true is returned
        $this->assertTrue($ret);
        $this->assertEquals($parentId, $tree->getParentId(5));
    }  
}

?>
