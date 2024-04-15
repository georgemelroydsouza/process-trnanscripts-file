<?php

namespace Georgedsouza\Transcriptions;

class Line
{
    
    public function __construct(
        public string $position, 
        public string $timestamp, 
        public string $body)
    {
        
    }
    
    public function beginningTimestamp() : string
    {
        preg_match("/^\d{2}:(\d{2}:\d{2})\.\d{3}/", $this->timestamp, $matches);
        
        return $matches[1];
    }
    
    public function toHTML() : string
    {
        
        return "<a href=\"?time={$this->beginningTimestamp()}\">{$this->body}</a>";
    }

}