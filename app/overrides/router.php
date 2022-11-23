<?php

namespace App\Overrides;

use Illuminate\Routing\Router as BaseRouter;

class Router extends BaseRouter
{
    // You can call it however you want. These are the params you need to pass the original resource() method.
    public function customResource($name, $controller, array $options = [])
    {
        $only = ['show', 'store', 'update', 'destroy', 'restore','getAll', 'setAffectation', 'getAffectation', 'attachAffectation', 'detachAffectation'];

        if (isset($options['except'])) {
            $only = array_diff($only, (array) $options['except']);
        }
        
        // What make a get route and then a normal resource route you'll be able to call optional methods on.
        $this->post($name.'/all', $controller.'@getAll')->name($name.'.all');
        $this->post($name.'/affecter', $controller.'@setAffectation')->name($name.'.setAffectation');
        $this->get($name.'/affecter/{item}', $controller.'@getAffectation')->name($name.'.getAffectation');
        $this->get($name.'/restore/{id}', $controller.'@restore')->name($name.'.restore');
        $this->post($name.'/attach-affectation', $controller.'@attachAffectation')->name($name.'.attachAffectation');
        $this->post($name.'/detach-affectation', $controller.'@detachAffectation')->name($name.'.detachAffectation');
        
        return $this->resource($name, $controller , array_merge([
            'only' => $only,
        ], $options));
    }  
    
    public function customResources(array $customResources, array $options = [])
    {
        foreach ($customResources as $name => $controller) {
            $this->customResource($name, $controller, $options);
        }
    }
}