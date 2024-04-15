<?php

namespace Tests;

use Georgedsouza\Transcriptions\Line;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Georgedsouza\Transcriptions\Transcription;

#[CoversClass(Transcription::class)]
class TranscriptionTest extends TestCase
{
    protected Transcription $transcription;

    protected function setUp(): void
    {
        parent::setUp();
        $file = __DIR__ . '/stubs/basic-example.vtt';
        
        $this->transcription = Transcription::load($file);
    }
    
    
    
    public function test_it_loads_a_vtt_file_as_a_string() : void
    {
        
        $this->assertStringContainsString('Here is a', $this->transcription);
        
    }
    
    public function test_it_can_convert_to_an_array_of_line_obects()
    {

        $lines = $this->transcription->lines();
        
        $this->assertCount(2, $lines);
        
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
        
    }
    
    function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
       
        $this->assertStringNotContainsString('WEBVTT', $this->transcription);
        $this->assertCount(2, $this->transcription->lines());
        
    }
    
    function test_it_renders_the_lines_as_html()
    {
        
        $expected = <<<EOT
        <a href="?time=00:03">Here is a</a>
        <a href="?time=00:04">example of a VTT file</a>
        EOT;
        
        $this->assertEquals($expected, $this->transcription->lines()->asHTML());
        
    }
}