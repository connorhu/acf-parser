<?php

namespace ACFParser;

class Parser
{
    public function __construct()
    {
        $this->tokenizer = new Tokenizer();
    }
    
    public function parse(string $content): iterable
    {
        $tokens = $this->tokenizer->tokenize($content);
        
        $pointer = 0;
        return $this->parseTokens($tokens, $pointer);
    }
    
    protected function parseTokens(array $tokens, int &$pointer): iterable
    {
        $tokensLength = count($tokens);
        
        $buffer = [];
        for ($i = &$pointer; $i < $tokensLength; ) {
            if ($tokens[$i]['type'] === 'whitespace') {
                ++$i;
                continue;
            }
            
            if ($tokens[$i]['type'] === 'bracket_close') {
                $i++;
                break;
            }

            if ($tokens[$i]['type'] === 'string' && $tokens[$i+1]['content'] === "\t\t" && $tokens[$i+2]['type'] === 'string') {
                // key value
                $buffer[$tokens[$i]['content']] = $tokens[$i+2]['content'];
                
                $i += 3;
                continue;
            }

            if ($tokens[$i]['type'] === 'string' && $tokens[$i+2]['type'] === 'bracket_open') {
                // key value
                $key = $tokens[$i]['content'];
                
                $i += 3;

                $buffer[$key] = $this->parseTokens($tokens, $i);
                
                continue;
            }
            
            ++$i;
        }
        
        return $buffer;
    }
}