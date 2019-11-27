<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging\Concerns;

use Frengky\Fcm\Messaging\Contracts\Message;

use Kreait\Firebase\Messaging\Config;
use Kreait\Firebase\Messaging\ApnsConfig;

trait HasApnsConfig
{
    /** @var array */
    protected $apnsHeaders = [];

    /** @var int */
    protected $badge = 0;

    /**
     * @param array $headers
     */
    public function setApnsHeaders(array $headers = []): Message {
        $this->apnsHeaders = $headers;
        return $this;
    }

    /**
     * Indicates the badge on the client app home icon. (iOS only)
     *
     * @param int $badge
     * @return $this
     */
    public function setBadge(int $badge): Message {
        $this->badge = $badge;
        return $this;
    }

    /**
     * @return Kreait\Firebase\Messaging\Config
     */
    public function getApnsConfig(): Config {
        $aps = [
            'alert' => [
                'title' => $this->title,
                'body' => $this->body
            ]
        ];
        if ($this->badge) {
            $aps['badge'] = $this->badge;
        }

        return ApnsConfig::fromArray([
            'headers' => $this->apnsHeaders,
            'payload' => [
                'aps' => $aps
            ]
        ]);
    }    

}