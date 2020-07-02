<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener;

use Spryker\Zed\FileManager\Dependency\FileManagerEvents;

/**
 * @deprecated Use {@link \Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener\FilePublishListener}
 *   and {@link \Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener\FileUnpublishListener} instead.
 *
 * @method \Spryker\Zed\FileManagerStorage\Communication\FileManagerStorageCommunicationFactory getFactory()
 */
class FileListener extends AbstractFileManagerListener
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $this->preventTransaction();
        $fileIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);

        if ($eventName === FileManagerEvents::ENTITY_FILE_DELETE) {
            $this->unpublish($fileIds);
        }

        if ($eventName === FileManagerEvents::ENTITY_FILE_CREATE || $eventName === FileManagerEvents::ENTITY_FILE_UPDATE) {
            $this->publish($fileIds);
        }
    }
}
