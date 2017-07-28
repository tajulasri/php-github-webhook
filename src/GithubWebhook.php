<?php

namespace WebhookHandler;

use Illuminate\Http\Request;
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
        }

        return $this;
    }

    /**
     * all logic should be inside here
     * @return [type] [description]
     */
    public function start()
    {
        //check headers present.
        //run hash services comparison
        $signature = HashService::make('testing')
            ->setHash('sha1')
            ->encrypt('testing', $this->credentials['secret_token'])
            ->compare('40cf35581833746c71a4c3c53886fe2a2e207577');

        if (!$signature) {

            //do something here
        }
    }
}
