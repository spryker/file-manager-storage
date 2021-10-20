<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\FileManagerStorage;

use Spryker\Client\FileManagerStorage\Dependency\Client\FileManagerStorageToStorageClientBridge;
use Spryker\Client\FileManagerStorage\Dependency\Service\FileManagerStorageToSynchronizationServiceBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class FileManagerStorageDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_STORAGE = 'CLIENT_STORAGE';

    /**
     * @var string
     */
    public const SERVICE_SYNCHRONIZATION = 'SERVICE_SYNCHRONIZATION';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = $this->addClientStorage($container);
        $container = $this->addServiceSynchronization($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addClientStorage(Container $container)
    {
        $container->set(static::CLIENT_STORAGE, function (Container $container) {
            return new FileManagerStorageToStorageClientBridge(
                $container->getLocator()->storage()->client(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addServiceSynchronization(Container $container)
    {
        $container->set(static::SERVICE_SYNCHRONIZATION, function (Container $container) {
            return new FileManagerStorageToSynchronizationServiceBridge(
                $container->getLocator()->synchronization()->service(),
            );
        });

        return $container;
    }
}
