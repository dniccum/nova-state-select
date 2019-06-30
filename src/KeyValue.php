<?php


namespace Dniccum\StateSelect;


class KeyValue
{
    /**
     * @var string $key
     */
    public $key;

    /**
     * @var string $value
     */
    public $value;

    /**
     * KeyValue constructor.
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}