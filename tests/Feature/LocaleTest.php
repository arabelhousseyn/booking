<?php

namespace Tests\Feature;

use App\Http\Middleware\Locale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_locale()
    {
        $request = new Request();
        $lang = 'en';
        $request->headers->set('lang', $lang);

        $locale = new Locale();

        $locale->handle($request,function (){});

        $this->assertEquals('en',$lang);
    }
}
