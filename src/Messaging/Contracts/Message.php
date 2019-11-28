<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging\Contracts;

use Kreait\Firebase\Messaging\CloudMessage;

interface Message
{
    /**
     *  Title must be present on android notification and ios (watch) notification.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Message;

    /**
     * Indicates notification body text.
     *
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): Message;

    /**
     * Set data payload attached to a message,
     * must be an array of key-value pairs where all keys and values are strings.
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data): Message;

    /**
     * Get as a CloudMessage instance
     *
     * @return \Kreait\Firebase\Messaging\CloudMessage
     */
    public function toCloudMessage(): CloudMessage;
}