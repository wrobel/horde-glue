<?php
//
//  $Id: getElement.php,v 1.3 2004/12/21 17:06:02 dufuz Exp $
//

require_once 'UnitTest.php';

class tests_getElement extends UnitTest
{
    /**
    *   There was a bug when we mapped column names, especially when we mapped 
    *   a column to the same name as the column. We check this here too.
    *
    *
    */
    function test_MemoryDBnested()
    {
        $tree = $this->getMemoryDBnested();        
        $tree->update(3, array('comment' => 'PEAR rulez'));
        $tree->setup();
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);

        $tree->setOption('columnNameMaps', array('comment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);
    
        $tree->setOption('columnNameMaps', array('myComment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['myComment']);
    }

    function test_MemoryMDBnested()
    {
        $tree = $this->getMemoryMDBnested();        
        $tree->update(3, array('comment' => 'PEAR rulez'));
        $tree->setup();
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);

        $tree->setOption('columnNameMaps', array('comment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);
    
        $tree->setOption('columnNameMaps', array('myComment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['myComment']);
    }

    // do this for XML
            
    // do this for Filesystem

    // do this for DBsimple
    
    // do this for DynamicDBnested
    function test_DynamicDBnested()
    {
        $tree =& $this->getDynamicDBnested();
        $tree->update(3, array('comment' => 'PEAR rulez'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);

        $tree->setOption('columnNameMaps', array('comment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);
    
        $tree->setOption('columnNameMaps', array('myComment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['myComment']);
    }

    function test_DynamicMDBnested()
    {
        $tree =& $this->getDynamicMDBnested();
        $tree->update(3, array('comment' => 'PEAR rulez'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);

        $tree->setOption('columnNameMaps', array('comment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['comment']);
    
        $tree->setOption('columnNameMaps', array('myComment' => 'comment'));
        $actual = $tree->getElement(3);
        $this->assertEquals('PEAR rulez', $actual['myComment']);
    }

    /**
    * Empty the tree and add an element, retreive it and check if it is the one we added.
    *
    *
    */
    function test_DynamicDBnestedEmptyTree()
    {
        $tree = Tree::setup('Dynamic_DBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $tree->remove($tree->getRootId());
        
        $tree = Tree::setup('Memory_DBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $tree->setup();
        $id = $tree->add(array('name' => 'Start'));
        $tree->setup();
        $el = $tree->getElement($id);
        $this->assertEquals('Start', $el['name']);
        $tree->remove($tree->getRootId());
        
        $tree = Tree::setup('Dynamic_DBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $id = $tree->add(array('name' => 'StartDyn'));
        $el = $tree->getElement($id);
        $this->assertEquals('StartDyn', $el['name']);
    }    

    function test_DynamicMDBnestedEmptyTree()
    {
        $tree = Tree::setup('Dynamic_MDBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $tree->remove($tree->getRootId());
        
        $tree = Tree::setup('Memory_MDBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $tree->setup();
        $id = $tree->add(array('name' => 'Start'));
        $tree->setup();
        $el = $tree->getElement($id);
        $this->assertEquals('Start', $el['name']);
        $tree->remove($tree->getRootId());
        
        $tree = Tree::setup('Dynamic_MDBnested', DB_DSN, array('table' => TABLE_TREENESTED));
        $id = $tree->add(array('name' => 'StartDyn'));
        $el = $tree->getElement($id);
        $this->assertEquals('StartDyn', $el['name']);
    } 
        
}

?>
