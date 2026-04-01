<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\FileManagerStorage;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class FileManagerStorageConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - File resource name used for key generation.
     *
     * @api
     *
     * @var string
     */
    public const FILE_RESOURCE_NAME = 'file';

    /**
     * Specification:
     * - This event is used for file publishing.
     *
     * @api
     *
     * @var string
     */
    public const FILE_PUBLISH = 'File.spy_file.publish';

    /**
     * Specification:
     * - Queue name used for file manager publish events.
     *
     * @api
     *
     * @var string
     */
    public const string PUBLISH_FILE_MANAGER_QUEUE = 'publish.file_manager';
}
