<?php

namespace BC\Controllers;

use Timber\Timber;

class Homepage extends AbstractController
{
    private $postId;

    public function __construct() {
        parent::__construct();
        $this->postId = get_the_ID();
    }

    protected function init(): void {
        $this->context['layout'] = [
            'homeWidgetArea' => Timber::get_widgets('custom-homepage-widget'),
            'teams' => [
                [
                    'title' => 'MEX',
                    'image' => get_template_directory_uri() . '/img/svg/teams/mexico.svg',
                    'count' => 2
                ],
                [
                    'title' => 'ENG',
                    'image' => get_template_directory_uri() . '/img/svg/teams/england.svg',
                    'count' => 2
                ],
                [
                    'title' => 'EUR',
                    'image' => get_template_directory_uri() . '/img/svg/teams/europe.svg',
                    'count' => 6
                ],
                [
                    'title' => 'GER',
                    'image' => get_template_directory_uri() . '/img/svg/teams/germany.svg',
                    'count' => 6
                ],
                [
                    'title' => 'FRA',
                    'image' => get_template_directory_uri() . '/img/svg/teams/france.svg',
                    'count' => 5
                ],
                [
                    'title' => 'ITA',
                    'image' => get_template_directory_uri() . '/img/svg/teams/italy.svg',
                    'count' => 5
                ],
                [
                    'title' => 'AUS',
                    'image' => get_template_directory_uri() . '/img/svg/teams/australia.svg',
                    'count' => 5
                ],
                [
                    'title' => 'AUS',
                    'image' => get_template_directory_uri() . '/img/svg/teams/australia.svg',
                    'count' => 5
                ],
                [
                    'title' => 'AUS',
                    'image' => get_template_directory_uri() . '/img/svg/teams/australia.svg',
                    'count' => 5
                ]
            ]
        ];

    }
}
