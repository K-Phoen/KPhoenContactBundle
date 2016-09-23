<?php

namespace KPhoen\ContactBundle\Strategy;

use Symfony\Component\HttpFoundation\Request;

class FixedAddressStrategy implements Strategy
{
    protected $address;

    public function __construct(string $address)
    {
        $this->address = $address;
    }

    public function getAddress(Request $request) : string
    {
        return $this->address;
    }
}
