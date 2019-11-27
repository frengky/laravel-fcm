<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging;

use Frengky\Fcm\Messaging\Contracts\Message;

abstract class BaseMessage
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $body;
    
    /** @var array */
    protected $data;

    /**
     *  Title must be present on android notification and ios (watch) notification.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Message {
        $this->title = $title;
        return $this;
    }

    /**
     * Indicates notification body text.
     *
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): Message {
        $this->body = $body;
        return $this;
    }

    /**
     * Set data payload attached to a message,
     * must be an array of key-value pairs where all keys and values are strings.
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data): Message {
        $this->data = $data;
        return $this;
    }

}