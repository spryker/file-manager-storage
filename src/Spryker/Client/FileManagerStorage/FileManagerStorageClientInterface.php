<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\FileManagerStorage;

use Generated\Shared\Transfer\FileStorageDataTransfer;

interface FileManagerStorageClientInterface
{
    /**
     * Specification:
     * - Finds file data in the key-value storage by numeric file ID.
     * - Returns null if no storage entry exists for the given ID.
     *
     * @api
     *
     * @param int $idFile
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\FileStorageDataTransfer|null
     */
    public function findFileById(int $idFile, string $localeName);

    /**
     * Specification:
     * - Finds file data in the key-value storage by file UUID.
     * - Returns null if no storage entry exists for the given UUID.
     *
     * @api
     *
     * @param string $uuid
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\FileStorageDataTransfer|null
     */
    public function findFileByUuid(string $uuid, string $localeName): ?FileStorageDataTransfer;
}
