<?php

use PHPUnit\Framework\TestCase;
use Mfonte\ImdbScraper\Parser;

class ParserTest extends TestCase
{
    public function test_unwrapFormattedNumber()
    {
        $parser = new Parser;

        $this->assertEquals("1500000", $parser->unwrapFormattedNumber("1.5M"));
        $this->assertEquals("1200", $parser->unwrapFormattedNumber("1.2K"));
        $this->assertEquals("1.8", $parser->unwrapFormattedNumber("1.8"));
        // $this->assertEquals($expected, $actual);
    }
}
