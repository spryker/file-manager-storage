<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\FileManagerStorage\Storage;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\FileStorageDataTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\FileManagerStorage\Dependency\Client\FileManagerStorageToStorageClientInterface;
use Spryker\Client\FileManagerStorage\Dependency\Service\FileManagerStorageToSynchronizationServiceInterface;
use Spryker\Client\FileManagerStorage\Storage\FileManagerStorage;
use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;
use SprykerTest\Client\FileManagerStorage\FileManagerStorageClientTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group FileManagerStorage
 * @group Storage
 * @group FileManagerStorageTest
 * Add your own group annotations below this line
 */
class FileManagerStorageTest extends Unit
{
    protected const string FILE_UUID = 'a1b2c3d4-e5f6-7890-abcd-ef1234567890';

    protected const int ID_FILE = 42;

    protected const string LOCALE_NAME = 'de_DE';

    protected const string STORAGE_KEY = 'file.de_de.uuid:a1b2c3d4-e5f6-7890-abcd-ef1234567890';

    /**
     * @var \SprykerTest\Client\FileManagerStorage\FileManagerStorageClientTester
     */
    protected FileManagerStorageClientTester $tester;

    public function testFindFileByUuidReturnsTransferWhenStorageHasData(): void
    {
        $fileData = ['file_name' => 'test.pdf', 'type' => 'application/pdf'];

        $storageClientMock = $this->createMock(FileManagerStorageToStorageClientInterface::class);
        $storageClientMock->method('get')->willReturnOnConsecutiveCalls(
            ['id' => static::ID_FILE],
            $fileData,
        );

        $storage = new FileManagerStorage(
            $storageClientMock,
            $this->createSynchronizationServiceMock(static::STORAGE_KEY),
        );

        $result = $storage->findFileByUuid(static::FILE_UUID, static::LOCALE_NAME);

        $this->assertInstanceOf(FileStorageDataTransfer::class, $result);
        $this->assertSame('test.pdf', $result->getFileName());
    }

    public function testFindFileByUuidReturnsNullWhenStorageHasNoData(): void
    {
        $storage = new FileManagerStorage(
            $this->createStorageClientMock(null),
            $this->createSynchronizationServiceMock(static::STORAGE_KEY),
        );

        $this->assertNull($storage->findFileByUuid(static::FILE_UUID, static::LOCALE_NAME));
    }

    public function testFindFileByIdReturnsTransferWhenStorageHasData(): void
    {
        $storage = new FileManagerStorage(
            $this->createStorageClientMock(['file_name' => 'test.pdf', 'type' => 'application/pdf']),
            $this->createSynchronizationServiceMock(sprintf('file.de_de.%d', static::ID_FILE)),
        );

        $result = $storage->findFileById(static::ID_FILE, static::LOCALE_NAME);

        $this->assertInstanceOf(FileStorageDataTransfer::class, $result);
    }

    public function testFileIsAccessibleBothByUuidAndByIdWhenMappingIsConfigured(): void
    {
        $fileData = ['file_name' => 'test.pdf', 'type' => 'application/pdf'];

        $storageClientMock = $this->createMock(FileManagerStorageToStorageClientInterface::class);
        $storageClientMock->method('get')
            ->willReturnCallback(static function (string $key) use ($fileData): ?array {
                if (str_contains($key, 'uuid:')) {
                    return ['id' => static::ID_FILE];
                }

                return $fileData;
            });

        $keyBuilderMock = $this->createMock(SynchronizationKeyGeneratorPluginInterface::class);
        $keyBuilderMock->method('generateKey')
            ->willReturnCallback(static function (SynchronizationDataTransfer $transfer): string {
                return sprintf('file.de_de.%s', $transfer->getReference());
            });

        $synchronizationServiceMock = $this->createMock(FileManagerStorageToSynchronizationServiceInterface::class);
        $synchronizationServiceMock->method('getStorageKeyBuilder')->willReturn($keyBuilderMock);

        $storage = new FileManagerStorage($storageClientMock, $synchronizationServiceMock);

        $byUuid = $storage->findFileByUuid(static::FILE_UUID, static::LOCALE_NAME);
        $byId = $storage->findFileById(static::ID_FILE, static::LOCALE_NAME);

        $this->assertInstanceOf(FileStorageDataTransfer::class, $byUuid);
        $this->assertInstanceOf(FileStorageDataTransfer::class, $byId);
        $this->assertSame($byId->getFileName(), $byUuid->getFileName());
    }

    protected function createStorageClientMock(array|null $returnValue): FileManagerStorageToStorageClientInterface
    {
        $mock = $this->createMock(FileManagerStorageToStorageClientInterface::class);
        $mock->method('get')->willReturn($returnValue);

        return $mock;
    }

    protected function createSynchronizationServiceMock(string $storageKey): FileManagerStorageToSynchronizationServiceInterface
    {
        $keyBuilderMock = $this->createMock(SynchronizationKeyGeneratorPluginInterface::class);
        $keyBuilderMock->method('generateKey')->willReturn($storageKey);

        $mock = $this->createMock(FileManagerStorageToSynchronizationServiceInterface::class);
        $mock->method('getStorageKeyBuilder')->willReturn($keyBuilderMock);

        return $mock;
    }
}
