<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();

$app['translator.domains'] = array(
    'messages' => array()
);

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
            $translator->addLoader('yaml', new YamlFileLoader());

            $translator->addResource('yaml', __DIR__.'/locales/en.yml', 'en');
            $translator->addResource('yaml', __DIR__.'/locales/de.yml', 'de');
            $translator->addResource('yaml', __DIR__.'/locales/fr.yml', 'fr');

            return $translator;
        }));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
        'locale_fallbacks' => array('fr'),
    ));

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