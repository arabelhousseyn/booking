<?php

namespace Tests\Feature;

use App\Http\Middleware\ApiVersion;
use Illuminate\Http\Request;
use Tests\TestCase;

class ApiVersionTest extends TestCase
{
    public function test_api_version()
    {
        $request = new Request();
        $version = '1';
        $request->headers->set('version', $version);

        $apiVersion = new ApiVersion();

        $apiVersion->handle($request, function () {
        });

        $this->assertEquals('1', $version);
    }
}
