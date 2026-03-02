<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManagerStorage\Dependency\Facade;

use Generated\Shared\Transfer\FileCollectionTransfer;
use Generated\Shared\Transfer\FileCriteriaTransfer;

class FileManagerStorageToFileManagerFacadeBridge implements FileManagerStorageToFileManagerFacadeInterface
{
    /**
     * @var \Spryker\Zed\FileManager\Business\FileManagerFacadeInterface
     */
    protected $fileManagerFacade;

    /**
     * @param \Spryker\Zed\FileManager\Business\FileManagerFacadeInterface $fileManagerFacade
     */
    public function __construct($fileManagerFacade)
    {
        $this->fileManagerFacade = $fileManagerFacade;
    }

    public function getFileCollection(FileCriteriaTransfer $fileCriteriaTransfer): FileCollectionTransfer
    {
        return $this->fileManagerFacade->getFileCollection($fileCriteriaTransfer);
    }
}
