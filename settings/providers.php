<?php

use Symfony\Component\Yaml\Yaml;

use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\AssetServiceProvider;

const ROOT_DIR = __DIR__ . '/../';


$app->register(new VarDumperServiceProvider());

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => ROOT_DIR . 'var/logs/dev.log'
]);

$app->register(new ServiceControllerServiceProvider());

$app->register(new SessionServiceProvider());

$app->register(new ValidatorServiceProvider());

$app->register(new FormServiceProvider());

$app->register(new CsrfServiceProvider());

$app->register(new LocaleServiceProvider());

$app->register(new TranslationServiceProvider());

$app->register(new HttpFragmentServiceProvider());

$app->register(new TwigServiceProvider(), [
    'twig.path' => ROOT_DIR . 'src/App/Views',
    'twig.options' => [
        'cache' => ROOT_DIR . 'var/cache/twig',
        'debug' => true,
        'auto_reload' => true
    ]
]);

$app->register(new AssetServiceProvider(), [
    'assets.version' => 'v1'
]);

/**$app->register(new WebProfilerServiceProvider(), [
    'profiler.cache_dir' => ROOT_DIR . 'var/cache/profiler'
]);*/
