<?php

use UKMNorge\Design\UKMDesign;
use UKMNorge\Design\Sitemap\Section;
use UKMNorge\File\Excel;
use UKMNorge\TemplateEngine\Proxy\Twig;
use UKMNorge\TemplateEngine\Vanilla;
use UKMNorge\Twig\Graphite;

require_once('vendor/autoload.php');
require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

if( UKM_HOSTNAME == 'ukm.dev' ) {
    ini_set('display_errors',true);
}

/**
 * Init Vanilla
 */
Vanilla::init(
    __DIR__,
    __DIR__ . '/cache/'
);

$environment = [
    'needs_environment' => true,
    'is_safe' => ['html']
];
Twig::addFilter('count', [Graphite::class, 'count'], $environment);
Twig::addFilter('countByCol', [Graphite::class, 'countByCol'], $environment);
Twig::addFilter('header', [Graphite::class, 'header']);


// Set where we are
UKMDesign::setCurrentSection(
    new Section(
        'current',
        'https://org.ukm.no/',
        'UKM-konferansen: Data fra spørreundersøkelse'
    )
);

$YEAR = $_GET['YEAR'];
$TEMPLATEFILE = '20' . $YEAR . '/' .
    basename(ucfirst($_GET['FILE'])) .
    '.html.twig';
$DATAFILE = 'Datagrunnlag/' .
    $YEAR .
    '-' .
    basename(strtolower($_GET['FILE'])) .
    '.xlsx';

if (file_exists(__DIR__.'/Views/'.$TEMPLATEFILE) && file_exists(__DIR__.'/'.$DATAFILE)) {
    // Do the magic
    $excelDoc = Excel::readFile($DATAFILE);
    Vanilla::addViewData('data', new Graphite($excelDoc->getSheet(0)));

    echo Vanilla::render($TEMPLATEFILE);
    die();
}

Vanilla::addViewData(
    'message',
    'Systemet finner ikke rapporten du spør etter. Data- eller template-fil mangler.'
);
echo Vanilla::render('fatalError.html.twig');
