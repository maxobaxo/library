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


    return $app;
?>
