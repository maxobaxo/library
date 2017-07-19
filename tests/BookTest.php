<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Book.php';

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        function testGetTitle()
        {
            // Arrange
            $title = 'Ender\'s Game';
            $test_book = new Book($title);

            // Act
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($title, $result);
        }

        // function testSetTitle()
        // {
        //
        // }
        //
        // function testGetId()
        // {
        //
        // }
        //
        // function testSave()
        // {
        //
        // }
        //
        // function testGetAll()
        // {
        //
        // }
        //
        // function testDeleteAll()
        // {
        //
        // }
        //
        // function testFind()
        // {
        //
        // }
        //
        // function testUpdate()
        // {
        //
        // }
        //
        // function testDelete()
        // {
        //
        // }
    }

?>
