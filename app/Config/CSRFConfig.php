<?php

namespace App\Config;

class CSRFConfig
{
    public $CSRFTokenName = 'csrf_test_name';
    public $CSRFHeaderName = 'X-CSRF-TOKEN';
    public $CSRFExpire = 7200;
    public $CSRFRegenerate = true;
}
