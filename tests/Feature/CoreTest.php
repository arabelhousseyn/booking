<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoreTest extends TestCase
{
    use WithFaker;

    private string $endpoint = '/api/v1/core';

    protected function setUp(): void
    {
        parent::setUp();
    }
    public function test_index()
    {
        $this->json('get',$this->endpoint)
            ->assertOk();
    }
}
