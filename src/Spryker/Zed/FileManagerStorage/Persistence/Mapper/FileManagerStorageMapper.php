<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManagerStorage\Persistence\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\FileInfoTransfer;
use Generated\Shared\Transfer\FileLocalizedAttributesTransfer;
use Generated\Shared\Transfer\FileStorageTransfer;
use Generated\Shared\Transfer\FileTransfer;
use Orm\Zed\FileManager\Persistence\SpyFile;
use Orm\Zed\FileManager\Persistence\SpyFileInfo;
use Orm\Zed\FileManager\Persistence\SpyFileLocalizedAttributes;
use Orm\Zed\FileManagerStorage\Persistence\SpyFileStorage;
use Propel\Runtime\Collection\ObjectCollection;

class FileManagerStorageMapper implements FileManagerStorageMapperInterface
{
    /**
     * @param \Orm\Zed\FileManager\Persistence\SpyFile $file
     * @param \Generated\Shared\Transfer\FileTransfer $fileTransfer
     *
     * @return \Generated\Shared\Transfer\FileTransfer
     */
    public function mapFileEntityToTransfer(SpyFile $file, FileTransfer $fileTransfer)
    {
        $fileTransfer->fromArray(
            $file->toArray(),
            true,
        );

        foreach ($file->getSpyFileInfos() as $fileInfo) {
            $fileTransfer->addFileInfo(
                $this->mapFileInfoEntityToTransfer($fileInfo, new FileInfoTransfer()),
            );
        }

        /** @var \ArrayObject<int, \Generated\Shared\Transfer\FileLocalizedAttributesTransfer> $mappedFileLocalizedAttributesCollection */
        $mappedFileLocalizedAttributesCollection = new ArrayObject();

        $fileLocalizedAttributesCollection = $file->getSpyFileLocalizedAttributess();
        foreach ($fileLocalizedAttributesCollection as $fileLocalizedAttributes) {
            $mappedFileLocalizedAttributesCollection[$fileLocalizedAttributes->getFkLocale()] = $this->mapAddSpyFileLocalizedAttributesEntityToTransfer($fileLocalizedAttributes, new FileLocalizedAttributesTransfer());
        }

        $fileTransfer->setLocalizedAttributes($mappedFileLocalizedAttributesCollection);

        return $fileTransfer;
    }

    /**
     * @param \Orm\Zed\FileManagerStorage\Persistence\SpyFileStorage $fileStorage
     * @param \Generated\Shared\Transfer\FileStorageTransfer $fileStorageTransfer
     *
     * @return \Generated\Shared\Transfer\FileStorageTransfer
     */
    public function mapFileStorageEntityToTransfer(SpyFileStorage $fileStorage, FileStorageTransfer $fileStorageTransfer)
    {
        return $fileStorageTransfer->fromArray(
            $fileStorage->toArray(),
            true,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\FileStorageTransfer $fileStorageTransfer
     * @param \Orm\Zed\FileManagerStorage\Persistence\SpyFileStorage $fileStorage
     *
     * @return \Orm\Zed\FileManagerStorage\Persistence\SpyFileStorage
     */
    public function mapFileStorageTransferToEntity(FileStorageTransfer $fileStorageTransfer, SpyFileStorage $fileStorage)
    {
        $fileStorage->fromArray($fileStorageTransfer->toArray());
        $transferedData = $fileStorageTransfer->getData();
        $data = $transferedData !== null ? $transferedData->toArray() : [];
        $fileStorage->setData($data);

        return $fileStorage;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\FileManagerStorage\Persistence\SpyFileStorage> $fileStorageEntities
     *
     * @return array<\Generated\Shared\Transfer\FileStorageTransfer>
     */
    public function mapFileStorageEntityCollectionToTransferCollection(ObjectCollection $fileStorageEntities): array
    {
        $fileStorageTransfers = [];
        foreach ($fileStorageEntities as $fileStorageEntity) {
            $fileStorageTransfers[] = $this->mapFileStorageEntityToTransfer(
                $fileStorageEntity,
                new FileStorageTransfer(),
            );
        }

        return $fileStorageTransfers;
    }

    /**
     * @param \Orm\Zed\FileManager\Persistence\SpyFileInfo $fileInfo
     * @param \Generated\Shared\Transfer\FileInfoTransfer $fileInfoTransfer
     *
     * @return \Generated\Shared\Transfer\FileInfoTransfer
     */
    protected function mapFileInfoEntityToTransfer(SpyFileInfo $fileInfo, FileInfoTransfer $fileInfoTransfer)
    {
        return $fileInfoTransfer->fromArray(
            $fileInfo->toArray(),
            true,
        );
    }

    /**
     * @param \Orm\Zed\FileManager\Persistence\SpyFileLocalizedAttributes $fileLocalizedAttributes
     * @param \Generated\Shared\Transfer\FileLocalizedAttributesTransfer $fileLocalizedAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\FileLocalizedAttributesTransfer
     */
    protected function mapAddSpyFileLocalizedAttributesEntityToTransfer(
        SpyFileLocalizedAttributes $fileLocalizedAttributes,
        FileLocalizedAttributesTransfer $fileLocalizedAttributesTransfer
    ) {
        return $fileLocalizedAttributesTransfer->fromArray(
            $fileLocalizedAttributes->toArray(),
            true,
        );
    }
}
