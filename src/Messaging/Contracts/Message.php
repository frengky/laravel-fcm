<?php declare(strict_types=1);

namespace Frengky\Fcm\Messaging\Contracts;

use Kreait\Firebase\Messaging\CloudMessage;

interface Message
{
    /**
     * Build the CloudMessage instance
     *
     * @param string $type
     * @param string $value
     * @return \Kreait\Firebase\Messaging\CloudMessage
     */
    public function toCloudMessage(string $type, string $value): CloudMessage;
}