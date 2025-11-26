<?php

namespace Tests\Feature;

use Tests\TestCase;

class PwaManifestTest extends TestCase
{
    public function test_login_has_manifest_link(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('<link rel="manifest"', false);
    }
}

