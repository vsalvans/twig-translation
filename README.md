# Translation Twig Extension
Twig Translation Extension using YAML files

    //TranslationTwigExtension is in include folder
    $twig->addExtension(new TranslationTwigExtension($lang, __DIR__.'/locale'));


First argument is $lang and the second is the translation yaml files folder

/locale/es.yaml is the translation file

For instance in es.yaml

    Hello: Hola
    <a href="#">English</a>: <a href="#">Spanish</a>
    Your name is @name: Your name is @name


In the twig template use trans function like this:

    <h1>{{ "Hello" | trans }}</h1>
    {{ "<a href=\"#\">English</a>" | trans | raw }} <!-- for translation of html content -->
    <p>{{ "Your name is @name" | trans({"@name" : "víctor"}) }}</p>	<!-- for translation with tokens -->
