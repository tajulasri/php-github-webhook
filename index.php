<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\Request;
use WebhookHandler\GithubWebhook;

/**
 * expected usages
 *
 * expected hash : 9bfe272c5fa40b2fe0f6da2bd3caa6054429d79a
 */

$webhook = (new GithubWebhook(new Request))
    ->setCredentials(['secret_key' => 'testing'])
    ->handle()
    ->getResponse();
