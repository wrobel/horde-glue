<?php
    // $Id: sql.php,v 1.1 2003/06/20 16:54:51 cain Exp $

    $dbStructure = array(
        'mysql' => array(
            'setup' => array(
                    "DROP TABLE IF EXISTS ".TABLE_TREENESTED.";"
                    ,"DROP TABLE IF EXISTS ".TABLE_TREENESTED."_seq;"
                    
                    ,"CREATE TABLE ".TABLE_TREENESTED." (
                        id int(11) NOT NULL default '0',
                        name varchar(255) NOT NULL default '',
                        l int(11) NOT NULL default '0',
                        r int(11) NOT NULL default '0',
                        parent int(11) NOT NULL default '0',
                        comment varchar(255) NOT NULL default '',
                        user_id int(11) NOT NULL default '0',
                        PRIMARY KEY (id)
                    ) TYPE=MyISAM;"
                    ,"INSERT INTO ".TABLE_TREENESTED." VALUES (1, 'Root', 1, 10, 0, '', 0);"
                    ,"INSERT INTO ".TABLE_TREENESTED." VALUES (2, 'child 1', 8, 9, 1, '', 0);"
                    ,"INSERT INTO ".TABLE_TREENESTED." VALUES (3, 'child 2', 2, 7, 1, '', 0);"
                    ,"INSERT INTO ".TABLE_TREENESTED." VALUES (4, 'child 2_1', 5, 6, 3, '', 0);"
                    ,"INSERT INTO ".TABLE_TREENESTED." VALUES (5, 'child 2_2', 3, 4, 3, '', 0);"
                ),

            'tearDown'  =>  array(
                    "DROP TABLE IF EXISTS ".TABLE_TREENESTED.";"
                    ,"DROP TABLE IF EXISTS ".TABLE_TREENESTED."_seq;"
            )
        ),

        'pgsql' =>  array(
            'setup' =>  array(),
            'tearDown'=>array()
        )        
    );
        
    

?>
