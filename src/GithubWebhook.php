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
        $hashCheck = HashService::make('dc724af18fbdd4e59189f5fe768a5f8311527050')
            ->setHash('sha1')
            ->check($this->credentials['secret_token']);

        dd($hashCheck);
    }
}
