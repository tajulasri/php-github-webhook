<?php

namespace WebhookHandler;

use Illuminate\Http\Request;
use WebhookHandler\Exceptions\WebhookHandlerException;
use WebhookHandler\ValidatorService;

class GithubWebhook
{

    /**
     * Illuminate/Http/Request
     * @var [type]
     */
    private $request;

    /**
     * Credentials
     * @var [type]
     */
    private $credentials;

    public function __construct(Request $request)
    {
        $this->request = $request->createFromGlobals();
    }

    /**
     * credentials
     * @param array $credentials [description]
     */
    public function setCredentials(array $credentials)
    {
        if (!ValidatorService::make($credentials)->validate()->passed()) {

            throw new WebhookHandlerException('Secret token key must be present in credentials ');
            return;
        }

        return $this;
    }

    /**
     * all logic should be inside here
     * @return [type] [description]
     */
    public function start()
    {
        return dd($this->request->all());
    }
}
