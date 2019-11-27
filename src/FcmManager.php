<?php declare(strict_types=1);

namespace Frengky\Fcm;

use Frengky\Fcm\FcmPlatform;
use Frengky\Fcm\Messaging\Contracts\Message;
use Frengky\Fcm\Messaging\AndroidMessage;
use Frengky\Fcm\Messaging\AndroidMulticastMessage;
use Frengky\Fcm\Messaging\ApnsMessage;
use Frengky\Fcm\Messaging\WebPushMessage;
use Frengky\Fcm\Messaging\UniversalMessage;

use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MulticastSendReport;

class FcmManager
{
    /** @var \Kreait\Firebase  */
    private $firebase;

    /** @var array */
    private $android;

    /** @var array */
    private $apns;

    public function __construct(Firebase $firebase, array $android, array $apns) {
        $this->firebase = $firebase;
        $this->android = $android;
        $this->apns = $apns;
    }

    /**
     * Create a message
     * 
     * @param int $platform
     * @return \Frengky\Fcm\Messaging\Contracts\Message
     */
    public function createMessage(int $platform = FcmPlatform::ALL): Message {
        if ($platform == FcmPlatform::ANDROID) {
            return new AndroidMessage($this->android['ttl'], $this->android['priority']);
        } else if ($platform == FcmPlatform::APNS) {
            return new ApnsMessage($this->apns['headers']);
        } else if ($platform == FcmPlatform::WEBPUSH) {
            return new WebPushMessage();
        } else {
            return new UniversalMessage($this->android['ttl'], $this->android['priority'], $this->apns['headers']);
        }
    }

    /**
     * Send a cloud message
     *
     * @param \Kreait\Firebase\Messaging\CloudMessage $message
     * @return array
     * @throws \Kreait\Firebase\Exception\Messaging\NotFound|\Exception
     */
    public function send(CloudMessage $message): array {
        return $this->firebase->getMessaging()->send($message);
    }

    /**
     * Send a message to a device
     *
     * @param string $token
     * @param \Frengky\Fcm\Messaging\Contracts\Message $message
     * @return array
     * @throws \Kreait\Firebase\Exception\Messaging\NotFound|\Exception
     */
    public function sendToDevice(string $token, Message $message): array {
        return $this->send($message->toCloudMessage('token', $token));
    }

    /**
     * Send multicast message
     * 
     * @param array $tokens
     * @param \Frengky\Fcm\Messaging\AndroidMulticastMessage $message
     * @return \Kreait\Firebase\Messaging\MulticastSendReport
     */
    public function sendMulticast(array $tokens, AndroidMulticastMessage $message): MulticastSendReport {
        return $this->firebase->getMessaging()->sendMulticast($message->toCloudMessage(), $tokens);
    }

    /**
     * Send a message (with or without condition) to a topic
     *
     * @param string $topic
     * @param \Frengky\Fcm\Messaging\Contracts\Message $message
     * @return array
     * @throws \Kreait\Firebase\Exception\Messaging\NotFound|\Exception
     */
    public function sendToTopic(string $topic, Message $message): array {
        $type = preg_match('/[^a-zA-Z0-9\s]+/', $topic) ? 'condition' : 'topic';
        return $this->send($message->toCloudMessage($type, $topic));
    }

    /**
     * Subscribe multiple tokens to a topic
     *
     * @param string $topic
     * @param array $tokens
     * @return array
     */    
    public function subscribe(string $topic, array $tokens): array {
        return $this->firebase->getMessaging()->subscribeToTopic($topic, $tokens);
    }

    /**
     * Unsubscribe multiple tokens from a topic
     *
     * @param string $topic
     * @param array $tokens
     * @return array
     */   
    public function unsubscribe(string $topic, array $tokens): array {
        return $this->firebase->getMessaging()->unsubscribeFromTopic($topic, $tokens);
    }

    /**
     * Validate a message
     *
     * @param array|CloudMessage $messages
     * @return array
     *
     * @throws \Kreait\Firebase\Exception\Messaging\InvalidArgumentException
     * @throws \Kreait\Firebase\Exception\Messaging\InvalidMessage
     */
    public function validate(CloudMessage $messages): array {
        return $this->firebase->getMessaging()->validate($messages);
    }    
}