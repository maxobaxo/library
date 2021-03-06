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

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
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

        function testAddAuthor()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();


            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            // Act
            $test_book->addAuthor($test_author);

            // Assert
            $this->assertEquals([$test_author], $test_book->getAuthors());
        }

        function testRemoveAuthor()
        {
            // Arrange
            $first_name = 'Ricky';
            $last_name = 'Ricardo';
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $first_name2 = 'James';
            $last_name2 = 'Dean';
            $test_author2 = new Author($first_name2, $last_name2);
            $test_author2->save();

            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();
            $test_book->addAuthor($test_author);

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();
            $test_book2->addAuthor($test_author);
            $test_book2->addAuthor($test_author2);

            $title3 = 'Eat Pray Love';
            $test_book3 = new Book($title3);
            $test_book3->save();
            $test_book3->addAuthor($test_author2);

            // Act
            $test_book2->removeAuthor($test_author2->getId());
            $result = $test_book2->getAuthors();

            // Assert
            $this->assertEquals([$test_author], $result);
        }

        function testGetAuthors()
        {
            // Arrange
            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();

            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $first_name2 = "Nathan";
            $last_name2 = "Stewart";
            $test_author2 = new Author($first_name2, $last_name2);
            $test_author2->save();

            // Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //Assert
            $this->assertEquals([$test_author, $test_author2], $test_book->getAuthors());
        }

        function testSearchTitle()
        {
            // Arrange
            $title_input = 'input';

            $title = 'Inputs 101';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'GitHub Forking';
            $test_book2 = new Book($title2);
            $test_book2->save();

            // Act
            $result = Book::searchTitle($title_input);

            // Assert
            $this->assertEquals([$test_book], $result);
        }

        function testSearchAuthor()
        {
            // Arrange
            $author_input = 'Ric';

            $first_name = 'Ricky';
            $last_name = 'Ricardo';
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $first_name2 = 'James';
            $last_name2 = 'Dean';
            $test_author2 = new Author($first_name2, $last_name2);
            $test_author2->save();

            $title = 'Enders Game';
            $test_book = new Book($title);
            $test_book->save();
            $test_book->addAuthor($test_author);

            $title2 = 'Ready Player Three';
            $test_book2 = new Book($title2);
            $test_book2->save();
            $test_book2->addAuthor($test_author2);

            $title3 = 'Eat Pray Love';
            $test_book3 = new Book($title3);
            $test_book3->save();
            $test_book3->addAuthor($test_author2);

            // Act
            $result = Book::searchAuthor($author_input);

            // Assert
            $this->assertEquals([$test_book], $result);
        }
    }

?>
