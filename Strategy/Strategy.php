<?php

namespace KPhoen\ContactBundle\Strategy;

use Symfony\Component\HttpFoundation\Request;

interface Strategy
{
    public function getAddress(Request $request);
}
