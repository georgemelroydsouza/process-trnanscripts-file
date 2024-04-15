<?php

namespace Georgedsouza\Transcriptions;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class Lines implements Countable, IteratorAggregate
{
    public function __construct(protected array $lines)
    {
        
    }

    public function asHTML() : string
    {
        $formattedLines = array_map(function (Line $line) {
            
            return $line->toHtml();
            
        }, $this->lines);
        
        return (new static($formattedLines))->__toString();
    }
    
    public function count() : int
    {
        return count($this->lines);
    }
    
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->lines);
    }
    
    public function __toString()
    {
        return implode("\n", $this->lines);
    }
    
}