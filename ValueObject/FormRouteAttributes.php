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

namespace Mmoreram\ControllerExtraBundle\ValueObject;

/**
 * Class FormRouteAttributes
 */
class FormRouteAttributes
{
    /**
     * @var string
     *
     * route name
     */
    protected $name;

    /**
     * @var array
     *
     * route parameters
     */
    protected $parameters;

    /**
     * @var string
     *
     * route method
     */
    protected $method;

    /**
     * Get route name
     *
     * @return string Route name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set route name
     *
     * @param string $name Route name
     *
     * @return FormRouteAttributes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get route parameters
     *
     * @return array Route parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set route parameters
     *
     * @param array $parameters Route parameters
     *
     * @return FormRouteAttributes
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get HTTP method
     *
     * @return string HTTP method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set HTTP method
     *
     * @param string $method HTTP method
     *
     * @return FormRouteAttributes
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }
}
