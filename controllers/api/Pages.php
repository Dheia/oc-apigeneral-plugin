<?php namespace SprintSoft\ApiGeneral\Controllers\Api;

use Backend\Classes\Controller;
use Cms\Classes\Theme;
use RainLab\Pages\Classes\Page;

class Pages extends Controller
{
    public $implement = [    ];

    public function __construct()
    {
        // parent::__construct();
    }

    public function index()
    {
        $theme = Theme::getEditTheme();
        $pages = Page::listInTheme($theme, true);
        $arPages = [];
        foreach ($pages as $page) {
            $arPages[] = [
                'title' => $page->title,
                'url' => $page->url,
                'content' => $page->getProcessedMarkup(),
                'seo_params' => [
                    'seo_title' => $page->meta_title,
                    'seo_description' => $page->meta_description,
                    'seo_keywords' => $page->seo_keywords,
                    'robot_index' => $page->robot_index,
                    'robot_follow' => $page->robot_follow,
                    'canonical_url' => $page->canonical_url,
                ]
            ];
        }
       return response()->json($arPages);

    }



    public function getPage($url)
    {
        $theme = Theme::getEditTheme();
        $page = Page::load($theme, $url . '_page');
        $arPage = [
            'title' => $page->title,
            'url' => $page->url,
            'content' => $page->getProcessedMarkup(),
            'seo_params' => [
                'seo_title' => $page->meta_title,
                'seo_description' => $page->meta_description,
                'seo_keywords' => $page->seo_keywords,
                'robot_index' => $page->robot_index,
                'robot_follow' => $page->robot_follow,
                'canonical_url' => $page->canonical_url,
            ]
        ];
        return response()->json($arPage);


    }

}
