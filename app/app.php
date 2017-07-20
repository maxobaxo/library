<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Book.php';
    require_once __DIR__.'/../src/Author.php';

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get('/books', function() use ($app) {

        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post('/books', function() use ($app) {
        $title = $_POST['title'];
        $new_book = new Book($title);
        $new_book->save();

        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get('/burn_books', function() use ($app) {
        Book::deleteAll();

        return $app['twig']->render('books.html.twig', array('books.html.twig' => Book::getAll()));
    });

    $app->get('/books/{id}', function($id) use ($app) {
        $book = Book::find($id);

        return $app['twig']->render('book.html.twig', array('book' => $book, 'all_authors' => Author::getAll()));
    });

    $app->get('/books/{id}/edit', function($id) use ($app) {
        $book = Book::find($id);

        return $app['twig']->render('edit_book.html.twig', array('book' => $book));
    });

    $app->patch('/books/{id}', function($id) use ($app) {
        $title = $_POST['new_title'];
        $book = Book::find($id);
        $book->update($title);

        return $app['twig']->render('book.html.twig', array('book' => $book));
    });

    $app->delete('/books/{id}', function($id) use($app) {
        $book = Book::find($id);
        $book->delete();

        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get('/authors', function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->post('/authors', function() use ($app) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $new_author = new Author($first_name, $last_name);
        $new_author->save();

        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->post('/add_books', function() use ($app) {
        $book = Book::find($_POST['book_id']);
        $author = Author::find($_POST['author_id']);
        $author->addBook($book);

        return $app['twig']->render('author.html.twig', array('author' => $author, 'books' => $author->getBooks(), 'book' => $book, 'all_books' => Book::getAll()));
    });

    $app->post("/add_authors", function() use ($app) {
        $author = Author::find($_POST['author_id']);
        $book = Book::find($_POST['book_id']);
        $book->addAuthor($author);

        return $app['twig']->render('book.html.twig', array('book' => $book, 'books' => Book::getAll(), 'authors' => $book->getAuthors(), 'author' => $author, 'all_authors' => Author::getAll()));
    });

    $app->get('/authors/{id}', function($id) use ($app) {
        $author = Author::find($id);

        return $app['twig']->render('author.html.twig', array('author' => $author, 'all_books' => Book::getAll()));
    });

    $app->get('/authors/{id}/edit', function($id) use ($app) {
        $author = Author::find($id);

        return $app['twig']->render('edit_author.html.twig', array('author' => $author));
    });

    $app->get('/murder_authors', function() use ($app) {
        Author::deleteAll();

        return $app['twig']->render('authors.html.twig', array('authors.html.twig' => Author::getAll()));
    });

    $app->patch('/authors/{id}', function($id) use ($app) {
        $first_name = $_POST['new_first_name'];
        $last_name = $_POST['new_last_name'];
        $author = Author::find($id);
        $author->updateFirstName($first_name);
        $author->updateLastName($last_name);

        return $app['twig']->render('authors.html.twig', array('author' => $author, 'authors' => Author::getAll()));
    });

    $app->delete('/authors/{id}', function($id) use($app) {
        $author = Author::find($id);
        $author->delete();

        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->get('/search_results_title', function() use ($app) {
        $all_books = Book::getAll();
        $search = strtolower($_GET['title']);
        $returned_books = array();
        foreach($all_books as $book) {
            if (strpos(strtolower($book->getTitle()), $search) !== false ) {
                array_push ($returned_books, $book);
            }
        }
        return $app['twig']->render('search_results.html.twig', array('books' => $returned_books));
    });

    $app->get('/search_results_author', function() use ($app) {
        $all_authors = Author::getAll();
        $search = strtolower($_GET['author']);
        foreach($all_authors as $author) {
            if (strpos(strtolower($author->getFullName()), $search) !== false ) {
                $returned_books = $author->getBooks();
            }
        }
        return $app['twig']->render('search_results.html.twig', array('books' => $returned_books));
    });

    return $app;
?>
