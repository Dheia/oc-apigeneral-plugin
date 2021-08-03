<?php namespace SprintSoft\ApiGeneral\Controllers\Api;

use Backend\Classes\Controller;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;
use Lovata\Shopaholic\Classes\Store\ProductListStore;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use Event;

class Search extends Base
{
    public $implement = [    ];


    public function init()
    {

        // Event::subscribe(ProductModelHandler::class);

    }

    public function extendIndex()
    {
        $search = input('search');
        $this->collection->active()->search($search);

    }

    public function getModelClass(): string
    {
        return Product::class;
    }

    public function getSortColumn(): string
    {
        return ProductListStore::SORT_NEW;
    }

}
