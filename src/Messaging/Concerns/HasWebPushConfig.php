<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging\Concerns;

use Frengky\Fcm\Messaging\Contracts\Message;

use Kreait\Firebase\Messaging\Config;
use Kreait\Firebase\Messaging\WebPushConfig;

trait HasWebPushConfig
{
    /** @var string */
    protected $webPushIcon;

    /**
     * Set full url to the icon
     *
     * @param string $icon
     * @return $this
     */
    public function setWebPushIcon(string $icon): Message {
        $this->webPushIcon = $icon;
        return $this;
    }

    /**
     * @return Kreait\Firebase\Messaging\Config
     */
    public function getWebPushConfig(): Config {
        return WebPushConfig::fromArray([
            'notification' => array_filter([
                'title' => $this->title,
                'body' => $this->body,
                'icon' => $this->webPushIcon
            ])
        ]);
    }    

}