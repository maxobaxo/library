<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Book.php';

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
        }

        function testGetTitle()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);

            // Act
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($title, $result);
        }

        function testSetTitle()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);

            $new_title = 'Ready Player Three';

            // Act
            $test_book->setTitle($new_title);
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($new_title, $result);
        }

        function testGetId()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            // Act
            $result = $test_book->getId();

            // Assert
            $this->assertTrue(is_numeric($result));
        }

        function testSave()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);

            // Act
            $executed = $test_book->save();

            // Assert
            $this->assertTrue($executed, "This book has not been saved to the library.");
        }

        function testGetAll()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            $result = Book::getAll();

            // Assert
            $this->assertEquals([$test_book, $test_book2], $result);

        }

        function testDeleteAll()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            Book::deleteAll();
            $result = Book::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            $result = Book::find($test_book2->getId());

            // Assert
            $this->assertEquals($test_book2, $result);
        }

        function testUpdate()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $new_title = "Ready Player Three";

            // Act
            $test_book->update($new_title);

            // Assert
            $this->assertEquals($new_title, $test_book->getTitle());
        }

        function testDelete()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            $test_book->delete();

            // Assert
            $this->assertEquals([$test_book2], Book::getAll());
        }
    }

?>
