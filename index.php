<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\Request;
use WebhookHandler\GithubWebhook;

/**
 * expected usages
 */

$webhook = (new GithubWebhook(new Request))->setCredentials(['secret_key' => 'kambing'])->start();
