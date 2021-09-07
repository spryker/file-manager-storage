<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManagerStorage;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class FileManagerStorageConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const STORAGE_COMPOSITE_KEY = 'composite_key';

    /**
     * @api
     *
     * @return string
     */
    public function getStorageCompositeKey()
    {
        return static::STORAGE_COMPOSITE_KEY;
    }

    /**
     * @api
     *
     * @return string|null
     */
    public function getFileManagerSynchronizationPoolName(): ?string
    {
        return null;
    }

    /**
     * @api
     *
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return null;
    }
}
