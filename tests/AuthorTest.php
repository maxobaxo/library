<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Book.php';
    require_once 'src/Author.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        function testGetFirstName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);

            //Act
            $result = $test_author->getFirstName();

            //Assert
            $this->assertEquals($first_name, $result);
        }

        function testSetFirstName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);

            $new_first_name = "Nathan";

            //Act
            $test_author->setFirstName($new_first_name);
            $result = $test_author->getFirstName();

            //Assert
            $this->assertEquals($new_first_name, $result);
        }

        function testGetLastName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);

            //Act
            $result = $test_author->getLastName();

            //Assert
            $this->assertEquals($last_name, $result);
        }

        function testSetLastName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);

            $new_last_name = "Stewart";

            //Act
            $test_author->setLastName($new_last_name);
            $result = $test_author->getLastName();

            //Assert
            $this->assertEquals($new_last_name, $result);
        }

        function testGetFullName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $full_name = $test_author->full_name;
            //Act
            $result = $test_author->getFullName();

            //Assert
            $this->assertEquals($full_name, $result);
        }

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
