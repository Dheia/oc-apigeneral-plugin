<?php namespace SprintSoft\ApiGeneral;

use Event;
use System\Classes\PluginBase;

/**
 * ApiShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    const EVENT_ITEMRESOURCE_DATA = 'sprintsoft.apigeneral.resource.itemData';
    const API_ROUTES = '/sprintsoft/apigeneral/routes/';

    public $require = [
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'ApiGeneral',
            'description' => 'With this plugin we will call in API endpoint for diferent actions',
            'author'      => 'SprintSoft',
            'icon'        => 'icon-globe'
        ];
    }

    public function boot()
    {
    }
}
