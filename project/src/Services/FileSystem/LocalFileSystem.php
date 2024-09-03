<?php

namespace App\Services\FileSystem;

use App\Interfaces\FileSystemInterface;

class LocalFileSystem implements FileSystemInterface
{
    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    public function createDirectory(string $path, int $permissions, bool $recursive): bool
    {
        return mkdir($path, $permissions, $recursive);
    }

    public function appendToFile(string $filename, string $data): bool
    {
        return file_put_contents($filename, $data, FILE_APPEND | LOCK_EX) !== false;
    }
}