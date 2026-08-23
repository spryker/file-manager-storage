<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\FileManagerStorage\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\FileStorageTransfer;
use Generated\Shared\Transfer\FileTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use ReflectionClass;
use Spryker\Zed\FileManagerStorage\Business\Storage\FileManagerStorageWriter;
use Spryker\Zed\FileManagerStorage\Dependency\Facade\FileManagerStorageToLocaleFacadeInterface;
use Spryker\Zed\FileManagerStorage\Persistence\FileManagerStorageEntityManagerInterface;
use Spryker\Zed\FileManagerStorage\Persistence\FileManagerStorageRepositoryInterface;
use SprykerTest\Zed\FileManagerStorage\FileManagerStorageBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group FileManagerStorage
 * @group Business
 * @group FileManagerStorageWriterTest
 * Add your own group annotations below this line
 */
class FileManagerStorageWriterTest extends Unit
{
    protected const string FILE_UUID = 'a1b2c3d4-e5f6-7890-abcd-ef1234567890';

    protected const int ID_FILE = 42;

    protected const string LOCALE_NAME = 'de_DE';

    /**
     * @var \SprykerTest\Zed\FileManagerStorage\FileManagerStorageBusinessTester
     */
    protected FileManagerStorageBusinessTester $tester;

    public function testCreateDataSetSetsFileUuidFromFileTransferUuid(): void
    {
        $capturedTransfer = null;
        $entityManagerMock = $this->createMock(FileManagerStorageEntityManagerInterface::class);
        $entityManagerMock->expects($this->once())
            ->method('saveFileStorage')
            ->willReturnCallback(static function (FileStorageTransfer $transfer) use (&$capturedTransfer): void {
                $capturedTransfer = $transfer;
            });

        $fileTransfer = (new FileTransfer())
            ->setIdFile(static::ID_FILE)
            ->setFileName('test.pdf')
            ->setUuid(static::FILE_UUID);

        $this->callCreateDataSet(
            $this->createWriter($entityManagerMock),
            $fileTransfer,
            (new LocaleTransfer())->setLocaleName(static::LOCALE_NAME),
        );

        $this->assertSame(static::FILE_UUID, $capturedTransfer->getFileUuid());
    }

    public function testCreateDataSetFallsBackToStringFileIdWhenUuidIsNull(): void
    {
        $capturedTransfer = null;
        $entityManagerMock = $this->createMock(FileManagerStorageEntityManagerInterface::class);
        $entityManagerMock->expects($this->once())
            ->method('saveFileStorage')
            ->willReturnCallback(static function (FileStorageTransfer $transfer) use (&$capturedTransfer): void {
                $capturedTransfer = $transfer;
            });

        $fileTransfer = (new FileTransfer())
            ->setIdFile(static::ID_FILE)
            ->setFileName('test.pdf');

        $this->callCreateDataSet(
            $this->createWriter($entityManagerMock),
            $fileTransfer,
            (new LocaleTransfer())->setLocaleName(static::LOCALE_NAME),
        );

        $this->assertSame((string)static::ID_FILE, $capturedTransfer->getFileUuid());
    }

    public function testUpdateDataSetSetsFileUuidFromFileTransferUuid(): void
    {
        $capturedTransfer = null;
        $entityManagerMock = $this->createMock(FileManagerStorageEntityManagerInterface::class);
        $entityManagerMock->expects($this->once())
            ->method('saveFileStorage')
            ->willReturnCallback(static function (FileStorageTransfer $transfer) use (&$capturedTransfer): void {
                $capturedTransfer = $transfer;
            });

        $fileTransfer = (new FileTransfer())
            ->setIdFile(static::ID_FILE)
            ->setFileName('test.pdf')
            ->setUuid(static::FILE_UUID);

        $this->callUpdateDataSet(
            $this->createWriter($entityManagerMock),
            $fileTransfer,
            new FileStorageTransfer(),
            (new LocaleTransfer())->setLocaleName(static::LOCALE_NAME),
        );

        $this->assertSame(static::FILE_UUID, $capturedTransfer->getFileUuid());
    }

    public function testUpdateDataSetFallsBackToStringFileIdWhenUuidIsNull(): void
    {
        $capturedTransfer = null;
        $entityManagerMock = $this->createMock(FileManagerStorageEntityManagerInterface::class);
        $entityManagerMock->expects($this->once())
            ->method('saveFileStorage')
            ->willReturnCallback(static function (FileStorageTransfer $transfer) use (&$capturedTransfer): void {
                $capturedTransfer = $transfer;
            });

        $fileTransfer = (new FileTransfer())
            ->setIdFile(static::ID_FILE)
            ->setFileName('test.pdf');

        $this->callUpdateDataSet(
            $this->createWriter($entityManagerMock),
            $fileTransfer,
            new FileStorageTransfer(),
            (new LocaleTransfer())->setLocaleName(static::LOCALE_NAME),
        );

        $this->assertSame((string)static::ID_FILE, $capturedTransfer->getFileUuid());
    }

    protected function createWriter(FileManagerStorageEntityManagerInterface $entityManager): FileManagerStorageWriter
    {
        return new FileManagerStorageWriter(
            $entityManager,
            $this->createMock(FileManagerStorageRepositoryInterface::class),
            $this->createMock(FileManagerStorageToLocaleFacadeInterface::class),
        );
    }

    protected function callCreateDataSet(FileManagerStorageWriter $writer, FileTransfer $fileTransfer, LocaleTransfer $localeTransfer): void
    {
        $method = (new ReflectionClass($writer))->getMethod('createDataSet');
        $method->invoke($writer, $fileTransfer, $localeTransfer);
    }

    protected function callUpdateDataSet(
        FileManagerStorageWriter $writer,
        FileTransfer $fileTransfer,
        FileStorageTransfer $fileStorageTransfer,
        LocaleTransfer $localeTransfer,
    ): void {
        $method = (new ReflectionClass($writer))->getMethod('updateDataSet');
        $method->invoke($writer, $fileTransfer, $fileStorageTransfer, $localeTransfer);
    }
}
