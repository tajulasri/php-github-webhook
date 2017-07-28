<?php

namespace WebhookHandler;

class HashService
{
    private $payload;

    private $hash;

    private $signature;

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

    public function encrypt($key)
    {
        $this->signature = hash_hmac($this->hash, $this->payload, $key);
        return $this;
    }

    public function compare($data)
    {
        return $this->signature === $data ?: false;
    }
}
