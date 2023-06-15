<?php

namespace diaeai\FlysystemFileResponse;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class FlysystemFileResponseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        FilesystemAdapter::macro('file', function ($path, $name = null, array $headers = [], $disposition = 'inline')
        {
            $response = new Response(new File($this, $path), 200, $headers, true, $disposition);

            //$response->setContentDisposition($disposition, $name);

            $response->prepare(request());

            return $response;
        });
    }
}
