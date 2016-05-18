<?php
require 'vendor/autoload.php';

$custos = \Larabros\Verbum\Custos::init('de_DE', './languages');

if (false === $custos) {
    echo 'not found';
    return;
}

vox('copy.test');
