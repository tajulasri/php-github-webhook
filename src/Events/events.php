<?php

return [

    'push' => WebhookHandler\PushEvent::class,
    'project_created' => WebhookHandler\ProjectCreate::class,
    'issues' => WebhookHandler\Issues::class,
    'milestones' => WebhookHandler\Milestone::class,
    'forked' => WebhookHandler\Forked::class,
];
