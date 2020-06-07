<?php
namespace App\Sk;

class SkPayload
{
    public function __construct($data)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
            return $this;
        }
    }

    public function _appendClientPlatformInfo($request)
    {
        $this->ip_address = $request->getClientIp();
        $this->platform_signature = $request->header('User-Agent');
    }
}
