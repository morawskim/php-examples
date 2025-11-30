<?php

namespace App;

use Mcp\Capability\Attribute\McpResourceTemplate;

class MyResource
{
    #[McpResourceTemplate(uriTemplate: 'file://{filePath}', name: 'getFileContent')]
    public function getTextFile(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File {$filePath} does not exist");
        }

        if (!is_readable($filePath)) {
            throw new \RuntimeException("File {$filePath} is not readable");
        }

        return file_get_contents($filePath);
    }
}
