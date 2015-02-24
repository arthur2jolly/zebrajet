<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Translation\Loader\YamlFileLoader;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Gregwar\Image\Image;

$app = new Silex\Application();
$app['debug'] = true;



/**
 * PROVIDERS
 */
$app->register(new TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/templates',
    ));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


$translator = new Silex\Translator($app, new Symfony\Component\Translation\MessageSelector());
$translator->addLoader('yaml', new YamlFileLoader());
$translator->addResource('yaml', __DIR__.'/locales/fr.yml', 'fr');
$translator->addResource('yaml', __DIR__.'/locales/en.yml', 'en');
$translator->addResource('yaml', __DIR__.'/locales/de.yml', 'de');
$translator->addResource('yaml', __DIR__.'/locales/fr.yml', 'fr');
$translator->addResource('yaml', __DIR__.'/locales/es.yml', 'es');
$translator->addResource('yaml', __DIR__.'/locales/it.yml', 'it');
$translator->addResource('yaml', __DIR__.'/locales/pt.yml', 'pt');
$translator->setFallbackLocales(array('fr', 'en'));
$translator->setLocale('fr');

$app['translator'] = $translator;


$app->get('/', function () use ($app) {
    return $app['twig']->render('pages/home.html.twig', array());
})->bind('homepage');

$app->get('/{_locale}', function () use ($app) {
    return $app['twig']->render('pages/home.html.twig', array());
})->bind('fr_homepage');

$app->get('/{_locale}/qui-sommes-nous', function () use ($app) {
        return renderPage($app, 'about-us');
    })->bind('fr_about-us');

$app->get('/{_locale}/assurance', function () use ($app) {
        return $app['twig']->render('pages/insurance.html.twig', array());
    })->bind('fr_insurance');

$app->get('/{_locale}/le-materiel', function () use ($app) {
        return $app['twig']->render('pages/material.html.twig', array());
    })->bind('fr_material');

$app->get('/{_locale}/activites', function () use ($app) {
        return $app['twig']->render('pages/activities.html.twig', array());
    })->bind('fr_activities');

$app->get('/{_locale}/trajets-et-carte', function () use ($app) {
        return $app['twig']->render('pages/trips.html.twig', array());
    })->bind('fr_trips');

$app->get('/{_locale}/partenaires', function () use ($app) {
        return $app['twig']->render('pages/partners.html.twig', array());
    })->bind('fr_partners');

$app->get('/{_locale}/tarifs', function () use ($app) {
        return $app['twig']->render('pages/price-list.html.twig', array());
    })->bind('fr_price-list');

$app->get('/{_locale}/galerie', function () use ($app) {
        return $app['twig']->render('pages/gallery.html.twig', array());
    })->bind('fr_gallery');

$app->get('/{_locale}/google-location', function () use ($app) {
        return $app['twig']->render('pages/google-location.html.twig', array());
})->bind('fr_google-location');

$app->get('/{_locale}/contact', function () use ($app) {
        return $app['twig']->render('pages/contact.html.twig', array());
    })->bind('fr_contact');

$app->post('/{_locale}/contact', function () use ($app) {

        //$app->redirect()
})->bind('fr_contact-create');

$app->run();

function web_image($context, $path)
{
    $img = Image::open($path)->setCacheDir('assets/cache');
    return $img->resize(120, 75)->crop(0,0, 120, 75)->html("", 'jpg', 100);
}

function renderPage($app, $tempate)
{
    $gallery = array_diff(scandir(__DIR__.'/assets/gallery'), array('.', '..'));
    shuffle($gallery);
    $filter = new Twig_SimpleFilter('web_image', 'web_image', array('needs_context' => true));
    $app['twig']->addFilter($filter);

    return $app['twig']->render('pages/'.$tempate.'.html.twig', array('gallery' => array_slice($gallery, 0, 12)));
}