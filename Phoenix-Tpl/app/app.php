<?php
require_once __DIR__.'/../vendor/autoload.php';

// -------------------------------------------------- SETUP
$app = new Silex\Application();

// session
$app->register(new Silex\Provider\SessionServiceProvider());

// url
$app['url'] = 'http://w4rh4wk.dyndns.org/ptpl/';

// -------------------------------------------------- DEBUG
// $app['debug'] = true;
// error_reporting(E_ALL);
// ini_set('display_errors', True);

// -------------------------------------------------- TWIG
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => array(
            __DIR__.'/../tpl',
            __DIR__.'/../data'
        )
    )
);

// -------------------------------------------------- USER
require_once __DIR__.'/User.php';
$app['user'] = new User($app);
$app->mount('/user', User::controller($app));

// -------------------------------------------------- FILEMANAGER
if ($app['user']->is_loggedin()) {
    require_once __DIR__.'/FileManager.php';
    $app->mount('/data', FileManager::controller($app));
}

// -------------------------------------------------- ROUTES
require_once __DIR__.'/Page.php';
$app->mount('/pages', Page::controller($app));

require_once __DIR__.'/File.php';
$app->mount('/files', File::controller($app));

require_once __DIR__.'/Blog.php';
$app->mount('/blog', Blog::controller($app));

require_once __DIR__.'/Gallery.php';
$app->mount('/gallery', Gallery::controller($app));

// -------------------------------------------------- DEFAULT ROUTE
$app->match('/', function() use ($app) {
    return $app->redirect('blog');
});
