<?php

namespace Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

class ServiceWorkerTest extends TestCase
{
    public function test_service_worker_file_exists(): void
    {
        $fs = new Filesystem();
        $this->assertTrue($fs->exists(public_path('sw.js')));
        $this->assertTrue($fs->exists(public_path('offline.html')));
        $this->assertTrue($fs->exists(public_path('manifest.json')));
    }
}

