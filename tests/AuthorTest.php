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

        function testFind()
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
            $result = Author::find($test_author2->getId());

            //Assert
            $this->assertEquals($test_author2, $result);
        }

        function testUpdateFirstName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $new_first_name = "Nathan";

            //Act
            $test_author->updateFirstName($new_first_name);

            //Assert
            $this->assertEquals($new_first_name, $test_author->getFirstName());
        }

        function testUpdateLastName()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $test_author = new Author($first_name, $last_name);
            $test_author->save();

            $new_last_name = "Stewart";

            //Act
            $test_author->updateLastName($new_last_name);

            //Assert
            $this->assertEquals($new_last_name, $test_author->getLastName());
        }

        function testDelete()
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
            $test_author->delete();

            //Assert
            $this->assertEquals([$test_author2], Author::getAll());
        }

        function testAddBook()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $id = null;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();
            // var_dump($test_author);
            $title = "Sandman Slim";
            $id= null;
            $test_book = new Book($title, $id);
            $test_book->save();
            // var_dump($test_book);
            //Act
            $test_author->addBook($test_book);

            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book]);

        }

        function testGetBooks()
        {
            //Arrange
            $first_name = "Max";
            $last_name = "Scher";
            $id = null;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $title = "Sandman Slim";
            $id= null;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Enders Game";
            $id2 = null;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }
    }
?>
