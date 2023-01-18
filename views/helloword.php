<?php

require_once __DIR__.'/bootstrap.php';

 $parameters = [
 'my_var' => 'Hello world !!!'
 ];
echo $twig->render('helloworld.html.twig', $parameters);
