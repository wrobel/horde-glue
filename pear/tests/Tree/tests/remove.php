<?php
//
//  $Id: remove.php,v 1.3.2.1 2007/06/01 23:05:38 dufuz Exp $
//

require_once 'UnitTest.php';

class tests_remove extends UnitTest
{
/*
    function test_MemoryDBnested()
    {
        $tree = $this->getMemoryDBnested();        
        $ret=$tree->remove(5);
        $tree->setup();

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the move succeeded, by checking the new parentId
        //problem here is that memory returns another return value for a not existing element ... shit        
        $this->assertEquals(x, $tree->getElement(5));
    }
*/

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
        $ret = $tree->remove(5);

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the element doesnt exist anymore ... this is not 100% sure, since the 
        // returned error message is a string :-(
        $this->assertTrue(Tree::isError($tree->getElement(5)));
    }

    function test_DynamicMDBnested()
    {
        $tree =& $this->getDynamicMDBnested();
        $ret = $tree->remove(5);

        // be sure true is returned
        $this->assertTrue($ret);
        // and check if the element doesnt exist anymore ... this is not 100% sure, sicne the 
        // returned error message is a string :-(
        $this->assertTrue(Tree::isError($tree->getElement(5)));
    }
}

?>
