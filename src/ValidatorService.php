<?php

namespace WebhookHandler;

class ValidatorService
{

    /**
     * credentials
     * @var [type]
     */
    private $credentials;

    /**
     * pass status
     * @var [type]
     */
    private $pass;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * create static instance
     * @param  array  $credentials [description]
     * @return [type]              [description]
     */
    public static function make(array $credentials)
    {
        return new static($credentials);
    }

    /**
     * validation
     * @return [type] [description]
     */
    public function validate()
    {
        $this->pass = array_key_exists('secret_key', $this->credentials) ?: false;
        return $this;
    }

    /**
     * pass status
     * @return [type] [description]
     */
    public function passed()
    {
        return $this->pass;
    }
}
