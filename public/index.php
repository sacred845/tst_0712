<?php

define ('PROJECT_DIR', __DIR__ . '/..');
define ('LAYOUT_DIR', PROJECT_DIR.'/layout');
define ('CONTROLLER_DIR', PROJECT_DIR.'/Controllers');

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../cfg/config.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$paths = array(__DIR__.'/../src/Entity');
$isDevMode = false;
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$entityManager = EntityManager::create($dbParams, $config);
\App\Core::getInstance()->setEntityManager($entityManager);

\App\Front::run();
