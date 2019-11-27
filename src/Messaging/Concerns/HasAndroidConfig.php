<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging\Concerns;

use Frengky\Fcm\Messaging\Contracts\Message;

use Kreait\Firebase\Messaging\Config;
use Kreait\Firebase\Messaging\AndroidConfig;

trait HasAndroidConfig
{
    /** @var string */
    protected $ttl;

    /** @var string */
    protected $priority;

    /** @var string */
    protected $clickAction;

    /** @var string */
    protected $sound = 'default';

    /** @var string */
    protected $tag;

    /**
     * @param string $ttl
     */
    public function setTTL(string $ttl): Message {
        $this->ttl = $ttl;
        return $this;
    }

    /** @param string $ttl */
    public function setPriority(string $priority): Message {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Indicates the action associated with a user click on the notification.
     * FCM always start launcher activity, if the action is not set.
     *
     * @param string $action
     * @return $this
     */
    public function setClickAction(string $action): Message {
        $this->clickAction = $action;
        return $this;
    }

    /**
     * The sound to play when the Android device receives the notification.
     * Supports "default" or the filename of a sound resource bundled in the app. Sound files must reside in /res/raw/
     *
     * @param string $sound
     * @return $this
     */
    public function setSound(string $sound = 'default'): Message {
        $this->sound = $sound;
        return $this;
    }

    /**
     * Identifier used to replace existing notifications in the notification drawer.
     * If not specified, each request creates a new notification.
     * If specified and a notification with the same tag is already being shown,
     * the new notification replaces the existing one in the notification drawer.
     *
     * @param string $tag
     * @return $this
     */
    public function setTag(string $tag): Message {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return Kreait\Firebase\Messaging\Config
     */
    public function getAndroidConfig(): Config {
        return AndroidConfig::fromArray([
            'ttl' => $this->ttl,
            'priority' => $this->priority,
            'notification' => array_filter([
                'title' => $this->title,
                'body' => $this->body,
                'sound' => $this->sound,
                'clickAction' => $this->clickAction,
                'tag' => $this->tag
            ])
        ]);
    }    

}