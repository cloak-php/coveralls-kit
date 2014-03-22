<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\environment;

interface TravisCIInterface extends EnvironmentInterface
{

    const SERVICE_CI = 'travis-ci';
    const SERVICE_PRO = 'travis-pro';

    const ENV_JOB_ID = 'TRAVIS_JOB_ID';

}
