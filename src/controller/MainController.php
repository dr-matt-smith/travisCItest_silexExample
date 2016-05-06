<?php

namespace Itb\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Itb\Model\Database;


class MainController
{
    // action for route:    /sqlite
    public function sqliteAction(Request $request, Application $app)
    {

        // default - error template
        $templateName = 'error';
        $argsArray = [
          	'message' => 'there was a problem with PDO'
        ];

        //open the database
//        $db = Database::getPDOConnection();

        //------------
        //------------
        //
        /*
        $db = new \PDO('sqlite:dogsDb_PDO.sqlite');

        //create the database
        $db->exec("DROP TABLE IF EXISTS dogs");
        $db->exec("CREATE TABLE dogs (id INTEGER PRIMARY KEY, breed TEXT, name TEXT, age INTEGER)");

        //insert some data...
        $db->exec("INSERT INTO dogs (breed, name, age) VALUES ('Labrador', 'Tank', 2);".
        "INSERT INTO dogs (breed, name, age) VALUES ('Husky', 'Glacier', 7); " .
        "INSERT INTO dogs (breed, name, age) VALUES ('Golden-Doodle', 'Ellie', 4);");
        */
        //------------
        //------------
        //
        $db = $app['session']->get('db');
        
        $pdo = $db['pdo'];
        var_dump($pdo);
        die();
        $connection = $pdo->getConnection();


        //now output the data to a simple html table...
        $dogs = [];
        $result = $connection->query('SELECT * FROM dogs');
        foreach($result as $row)
        {
            $dogs[] = $row;
        }

        $templateName = 'sqlite';

        $argsArray = [
            'dogs' => $dogs,
        ];

        // render (draw) template
        // ------------

        return $app['twig']->render($templateName . '.html.twig', $argsArray);

    }


    // action for route:    /
    public function indexAction(Request $request, Application $app)
    {

        // render (draw) template
        // ------------
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', []);
    }

    // action for route:    /list
    public function listAction(Request $request, Application $app)
    {

        // build args array
        // ------------
        $argsArray = array(
            'books' => null,
        );

        // render (draw) template
        // ------------
        $templateName = 'list';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


    // action for route:    /show/
    public function showMissingIdAction(Request $request, Application $app)
    {
        $argsArray = array(
            'message' => 'you must provide an id for the show page (e.g. /show/123)'
        );

        // render (draw) template
        // ------------
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    // action for route:    /show/{id}
    public function showAction(Request $request, Application $app, $id)
    {
        // try to get book for this ID
        $book = Book::getOneById($id);

        // build args array
        // ------------
        if (null != $book){
            // book found§
            $argsArray = array(
                'book' => $book
            );
            $templateName = 'show';
        } else {
            // book NOT found
            $argsArray = array(
                'message' => 'no book found with id = ' . $id
            );
            $templateName = 'error';
        }


        // render (draw) template
        // ------------
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


    /**
     * not found error page
     * @param \Silex\Application $app
     * @param             $message
     *
     * @return mixed
     */
    public function error404(Application $app, $message)
    {
        $argsArray = [
            'message' => $message,
        ];
        $templateName = '404';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}