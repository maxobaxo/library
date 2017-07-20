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

        return $app['twig']->render('book.html.twig', array('book' => $book));
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

    return $app;
?>
