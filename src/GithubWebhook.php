<?php

namespace WebhookHandler;

use Illuminate\Http\Request;
use WebhookHandler\Exceptions\WebhookHandlerException;
use WebhookHandler\ValidatorService;
use WebhookHandler\WebhookInterface;

class GithubWebhook implements WebhookInterface
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

    /**
     * signature status
     * @var [type]
     */
    private $signature;

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
        $rawRequest = $this->request->getContent();

        //run hash services comparison
        $signature = HashService::make($rawRequest)
            ->setHash($parser['hash_type'])
            ->encrypt($this->credentials['secret_key'])
            ->compare($parser['signature']);

        $this->response = $rawRequest;
        $this->signature = $signature;

        return $this;
    }

    /**
     * return signature validation
     * @return [type] [description]
     */
    public function passes()
    {
        return $this->signature;
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

    /**
     * extract event from header
     * @return [type] [description]
     */
    private function parseEvent()
    {
        if ($this->request->hasHeader('HTTP_X_GITHUB_EVENT')) {

            return $this->request->header('HTTP_X_GITHUB_EVENT');
        }

        return null;
    }
}
