<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging;

use Frengky\Fcm\Messaging\Contracts\Message;
use Frengky\Fcm\Messaging\Concerns\HasAndroidConfig;
use Frengky\Fcm\Messaging\Concerns\HasApnsConfig;
use Frengky\Fcm\Messaging\Concerns\HasWebPushConfig;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class UniversalMessage extends BaseMessage implements Message
{
    use HasAndroidConfig, HasApnsConfig, HasWebPushConfig;

    public function __construct(string $ttl, string $priority, array $apnsHeaders) {
        $this->setTTL($ttl);
        $this->setPriority($priority);
        $this->setApnsHeaders($apnsHeaders);        
    }

    /**
     * Get as a CloudMessage instance
     *
     * @return \Kreait\Firebase\Messaging\CloudMessage
     */
    public function toCloudMessage(): CloudMessage {
        return CloudMessage::new()
            ->withNotification(Notification::create($this->title, $this->body))
            ->withData($this->data)
            ->withAndroidConfig($this->getAndroidConfig())
            ->withApnsConfig($this->getApnsConfig())
            ->withWebPushConfig($this->getWebPushConfig());
    }
}