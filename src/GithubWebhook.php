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

    /**
     * response object
     * @var [type]
     */
    private $response;

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
    public function handle()
    {

        $parser = $this->parseSignatureHash();
        //run hash services comparison
        $signature = HashService::make('testing')
            ->setHash($parser['hash_type'])
            ->encrypt($this->credentials['secret_key'])
            ->compare($parser['signature']);

        if (!$signature) {

            throw new WebhookHandlerException('Signature not match.');
        }

        $this->response = $this->request->all();

        return true;
    }

    /**
     * get response return
     * @return [type] [description]
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * extract signature and hash from header
     * @return [type] [description]
     */
    private function parseSignatureHash()
    {
        $data = [

            'hash_type' => null,
            'signature' => null,
        ];

        if ($this->request->hasHeader('HTTP_X_HUB_SIGNATURE')) {

            list($algo, $signature) = explode('=', $this->request->header('HTTP_X_HUB_SIGNATURE'), 2);
            $data['hash_type'] = $algo;
            $data['signature'] = $signature;
        }

        return $data;
    }

}
