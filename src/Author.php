<?php
    class Author
    {
        private $first_name;
        private $last_name;
        private $id;

        function __construct($first_name, $last_name, $id = null)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->full_name = $first_name . " " . $last_name;
            $this->id = $id;
        }

        function getFirstName()
        {
            return $this->first_name;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = (string) $new_first_name;
        }

        function getLastName()
        {
            return $this->last_name;
        }

        function setLastName($new_last_name)
        {
            $this->last_name = (string) $new_last_name;
        }

        function getFullName()
        {
            return $this->full_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO authors (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();
            foreach ($returned_authors as $author) {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $id = $author['id'];
                $new_author = new Author($first_name, $last_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM authors;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $found_author = null;
            $returned_authors = $GLOBALS['DB']->prepare("SELECT * FROM authors WHERE id = :id;");
            $returned_authors->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_authors->execute();
            foreach ($returned_authors as $author) {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $id = $author['id'];
                if ($id = $search_id) {
                    $found_author = new Author($first_name, $last_name, $id);

                }
            }
            return $found_author;
        }

        function updateFirstName($new_first_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE authors SET first_name = '{$new_first_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setFirstName($new_first_name);
                return true;
            } else {
                return false;
            }
        }

        function updateLastName($new_last_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE authors SET last_name = '{$new_last_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setLastName($new_last_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function addBook($book)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM authors
                JOIN authors_books ON (authors_books.author_id = authors.id)
                JOIN books ON (books.id = authors_books.book_id)
                WHERE authors.id = {$this->getId()};");
            $books = array();
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }
    }
?>
