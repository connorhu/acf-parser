<?php

namespace ACFParser;

class Tokenizer
{
    const IN_STRING_STATE = 1;
    const STRING_END_STATE = 2;
    const WHITESPACE_STATE = 3;
    const WHITESPACE_END_STATE = 4;
    const BRACKET_OPEN_STATE = 5;
    const BRACKET_CLOSE_STATE = 6;
    
    public function tokenize(string $content): iterable
    {
        $contentSize = strlen($content);
        $state = self::WHITESPACE_STATE;
        
        $buffer = '';
        $tokenBuffer = [];
        for ($pointer = 0; $pointer < $contentSize; ) {
            
            if ($state === self::IN_STRING_STATE && $content[$pointer] === '"') {
                $state = self::STRING_END_STATE;
            }
            elseif ($state === self::WHITESPACE_STATE && $content[$pointer] === '"') {
                $state = self::WHITESPACE_END_STATE;
            }
            elseif ($state === self::WHITESPACE_STATE && $content[$pointer] === '{') {
                $state = self::WHITESPACE_END_STATE;
            }
            elseif ($state === self::WHITESPACE_STATE && $content[$pointer] === '}') {
                $state = self::WHITESPACE_END_STATE;
            }
            
            if ($state === self::STRING_END_STATE) {
                $tokenBuffer[] = [
                    'type' => 'string',
                    'content' => $buffer,
                ];
                $buffer = '';
                
                if (!isset($content[$pointer+1])) {
                    break;
                }
                
                if ($content[$pointer+1] !== '{' && $content[$pointer+1] !== '}' && $content[$pointer+1] !== '"') {
                    $state = self::WHITESPACE_STATE;
                }
                
                $pointer++;
                continue;
            }
            
            if ($state === self::WHITESPACE_END_STATE) {
                if (strlen($buffer) !== 0) {
                    $tokenBuffer[] = [
                        'type' => 'whitespace',
                        'content' => $buffer,
                    ];
                    $buffer = '';
                }
                
                if ($content[$pointer] === '"') {
                    $state = self::IN_STRING_STATE;
                    $pointer++;
                    continue;
                }

                if ($content[$pointer] === '{') {
                    $state = self::BRACKET_OPEN_STATE;
                }

                if ($content[$pointer] === '}') {
                    $state = self::BRACKET_CLOSE_STATE;
                }
            }
            
            if ($state === self::BRACKET_OPEN_STATE) {
                $tokenBuffer[] = [
                    'type' => 'bracket_open',
                    'content' => '{',
                ];
                $buffer = '';
                
                if (!isset($content[$pointer+1])) {
                    break;
                }
                
                if ($content[$pointer+1] !== '{' && $content[$pointer+1] !== '}' && $content[$pointer+1] !== '"') {
                    $state = self::WHITESPACE_STATE;
                }
                elseif ($content[$pointer+1] === '}') {
                    $state = self::BRACKET_CLOSE_STATE;
                }

                $pointer++;
                continue;
            }
            
            if ($state === self::BRACKET_CLOSE_STATE) {
                $tokenBuffer[] = [
                    'type' => 'bracket_close',
                    'content' => '}',
                ];
                $buffer = '';
                
                if (!isset($content[$pointer+1])) {
                    break;
                }
                
                if ($content[$pointer+1] !== '{' && $content[$pointer+1] !== '}' && $content[$pointer+1] !== '"') {
                    $state = self::WHITESPACE_STATE;
                }

                $pointer++;
                continue;
            }
            
            if ($state === self::IN_STRING_STATE || $state === self::WHITESPACE_STATE) {
                $buffer .= $content[$pointer];
                $pointer++;
                continue;
            }
        }
        
        if (strlen($buffer) > 0) {
            $tokenBuffer[] = [
                'type' => 'whitespace',
                'content' => $buffer,
            ];
        }
        
        return $tokenBuffer;
    }
}