<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM books;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $found_book = null;
            $returned_books = $GLOBALS['DB']->prepare("SELECT * FROM books WHERE id = :id;");
            $returned_books->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_books->execute();
            foreach($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                if ($id = $search_id) {
                    $found_book = new Book($title, $id);
                }
            }
            return $found_book;
        }

        function update($new_title)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setTitle($new_title);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function addAuthor($author)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$author->getId()}, {$this->getId()});");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function removeAuthor($author_id)
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE book_id = {$this->getId()} AND author_id = {$author_id};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getAuthors()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                JOIN authors_books ON (authors_books.book_id = books.id)
                JOIN authors ON (authors.id = authors_books.author_id)
                WHERE books.id = {$this->getId()};");

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

        static function searchTitle($title_input)
        {
            $title_input = strtolower($title_input);
            $books = array();
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                if (strpos(strtolower($new_book->getTitle()), $title_input) !== false ) {
                    array_push($books, $new_book);
                }
            }
            return $books;
        }

        static function searchAuthor($author_input)
        {
            $author_input = strtolower($author_input);
            $books = array();
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            foreach($returned_authors as $author) {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $id = $author['id'];
                $new_author = new Author($first_name, $last_name, $id);

                if (strpos(strtolower($new_author->getFullName()), $author_input) !== false) {

                    $loop_books = $new_author->getBooks();
                    foreach($loop_books as $book) {
                        array_push($books, $book);
                    }
                }
            }
            return $books;
        }
    }
?>
