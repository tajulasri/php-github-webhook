<?php

namespace WebhookHandler;

use WebhookHandler\Event;

class PingEvent extends Event
{
    public function eventKey()
    {
        return 'ping';
    }
}
