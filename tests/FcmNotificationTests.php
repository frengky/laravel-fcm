<?php

namespace Frengky\Fcm\Tests;

use Frengky\Fcm\Facades\Fcm;
use Frengky\Fcm\Messaging\AndroidMessage;
use Frengky\Fcm\Messaging\AndroidMulticastMessage;
use Illuminate\Support\Facades\Log;

final class FcmNotificationTests extends TestCase
{
    private $deviceToken = 'dY_Gy8qwx2E:APA91bGsiV6UuPNfObCTBuJ6tpxqe3Qzs3H9DqvUg9mj0QbbO40iu6Npg2V_rvclrv_U3w5HI1oWg-Qg9j1TpJHz5Q2DDQsZ51-ZgS5O_FN_Mn3WL7Bmpa8XNRNzgRBJgrX4Vs6afQIe';
    
    public function test_send_notification_to_single_device() {
        Log::debug('test_send_notification_to_single_device in the next 5 secs');
        sleep(5);

        $message = (new AndroidMessage('3600s', 'high'))
            ->setTitle('Single Message')
            ->setBody('This is test of single message')
            ->setData([
                'action' => 'web',
                'url' => 'https://www.google.co.id'
            ]);

        $result = Fcm::sendToDevice($this->deviceToken, $message);
        $this->assertArrayHasKey('name', $result);
    }

    public function test_send_multicast_notifications() {
        Log::debug('test_send_multicast_notifications in the next 5 secs');
        sleep(5);

        $message = (new AndroidMulticastMessage('3600s', 'high'))
            ->setTitle('Multicast Message')
            ->setBody('This is test of multicast message')
            ->setData([
                'action' => 'web',
                'url' => 'https://www.google.co.id'
            ]);

        $tokens = [ $this->deviceToken ];

        $result = Fcm::sendMulticast($tokens, $message);
        $this->assertTrue(count($tokens) === $result->successes()->count());
        $this->assertFalse($result->hasFailures());
    }
}
