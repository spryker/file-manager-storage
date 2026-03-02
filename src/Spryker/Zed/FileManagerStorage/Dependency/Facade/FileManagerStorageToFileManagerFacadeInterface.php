<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManagerStorage\Dependency\Facade;

use Generated\Shared\Transfer\FileCollectionTransfer;
use Generated\Shared\Transfer\FileCriteriaTransfer;

interface FileManagerStorageToFileManagerFacadeInterface
{
    public function getFileCollection(FileCriteriaTransfer $fileCriteriaTransfer): FileCollectionTransfer;
}
