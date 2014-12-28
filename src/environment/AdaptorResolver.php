<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\environment;


use coverallskit\Environment;
use coverallskit\exception\EnvironmentAdaptorNotFoundException;


/**
 * Class AdaptorResolver
 * @package coverallskit\environment
 */
class AdaptorResolver
{

    /**
     * @var \coverallskit\environment\AdaptorInterface[]
     */
    private $adaptors;

    /**
     * @var \coverallskit\environment\General
     */
    private $generalAdaptor;


    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $adaptors = [
            new TravisCI($environment),
            new TravisPro($environment),
            new CircleCI($environment),
            new DroneIO($environment),
            new CodeShip($environment)
        ];
        $this->adaptors = $adaptors;
        $this->generalAdaptor = new General($environment);
    }

    /**
     * @return AdaptorInterface
     */
    public function resolveByEnvironment()
    {
        $detectedAdaptor = $this->detectFromSupportAdaptors();

        if ($detectedAdaptor === null) {
            return $this->generalAdaptor;
        }

        return $detectedAdaptor;
    }

    /**
     * @param string $name
     * @return AdaptorInterface
     */
    public function resolveByName($name)
    {
        $detectedAdaptor = $this->detectByName($name);

        if ($detectedAdaptor === null) {
            $exception = EnvironmentAdaptorNotFoundException::createByName($name);
            throw $exception;
        }

        return $detectedAdaptor;
    }

    /**
     * @param string $name
     * @return AdaptorInterface|null
     */
    private function detectByName($name)
    {
        $detectedAdaptor = null;

        foreach ($this->adaptors as $adaptor) {
            if ($adaptor->getName() === $name) {
                $detectedAdaptor = $adaptor;
                break;
            }
        }

        return $detectedAdaptor;
    }

    /**
     * @return AdaptorInterface|null
     */
    private function detectFromSupportAdaptors()
    {
        $detectedAdaptor = null;

        foreach ($this->adaptors as $adaptor) {
            if ($adaptor->isSupported()) {
                $detectedAdaptor = $adaptor;
                break;
            }
        }

        return $detectedAdaptor;
    }

}
