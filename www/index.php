<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Translation\Loader\YamlFileLoader;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\TranslationServiceProvider;


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

$app->get('/{_locale}/qui-sommes-nous', function ($name) use ($app) {

    })->bind('fr_about-us');

$app->get('/{_locale}/assurance', function ($name) use ($app) {

    })->bind('fr_insurance');

$app->get('/{_locale}/le-materiel', function ($name) use ($app) {

    })->bind('fr_material');

$app->get('/{_locale}/activites', function ($name) use ($app) {

    })->bind('fr_activites');

$app->get('/{_locale}/trajets-et-carte', function ($name) use ($app) {

    })->bind('fr_trips');

$app->get('/{_locale}/partenaires', function ($name) use ($app) {

    })->bind('fr_partners');

$app->get('/{_locale}/tarifs', function ($name) use ($app) {

    })->bind('fr_price-list');

$app->get('/{_locale}/galerie', function ($name) use ($app) {

    })->bind('fr_gallery');

$app->get('/{_locale}/contact', function ($name) use ($app) {

    })->bind('fr_contact');

$app->run();