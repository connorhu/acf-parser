<?php declare(strict_types=1);

namespace ACFParserTest;

use ACFParser\Tokenizer;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    public function testStringContent()
    {
        $tokenizer = new Tokenizer();
        
        $this->assertSame($tokenizer->tokenize('"AppState"'), [
            [
                'type' => 'string',
                'content' => 'AppState',
            ],
        ]);
        
        $this->assertSame($tokenizer->tokenize('""'), [
            [
                'type' => 'string',
                'content' => '',
            ],
        ]);
            
        $this->assertSame($tokenizer->tokenize('"383522337382622915"'), [
            [
                'type' => 'string',
                'content' => '383522337382622915',
            ],
        ]);
    }
    
    public function testBrackets()
    {
        $tokenizer = new Tokenizer();
        
        $this->assertSame($tokenizer->tokenize('{}'), [
            [
                'type' => 'bracket_open',
                'content' => '{',
            ],
            [
                'type' => 'bracket_close',
                'content' => '}',
            ],
        ]);
        
        $content = '"AppState"
{
}
';
        
        $this->assertSame($tokenizer->tokenize($content), [
            [
                'type' => 'string',
                'content' => 'AppState',
            ],
            [
                'type' => 'whitespace',
                'content' => "\n",
            ],
            [
                'type' => 'bracket_open',
                'content' => '{',
            ],
            [
                'type' => 'whitespace',
                'content' => "\n",
            ],
            [
                'type' => 'bracket_close',
                'content' => '}',
            ],
            [
                'type' => 'whitespace',
                'content' => "\n",
            ],
        ]);
    }
    
    public function testRestoredContent()
    {
        $tokenizer = new Tokenizer();
        $buffer = '';
        foreach ($tokenizer->tokenize($content = file_get_contents(__DIR__.'/appmanifest.acf')) as $token) {
            if ($token['type'] === 'string') {
                $buffer .= '"'.$token['content'].'"';
            }
            else {
                $buffer .= $token['content'];
            }
        }
        
        $this->assertSame($buffer, $content);
    }
}