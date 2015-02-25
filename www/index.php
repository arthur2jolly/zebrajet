<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Translation\Loader\YamlFileLoader;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Gregwar\Image\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = false;



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

$app->get('/{_locale}/404', function () use ($app) {
    return renderPage($app, '404');
})->bind('fr_404');

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
    return $app['twig']->render('pages/contact.html.twig', array('templateName' => 'contact', 'displayForm' => true));
    })->bind('fr_contact');

$app->get('/{_locale}/contact-merci', function () use ($app) {
    return $app['twig']->render('pages/contact.html.twig', array('templateName' => 'contact', 'displayForm' => false));
})->bind('fr_contact-merci');

$app->post('/{_locale}/contact', function (Request $request) use ($app) {
    $contact_name       = strip_tags($request->get('contact_name'));
    $contact_email      = strip_tags($request->get('contact_email'));
    $contact_phone      = strip_tags($request->get('contact_phone'));
    $contact_message    = strip_tags($request->get('contact_message'));
    $contact_ext        = strip_tags($request->get('contact_ext'));

    if($contact_name && $contact_email && $contact_message) {
        $subject = "Un message du site zebrajet";
        $message = "Nom : $contact_name\n";
        $message .= "Email : $contact_email\n";
        $message .= "Téléphone : $contact_ext $contact_phone\n";
        $message .= "Message : $contact_message\n";

        $headers = 'Content-type: text/plain; charset=utf-8'."\r\n";

        mail('zebrajet@voila.fr', $subject, $message, $headers);

        return $app->redirect('contact-merci');
    }

    return $app['twig']->render('pages/contact.html.twig', array('templateName' => 'contact',
        'contact_name' => $contact_name,
        'contact_email' => $contact_email,
        'contact_phone' => $contact_phone,
        'contact_message' => $contact_message,
        'contact_ext' => $contact_ext,
        'error' => true
    ));

})->bind('fr_contact-create');

if($app['debug']) {
    $app->error(function (\Exception $e, $code) use ($app) {

        return $app->redirect('404');

    });
}



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