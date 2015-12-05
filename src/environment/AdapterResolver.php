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
use coverallskit\exception\EnvironmentAdapterNotFoundException;

/**
 * Class AdapterResolver
 */
class AdapterResolver
{
    /**
     * @var \coverallskit\environment\EnvironmentAdapter[]
     */
    private $adapters;

    /**
     * @var \coverallskit\environment\General
     */
    private $generalAdapter;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $adapters = [
            new TravisCI($environment),
            new TravisPro($environment),
            new CircleCI($environment),
            new DroneIO($environment),
            new CodeShip($environment),
            new Jenkins($environment)
        ];
        $this->adapters = $adapters;
        $this->generalAdapter = new General($environment);
    }

    /**
     * @return EnvironmentAdapter
     */
    public function resolveByEnvironment()
    {
        $detectedAdapter = $this->detectFromSupportAdapters();

        if ($detectedAdapter === null) {
            return $this->generalAdapter;
        }

        return $detectedAdapter;
    }

    /**
     * @param string $name
     *
     * @return EnvironmentAdapter
     */
    public function resolveByName($name)
    {
        $detectedAdapter = $this->detectByName($name);

        if ($detectedAdapter === null) {
            $exception = EnvironmentAdapterNotFoundException::createByName($name);
            throw $exception;
        }

        return $detectedAdapter;
    }

    /**
     * @param string $name
     *
     * @return EnvironmentAdapter|null
     */
    private function detectByName($name)
    {
        $detectedAdapter = null;

        foreach ($this->adapters as $adapter) {
            if ($adapter->getName() === $name) {
                $detectedAdapter = $adapter;
                break;
            }
        }

        return $detectedAdapter;
    }

    /**
     * @return EnvironmentAdapter|null
     */
    private function detectFromSupportAdapters()
    {
        $detectedAdapter = null;

        foreach ($this->adapters as $adapter) {
            if ($adapter->isSupported()) {
                $detectedAdapter = $adapter;
                break;
            }
        }

        return $detectedAdapter;
    }
}
