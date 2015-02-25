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
    return renderPage($app, 'insurance');
    })->bind('fr_insurance');

$app->get('/{_locale}/le-materiel', function () use ($app) {
    return renderPage($app, 'material');
    })->bind('fr_material');

$app->get('/{_locale}/activites', function () use ($app) {
    return renderPage($app, 'activities');
    })->bind('fr_activities');

$app->get('/{_locale}/trajets-et-carte', function () use ($app) {
    return renderPage($app, 'trips');
    })->bind('fr_trips');

$app->get('/{_locale}/partenaires', function () use ($app) {
    return renderPage($app, 'partners');
    })->bind('fr_partners');

$app->get('/{_locale}/tarifs', function () use ($app) {
    return renderPage($app, 'price-list');
    })->bind('fr_price-list');

$app->get('/{_locale}/galerie', function () use ($app) {
    $gallery = array_diff(scandir(__DIR__.'/assets/gallery'), array('.', '..', '.DS_Store'));
    shuffle($gallery);
    $filter = new Twig_SimpleFilter('web_image', 'web_image', array('needs_context' => true));
    $app['twig']->addFilter($filter);
        return $app['twig']->render('pages/gallery.html.twig', array('templateName' => 'gallery', 'gallery' => $gallery));
    })->bind('fr_gallery');

$app->get('/{_locale}/google-location', function () use ($app) {
    return renderPage($app, 'google-location');
})->bind('fr_google-location');

$app->get('/{_locale}/contact', function () use ($app) {
    return renderPage($app, 'contact');
    })->bind('fr_contact');

$app->post('/{_locale}/contact', function () use ($app) {

        //$app->redirect()
})->bind('fr_contact-create');

$app->run();

function web_image($context, $path)
{
    $img = Image::open($path);

    $output = $img->resize(120)->crop(0,0, 120, 75);

    return $output;
}

function renderPage($app, $tempate)
{
    $gallery = array_diff(scandir(__DIR__.'/assets/gallery'), array('.', '..', '.DS_Store'));
    shuffle($gallery);
    $filter = new Twig_SimpleFilter('web_image', 'web_image', array('needs_context' => true));
    $app['twig']->addFilter($filter);

    return $app['twig']->render('pages/'.$app['translator']->getLocale().'/'.$tempate.'.html.twig', array('templateName' => $tempate, 'gallery' => array_slice($gallery, 0, 12)));
}