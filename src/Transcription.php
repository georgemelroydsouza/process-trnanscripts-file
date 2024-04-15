<?php

namespace Georgedsouza\Transcriptions;

class Transcription
{
    
    public function __construct(protected array $lines)
    {
        $this->lines = $this->discard_invalid_lines($lines);
    }
    
    public static function load(string $path) : self
    {
        
        return new static(file($path));
        
    }
    
    public function lines() : Lines
    {

        return new Lines(array_map(function ($line) {
            
            return new Line(...$line);
            
        }, array_chunk($this->lines, 3)));

    }
    

    
    public function __toString(): string
    {
        return implode("", $this->lines);
    }
    
    protected function discard_invalid_lines(array $lines) : array
    {
        return array_slice(array_filter(array_map('trim', $lines)), 1);
    }
    
}