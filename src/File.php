<?php

namespace diaeai\FlysystemFileResponse;

use GuzzleHttp\Psr7\CachingStream;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Filesystem\AwsS3V3Adapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class File
{
    private FilesystemAdapter $disk;
    private string $path;

    public function __construct(FilesystemAdapter $disk, string $path, bool $checkPath = true)
    {
        if ($checkPath && !$disk->fileExists($path)) {
            throw new FileNotFoundException($path);
        }

        $this->disk = $disk;
        $this->path = $path;
    }

    public function getFilename(): string
    {
        return basename($this->path);
    }

    public function getPathname(): string
    {
        return $this->disk->path($this->path);
    }

    public function getSize(): int
    {
        return $this->disk->size($this->path);
    }

    public function getMimeType(): ?string
    {
        return $this->disk->mimeType($this->path);
    }

    public function getMTime(): int
    {
        return $this->disk->lastModified($this->path);
    }

    public function getUrl(): string
    {
        return $this->disk->url($this->path);
    }

    public function getStream()
    {
        $stream = new Stream($this->disk->readStream($this->path), ['size' => $this->getSize()]);

        if ($this->disk instanceof AwsS3V3Adapter) {
            return new CachingStream($stream);
        }

        return $stream;
    }
}
