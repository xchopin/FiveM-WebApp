<?php

$app->GET('/', 'app.controller:home')->bind('home');

// --- AUTHENTICATION ---
$app->GET('/authentication', 'auth.controller:signin')->bind('authentication');
$app->GET('/signup', 'auth.controller:signup')->bind('signup');
$app->POST('/create-account', 'auth.controller:signup')->bind('create-account');
