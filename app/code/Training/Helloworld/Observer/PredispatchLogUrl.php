<?php

namespace Training\Helloworld\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class PredispatchLogUrl implements ObserverInterface
{

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $this->logger->debug("Current path info : " . $observer->getEvent()->getRequest()->getPathInfo());
    }
}
