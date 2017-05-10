<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application([
    'debug' => true
]);

require __DIR__ . '/../settings/providers.php';

require __DIR__ . '/../settings/controllers.php';

require __DIR__ . '/../settings/middlewares.php';

require __DIR__ . '/../settings/routing.php';

$app->run();
