<?php

namespace Georgedsouza\Transcriptions;

class Transcription
{
    
    protected array $lines;
    
    public static function load(string $path) : self
    {
        $instance = new static();
        
        $instance->lines = $instance->discard_irrelevant_lines(file($path));
        
        return $instance;
        
    }
    
    public function lines() : array
    {
        return $this->lines;
    }
    
    public function __toString(): string
    {
        return implode("", $this->lines);
    }
    
    protected function discard_irrelevant_lines(array $lines) : array
    {
        $lines = array_map('trim', $lines);
        
        return array_values(array_filter($lines, function ($line) {
            return $line !== 'WEBVTT' && $line !== "" && (!is_numeric($line));
        }));
    }
    
}