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

        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

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

        function testGetId()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertTrue(is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);

            //Act
            $executed = $test_author->save();

            //Assert
            $this->assertTrue($executed, "This author is not saved.");
        }

        function testGetAll()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $first_name2 = "Nathan";
            $last_name2 = "Stewart";
            $test_author2 = new Author($first_name2, $last_name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $first_name2 = "Nathan";
            $last_name2 = "Stewart";
            $test_author2 = new Author($first_name2, $last_name2);
            $test_author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

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
