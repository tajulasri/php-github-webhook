<?php

namespace WebhookHandler;

abstract class Event
{

    /**
     * header
     * @var [type]
     */
    private $header;

    /**
     * key in header
     * @var string
     */
    private static $key = 'X-github-Event';

    public function __construct($header = [])
    {
        $this->header = $header;
    }

    public static function make($header = [])
    {
        return new static($header);
    }

    abstract public function eventKey();

    /**
     * check present of event
     * @return boolean does ping supply
     */
    public function present(): boolean
    {
        return in_array(static::$key, $this->header) ?: false;
    }

    /**
     * does event is ping
     * @return boolean [description]
     */
    public function is(): boolean
    {
        return $this->header[static::$key] = $this->eventKey() ?: false;
    }

}
