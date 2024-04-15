<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Georgedsouza\Transcriptions\Transcription;

#[CoversClass(Transcription::class)]
class TranscriptionTest extends TestCase
{

    public function test_it_loads_a_vtt_file_as_a_string() : void
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $transcription = Transcription::load($file);
        
        $this->assertStringContainsString('Here is a', $transcription);
    }
    
    public function test_it_can_convert_to_an_array_of_lines()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $this->assertCount(4, Transcription::load($file)->lines());
        
    }
    
    function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $transcription = Transcription::load($file);
       
        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(4, $transcription->lines());
        
    }
}