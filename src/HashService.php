<?php
namespace WebhookHandler;

class HashService
{
    /**
     * payload string
     * @var [type]
     */
    private $payload;

    /**
     * hash
     * @var [type]
     */
    private $hash;

    /**
     * signature
     * @var [type]
     */
    private $signature;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * static call make pattern
     * @param  [type] $payload [description]
     * @return [type]          [description]
     */
    public static function make($payload)
    {
        return new static($payload);
    }

    /**
     * set hash
     * @param [type] $hash [description]
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * encrypt payload with key
     * @param  string $key key
     * @return [type]      [description]
     */
    public function encrypt($key)
    {
        $this->signature = hash_hmac($this->hash, $this->payload, $key);
        return $this;
    }

    /**
     * compare payload againts signature
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function compare($data)
    {
        return $this->signature === $data ? true : false;
    }
}
