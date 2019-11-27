<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging;

use Frengky\Fcm\Messaging\Contracts\Message;
use Frengky\Fcm\Messaging\Concerns\HasAndroidConfig;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class AndroidMulticastMessage extends BaseMessage implements Message
{
    use HasAndroidConfig;

    public function __construct(string $ttl, string $priority) {
        $this->setTTL($ttl);
        $this->setPriority($priority);
    }

    /**
     * Build the CloudMessage instance
     *
     * @param string $type
     * @param string $value
     * @return \Kreait\Firebase\Messaging\CloudMessage
     */
    public function toCloudMessage($type = '', $value = ''): CloudMessage {
        return CloudMessage::new()
            ->withNotification(Notification::create($this->title, $this->body))
            ->withData($this->data)
            ->withAndroidConfig($this->getAndroidConfig());
    }   
}