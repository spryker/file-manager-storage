<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Subscriber;

use Spryker\Shared\FileManagerStorage\FileManagerStorageConfig;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\FileManager\Dependency\FileManagerEvents;
use Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener\FileInfoListener;
use Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener\FileLocalizedAttributesListener;
use Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener\FilePublishListener;
use Spryker\Zed\FileManagerStorage\Communication\Plugin\Event\Listener\FileUnpublishListener;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\FileManagerStorage\Communication\FileManagerStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\FileManagerStorage\Business\FileManagerStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\FileManagerStorage\FileManagerStorageConfig getConfig()
 */
class FileManagerStorageSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection)
    {
        $this->addFileListeners($eventCollection);
        $this->addFileInfoListeners($eventCollection);
        $this->addFileLocalizedAttributesListeners($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addFileListeners(EventCollectionInterface $eventCollection)
    {
        $eventCollection
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_CREATE, new FilePublishListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_UPDATE, new FilePublishListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_DELETE, new FileUnpublishListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerStorageConfig::FILE_PUBLISH, new FilePublishListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addFileInfoListeners(EventCollectionInterface $eventCollection)
    {
        $eventCollection
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_INFO_CREATE, new FileInfoListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_INFO_UPDATE, new FileInfoListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_INFO_DELETE, new FileInfoListener(), 0, null, $this->getConfig()->getEventQueueName());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addFileLocalizedAttributesListeners(EventCollectionInterface $eventCollection)
    {
        $eventCollection
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_LOCALIZED_ATTRIBUTES_CREATE, new FileLocalizedAttributesListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_LOCALIZED_ATTRIBUTES_UPDATE, new FileLocalizedAttributesListener(), 0, null, $this->getConfig()->getEventQueueName())
            ->addListenerQueued(FileManagerEvents::ENTITY_FILE_LOCALIZED_ATTRIBUTES_DELETE, new FileLocalizedAttributesListener(), 0, null, $this->getConfig()->getEventQueueName());
    }
}
