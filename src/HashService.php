<?php

namespace WebhookHandler;

class HashService
{
    private $payload;

    private $hash;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public static function make($payload)
    {
        return new static($payload);
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    public function check($compare)
    {
        return hash_hmac($this->hash, $this->payload, $compare) ? true : false;
    }
}
