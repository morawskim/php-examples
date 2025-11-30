<?php

namespace App;

use Mcp\Capability\Attribute\McpPrompt;
use Mcp\Capability\Attribute\McpTool;

class StrToUpperTool
{
    #[McpTool(name: 'strToUpper')]
    public function strToUpper(string $string): string
    {
        return strtoupper($string);
    }

    #[McpPrompt(name: 'strToUpper')]
    public function getStrToUpperPrompt(): array
    {
        return [
            ['role' => 'user', 'content' => 'Funkcja strToUpper zamienia wszystkie litery w podanym ciągu znaków na wielkie litery.'],
        ];
    }
}
