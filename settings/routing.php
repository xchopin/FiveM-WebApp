<?php

$app->get('/', 'app.controller:home')->bind('home');
$app->get('/authentication', 'auth.controller:authentication')->bind('authentication');


$app->get('/login', 'auth.controller:login')->bind('login');