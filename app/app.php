<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__ . "/../src/hangman.php";

    $app = new Silex\Application();

    $app->register(new Silex\provider\TwigServiceProvider(),array('twig.path' => __DIR__ . "/../views"));

    $app["debug"] = true;

    session_start();
    // if(empty($_SESSION["correct_guesses"]) && empty($_SESSION["incorrect_guesses"])){
    //     $_SESSION["correct_guesses"] = array();
    //     $_SESSION["incorrect_guesses"] = array();
    //
    // }
    $app->get("/",function() use ($app){
        $word = strtoupper("hello");
        $blanks = "";
        $_SESSION["correct_guesses"] = array();
        $_SESSION["incorrect_guesses"] = array();
        for($i = 0; $i<strlen($word); $i++)
        {
            $blanks .= "_ ";
        }
        $hangman = new Hangman($word, 0 , $blanks);
        $_SESSION['hangman'] = $hangman;
        var_dump($blanks);
        var_dump($hangman->getBlanks());
        return $app['twig']->render('hangman.html.twig', array("hangman" => $_SESSION['hangman'], "correct_guesses"=> Hangman::getAllCorrectString(),  "incorrect_guesses"=>Hangman::getAllIncorrectString()));
    });

    $app->post("/guess", function() use ($app){

        $_SESSION['hangman']->guess(strtoupper($_POST['guess']));

        return $app['twig']->render('hangman.html.twig', array("hangman" => $_SESSION['hangman'], "blank" => $_SESSION['hangman']->getBlanks(), "correct_guesses"=> Hangman::getAllCorrectString(),  "incorrect_guesses"=>Hangman::getAllIncorrectString()));
    });



    return $app;

?>
