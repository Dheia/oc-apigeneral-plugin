<?php namespace SprintSoft\ApiGeneral\Classes\Resource\Product;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Brand\ItemResource as ItemResourceBrand;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Category\ItemResource as ItemResourceCategory;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\Offer\IndexCollection as IndexCollectionOffer;
use PlanetaDelEste\ApiShopaholic\Plugin;
use System\Classes\PluginManager;
use Lovata\PropertiesShopaholic\Classes\Collection\PropertySetCollection;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\ProductItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Product
 */
class ItemResource extends BaseResource
{

    public function getData(): array
    {
        return [
            'preview_image'   => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'          => IndexCollectionImages::make(collect($this->images)),
            'category'        => $this->category ? ItemResourceCategory::make($this->category) : null,
            'property'        => $this->formatProperty(),
            'category_name'   => $this->category ? $this->category->name : null,
            'offers'          => $this->offer->count() ? IndexCollectionOffer::make($this->offer->collect()) : [],
            'thumbnail'       => $this->preview_image
                ? $this->preview_image->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'secondary_thumb' => $this->images
                ? collect($this->images)->first()->getThumb(300, 300, ['mode' => 'crop'])
                : null,
            'brand' => $this->brand ? ItemResourceBrand::make($this->brand) : null,
            'seo_params' => $this->formatSeoParam(),
            'accesories' => $this->formatAccessory(),
            'labels' => $this->formatLabel(),
        ];
    }

    public function getDataKeys(): array
    {
        return [
            'id',
            'name',
            'code',
            'slug',
            'category_id',
            'preview_text',
            'thumbnail',
            'secondary_thumb',
            'offers',
            'category_name',
            'labels',
        ];
    }

    protected function getEvent(): ?string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA.'.product';
    }


    protected function formatAccessory(){
        $arAccessory = [];
        if (PluginManager::instance()->exists('Lovata.AccessoriesShopaholic')) {
            foreach($this->accessory as $accessory) {
                $arAccessory[] = [
                    'name'          => $accessory->name,
                    'name'          => $accessory->name,
                    'preview_text'  => $accessory->preview_text,
                    'preview_image' => $accessory->preview_image ? $accessory->preview_image->getPath() : null,
                    'offers'        => $accessory->offer->count() ? IndexCollectionOffer::make($accessory->offer->collect()) : [],
                ];
            }
        }

        return $arAccessory;
    }

    protected function formatSeoParam(){
        $arSeoParam = [];
        if (PluginManager::instance()->exists('Lovata.MightySeo')) {
            $arSeoParam = $this->seo_param->toArray();
            if(empty($arSeoParam['seo_title'])) {
                $arSeoParam['seo_title'] = $this->name;
            }
            if(empty($arSeoParam['seo_description'])) {
                $arSeoParam['seo_description'] = strip_tags($this->description);
            }
        }

        return $arSeoParam;
    }

    protected function formatLabel(){
        $arLabels = [];
        if (PluginManager::instance()->exists('Lovata.LabelsShopaholic')) {
            foreach($this->label->values() as $label) {
                $arLabels[] = [
                    'name' => $label->name,
                    'slug' => $label->slug,
                    'code' => $label->code,
                    'description' => $label->description,
                    'image' => $label->image ? $label->image->getPath() : null,
                    'icon' => $label->icon ? $label->icon->getPath() : null,
                ];
            }
        }
        return $arLabels;
    }

    protected function formatProperty()
    {
        $Properties = [];
        if (PluginManager::instance()->exists('Lovata.PropertiesShopaholic')) {
            $obPropertyList = $this->property;
            foreach($obPropertyList as $obProperty) {
                if($obProperty->property_value->getValueString()) {
                    $Properties[] = [
                        "code" => $obProperty->code,
                        "name" => $obProperty->name,
                        "description" => $obProperty->description,
                        "value" => $obProperty->property_value->getValueString(),
                        "measure" => $obProperty->measure->name,
                    ];
                }
            }
        }

        return $Properties;
    }
}
