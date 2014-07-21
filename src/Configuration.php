<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit;

use coverallskit\entity\service\ServiceInterface;
use coverallskit\exception\BadAttributeException;

/**
 * Class Configuration
 * @package coverallskit
 */
class Configuration
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \coverallskit\entity\service\ServiceInterface
     */
    private $service;

    /**
     * @var string
     */
    private $repositoryDirectory;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->populate($values);
    }

    /**
     * @param ServiceInterface $service
     */
    private function setService(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return \coverallskit\entity\service\ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getRepositoryDirectory()
    {
        return $this->repositoryDirectory;
    }

    /**
     * @param array $values
     */
    private function populate(array $values)
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key) === false) {
                throw new BadAttributeException($key);
            }

            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                $this->$key = $value;
            }
        }
    }

}
