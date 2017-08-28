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

    /**
     * headers tag
     * @var [type]
     */
    private $headers = [

        'signature'   => 'X-Hub-Signature',
        'event'       => 'X-GitHub-Event',
        'delivery_id' => 'X-GitHub-Delivery',
    ];

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

        if (!$this->request->hasHeader($this->headers['signature'])) {

            throw new WebhookHandlerException('There is not signature in header present');
        }

        list($algo, $signature) = explode('=', $this->request->header($this->headers['signature']), 2);
        $data['hash_type'] = $algo;
        $data['signature'] = $signature;

        return $data;
    }

    /**
     * extract event from header
     * @return [type] [description]
     */
    private function parseEvent()
    {
        if (!$this->request->hasHeader($this->headers['event'])) {

            throw new WebhookHandlerException('There is not signature in header present');
        }

        return $this->request->header($this->headers['event']);
    }

}
