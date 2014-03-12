<?php

/**
 * This file is part of the Controller Extra Bundle
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @since 2013
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmoreram\ControllerExtraBundle\Annotation;

use Mmoreram\ControllerExtraBundle\Annotation\Abstracts\Annotation;

/**
 * Entity annotation driver
 *
 * @Annotation
 */
class Entity extends Annotation
{

    /**
     * @var string
     *
     * Namespace of entity in a short namespace mode.
     */
    public $class;

    /**
     * @var string
     *
     * Name of the parameter
     */
    public $name;

    /**
     * @var array
     *
     * Setters
     */
    public $setters = array();

    /**
     * @var string
     *
     * Manager to use when persisting
     */
    public $manager;

    /**
     * @var boolean
     *
     * Persist entity
     */
    public $persist;

    /**
     * @var string
     *
     * Factory class
     */
    public $factoryClass;

    /**
     * @var string
     *
     * Factory method
     */
    public $factoryMethod;

    /**
     * @var boolean
     *
     * Factory static
     */
    public $factoryStatic = false;

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
     * return name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * return setters
     *
     * @return array Setters
     */
    public function getSetters()
    {
        return $this->setters;
    }

    /**
     * return manager
     *
     * @return string Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * return persist
     *
     * @return boolean persist
     */
    public function getPersist()
    {
        return $this->persist;
    }

    /**
     * return factory class
     *
     * @return string factory class
     */
    public function getFactoryClass()
    {
        return $this->factoryClass;
    }

    /**
     * return factory method
     *
     * @return string factory method
     */
    public function getFactoryMethod()
    {
        return $this->factoryMethod;
    }

    /**
     * return if factory is static
     *
     * @return boolean factory is static
     */
    public function getFactoryStatic()
    {
        return $this->factoryStatic;
    }
}
