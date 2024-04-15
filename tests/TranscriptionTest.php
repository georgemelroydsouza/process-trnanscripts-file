<?php

namespace Tests;

use Georgedsouza\Transcriptions\Line;
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
    
    public function test_it_can_convert_to_an_array_of_line_obects()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $lines = Transcription::load($file)->lines();
        
        $this->assertCount(2, $lines);
        
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
        
    }
    
    function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $transcription = Transcription::load($file);
       
        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(2, $transcription->lines());
        
    }
    
    function test_it_renders_the_lines_as_html()
    {
        
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $transcription = Transcription::load($file);
        
        $expected = <<<EOT
        <a href="?time=00:03">Here is a</a>
        <a href="?time=00:04">example of a VTT file</a>
        EOT;
        
        $this->assertEquals($expected, $transcription->htmlLines());
        
    }
}