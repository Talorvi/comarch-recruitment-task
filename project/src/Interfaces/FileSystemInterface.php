<?php

namespace App\Interfaces;

interface FileSystemInterface
{
    public function isDirectory(string $path): bool;

    public function createDirectory(string $path, int $permissions, bool $recursive): bool;

    public function appendToFile(string $filename, string $data): bool;
}