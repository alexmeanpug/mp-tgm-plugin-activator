<?php
/**
 * Modules are a functional design pattern that let us define common frontend interactions. In other words, they are
 * a form of adapter that acts as an interface for defining page components. For example, a page-hero Gutenberg block
 * might display identically to an archive pages' above-the-fold hero component. These two would - therefore - share a
 * common module, simply changing which parameters are fed into the module to control it
**/
require_once __DIR__ . '/base.php';
require_once __DIR__ . '/location-navigator/location-navigator.php';
require_once __DIR__ . '/polygon-map/polygon-map.php';
