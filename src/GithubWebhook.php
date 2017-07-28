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

        $this->credentials = $credentials;
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
            ->setHash($this->getHashType())
            ->encrypt($this->credentials['secret_key'])
            ->compare('40cf35581833746c71a4c3c53886fe2a2e207577'); //github header payload
        //40cf35581833746c71a4c3c53886fe2a2e207577

        return dd($signature);

        if (!$signature) {

            //do something here
        }
    }

    private function getHashType()
    {
        list($algo, $hash) = explode('=', 'sha1=59baee686dc288a3e7b4fe5a501663f2de47117d', 2);
        //replace this with github header.
        return $algo;
    }
}
