<?php

/**
 * This file is part of the Controller Extra Bundle
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 */

namespace Mmoreram\ControllerExtraBundle\Tests\FakeBundle\Factory;

use Mmoreram\ControllerExtraBundle\Tests\FakeBundle\Entity\Fake;

/**
 * Class FakeFactory
 */
class FakeFactory
{
    /**
     * Returns a new Fake instance
     *
     * @return Fake Fake entity
     */
    public function create()
    {
        return FakeFactory::createStatic();
    }

    /**
     * Returns a new Fake instance
     *
     * @return Fake Fake entity
     */
    public static function createStatic()
    {
        return new Fake();
    }

    /**
     * Returns a new Fake instance
     *
     * @return Fake Fake entity
     */
    public function generate()
    {
        return FakeFactory::createStatic();
    }

    /**
     * Returns a new Fake instance
     *
     * @return Fake Fake entity
     */
    public static function generateStatic()
    {
        return FakeFactory::createStatic();
    }
}