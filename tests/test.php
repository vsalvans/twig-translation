<?php

require_once 'vendor/autoload.php';

Twig_Autoloader::register();

$lang = 'es';

$loader = new Twig_Loader_Filesystem(__DIR__);

$twig = new Twig_Environment($loader, array(
    'cache' => null,
));

$twig->addExtension(new TranslationTwigExtension($lang, __DIR__.'/locale'));

echo $twig->render('index.html');