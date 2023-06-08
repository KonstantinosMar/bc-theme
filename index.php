<?php
$context = \Timber\Timber::get_context();
$templates = array('index.twig');

Timber::render($templates, $context);