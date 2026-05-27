<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\FileManagerStorage\Storage;

use Generated\Shared\Transfer\FileStorageDataTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\FileManagerStorage\Dependency\Client\FileManagerStorageToStorageClientInterface;
use Spryker\Client\FileManagerStorage\Dependency\Service\FileManagerStorageToSynchronizationServiceInterface;

class FileManagerStorage implements FileManagerStorageInterface
{
    /**
     * @var string
     */
    protected const RESOURCE_NAME = 'file';

    /**
     * @var string
     */
    protected const UUID_REFERENCE_PREFIX = 'uuid';

    /**
     * @var \Spryker\Client\FileManagerStorage\Dependency\Client\FileManagerStorageToStorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Client\FileManagerStorage\Dependency\Service\FileManagerStorageToSynchronizationServiceInterface
     */
    protected $synchronizationService;

    /**
     * @var array
     */
    protected $translations = [];

    public function __construct(
        FileManagerStorageToStorageClientInterface $storageClient,
        FileManagerStorageToSynchronizationServiceInterface $synchronizationService
    ) {
        $this->storageClient = $storageClient;
        $this->synchronizationService = $synchronizationService;
    }

    /**
     * @param int $idFile
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\FileStorageDataTransfer|null
     */
    public function findFileById(int $idFile, string $localeName)
    {
        return $this->findFileByReference((string)$idFile, $localeName);
    }

    public function findFileByUuid(string $uuid, string $localeName): ?FileStorageDataTransfer
    {
        // The sync behavior stores the alias at "file:{locale}:uuid:{uuid}" — source prefix is the mapping field name.
        $storageKey = $this->generateKey(sprintf('%s:%s', static::UUID_REFERENCE_PREFIX, $uuid), $localeName);
        $aliasData = $this->storageClient->get($storageKey);

        if ($aliasData === null || !isset($aliasData['id'])) {
            return null;
        }

        return $this->findFileByReference((string)$aliasData['id'], $localeName);
    }

    protected function findFileByReference(string $reference, string $localeName): ?FileStorageDataTransfer
    {
        $storageKey = $this->generateKey($reference, $localeName);
        $fileContent = $this->storageClient->get($storageKey);

        if ($fileContent === null) {
            return null;
        }

        $fileStorageDataTransfer = new FileStorageDataTransfer();
        $fileStorageDataTransfer->fromArray($fileContent, true);

        return $fileStorageDataTransfer;
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return string
     */
    protected function generateKey($keyName, $localeName)
    {
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer->setReference($keyName);
        $synchronizationDataTransfer->setLocale($localeName);

        return $this->synchronizationService->getStorageKeyBuilder(static::RESOURCE_NAME)->generateKey($synchronizationDataTransfer);
    }
}
