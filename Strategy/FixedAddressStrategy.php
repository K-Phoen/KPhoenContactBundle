<?php

namespace KPhoen\ContactBundle\Strategy;

class FixedAddressStrategy implements Strategy
{
    protected $address;

    public function __construct($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }
}
