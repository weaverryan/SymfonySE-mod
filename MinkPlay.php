<?php

require __DIR__.'/vendor/autoload.php';

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;

$url = 'http://localhost:9000';

/**
 * Important object #1: Driver
 */

$driver = new GoutteDriver();

/**
 * Important object #2: Session
 */
$session = new Session($driver);
$session->start();

$session->visit($url);

/**
 * Important object #3: Page (DocumentElement)
 */

$page = $session->getPage();

/**
 * Important object #4: NodeElement
 */

$h1Node = $page->find('css', 'h1');
var_dump($h1Node);
