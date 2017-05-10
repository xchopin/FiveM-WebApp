<?php

$authenticated = function() use($app)
{
    if (!isset($_SESSION['email']))
        return $app->redirect($app['url_generator']->generate("home"));
};


