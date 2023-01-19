 <?php

 require_once str_replace('users','',__DIR__).'/vendor/autoload.php';
 
 // Specify our Twig templates location
 $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');

 // Instantiate our Twig
 $twig = new \Twig\Environment($loader);
