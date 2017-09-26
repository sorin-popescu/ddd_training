<?php

namespace Domain\ValueObject;

class RollNumber
{
    private $identifier;

    private function  __construct(string $identifier) {
        $this->identifier = $identifier;
    }

    public static function fromIdentifier(string $identifier)
    {
        return new self($identifier);
    }
}
