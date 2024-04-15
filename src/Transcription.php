<?php

namespace Georgedsouza\Transcriptions;

class Transcription
{
    
    public function __construct(protected array $lines)
    {
        $this->lines = $this->discard_invalid_lines(array_map('trim', $lines));
    }
    
    public static function load(string $path) : self
    {
        
        return new static(file($path));
        
    }
    
    public function lines() : array
    {
        $lines = [];
        
        for ($i = 0; $i < count($this->lines); $i += 2)
        {
            $lines[] = new Line($this->lines[$i], $this->lines[$i+1]);
        }
        
        return $lines;
    }
    
    public function htmlLines() : string
    {
        $html_lines = array_map(function (Line $line) {
            
            return $line->toAnchorTag();
            
        }, $this->lines());
        
        return implode("\n", $html_lines);
    }
    
    public function __toString(): string
    {
        return implode("", $this->lines);
    }
    
    protected function discard_invalid_lines(array $lines) : array
    {
        return array_values(array_filter($lines, function ($line) {
            return Line::valid($line);
        }));
    }
    
}