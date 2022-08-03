<?php

namespace Signify\SwiftMailerAWSSESTransport;

use Aws\Ses\SesClient;
use \Swift_Transport;
use \Swift_Events_SimpleEventDispatcher;
use \Swift_Mime_SimpleMessage;
use \Swift_Events_EventListener;

/**
 * Simple SES email transporter.
 */
class AWSSESTransport implements Swift_Transport {

    /**
     * @var SesClient
     */
    protected $client;

    /**
     * @var Swift_Events_SimpleEventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Create a new SES Transport using AWS config.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->client = new SesClient($config);
        $this->eventDispatcher = new Swift_Events_SimpleEventDispatcher();
    }

    /**
     * Not used.
     */
    public function isStarted() {}

    /**
     * Not used.
     */
    public function start() {}

    /**
     * Not used.
     */
    public function stop() {}

    /**
     * Not used
     */
    public function ping() {}

    /**
     * Send the message.
     *
     * @param Swift_Mime_SimpleMessage $message
     * @param string[] &$failedRecipients
     * @return int
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        if ($evt = $this->eventDispatcher->createSendEvent($this, $message)) {
            $this->eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
            if ($evt->bubbleCancelled()) {
                return 0;
            }
        }
        $this->client->sendRawEmail([
            'RawMessage' => array('Data' => $message->toString())
        ]);

        // Count number of receipts.
        $count = count((array) $message->getTo())
            + count((array) $message->getCc())
            + count((array) $message->getBcc());

        return $count;
    }

    /**
     * Register a plugin.
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->eventDispatcher->bindEventListener($plugin);
    }
}