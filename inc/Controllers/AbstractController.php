<?php

namespace BC\Controllers;

use Timber\Timber;

abstract class AbstractController implements ControllerInterface
{

    protected $context;

    public function __construct()
    {
        $this->context = Timber::get_context();
    }

    protected function init()
    {
        // TODO: Implement init() method.
    }

    public function getContext(): array {
        $this->init();
        return $this->context;
    }
}
