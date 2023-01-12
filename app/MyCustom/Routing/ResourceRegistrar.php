<?php

namespace App\MyCustom\Routing;

use Illuminate\Routing\ResourceRegistrar as OriginalRegistrar;
use Illuminate\Support\Str;

class ResourceRegistrar extends OriginalRegistrar
{
    // add data to the array
    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'history'];


    /**
     * Add the data method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceHistory($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/history';
        $model = Str::singular($name);

        $action = $this->getResourceAction($name, $controller, 'history', $options);

        return $this->router->get($uri, $action);
    }
}