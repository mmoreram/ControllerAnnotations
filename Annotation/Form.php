<?php

/*
 * This file is part of the ControllerExtraBundle for Symfony2.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace Mmoreram\ControllerExtraBundle\Annotation;

use Mmoreram\ControllerExtraBundle\Annotation\Abstracts\Annotation;

/**
 * Form annotation driver
 *
 * @Annotation
 */
class Form extends Annotation
{
    /**
     * @var string
     *
     * Name of the parameter
     */
    public $name;

    /**
     * @var string
     *
     * Name of form. This value can refer to a namespace or a service alias
     */
    public $class;

    /**
     * @var entity
     *
     * Entity from Request ParameterBag to use where building form
     */
    public $entity;

    /**
     * @var boolean
     *
     * Handle request
     */
    public $handleRequest = false;

    /**
     * @var validate
     *
     * Validates submited form if Request is handled.
     * Name of field to set result.
     */
    public $validate = false;

    /**
     * @var string
     * Name of route.
     */
    public $routeName;

    /**
     * @var array
     *
     * Route parameters.
     */
    public $routeParameters = array();

    /**
     * @var string
     *
     * HTTP method
     */
    public $method = 'POST';

    /**
     * return name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * return class
     *
     * @return string Class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * return entity
     *
     * @return string Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * return handle request
     *
     * @return string Handle Request
     */
    public function getHandleRequest()
    {
        return $this->handleRequest;
    }

    /**
     * return validate value
     *
     * @return string Validate param name
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * return route name
     *
     * @return string Route name
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * return route parameters
     *
     * @return array Route parameters
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    /**
     * return http method
     *
     * @return string HTTP method
     */
    public function getMethod()
    {
        return $this->method;
    }
}
