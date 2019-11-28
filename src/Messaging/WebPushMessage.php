<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging;

use Frengky\Fcm\Messaging\Contracts\Message;
use Frengky\Fcm\Messaging\Concerns\HasWebPushConfig;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class WebPushMessage extends BaseMessage implements Message
{
    use HasWebPushConfig;

    public function __construct() {
        //
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
            ->withWebPushConfig($this->getWebPushConfig());
    }    
}