<?php

use PHPUnit\Framework\TestCase;
use Mfonte\ImdbScraper\Cache;

class CacheTest extends TestCase
{
    public function testAddToCache()
    {
        $cache = new Cache;

        $keyValueStore = [
            "title" => "Interstellar",
            "year" => 2014,
            "rating" => 8.7
        ];

        $cache->add("test", $keyValueStore);
        $cacheContent = $cache->get("test");

        $this->assertEquals($keyValueStore, $cacheContent);

        $cache->delete("test");
    }

    public function testHasCache()
    {
        $cache = new Cache;
        $cache->add("testHas", ["key" => "value"]);

        $this->assertEquals(true, $cache->has("testHas"));
        $this->assertEquals('value', $cache->get("testHas")['key']);
        
        $this->assertEquals(false, $cache->has("testHasNot"));

        $cache->delete("testHas");
    }

    public function testDeleteFromCache()
    {
        $cache = new Cache;
        $cache->add("testHas", ["key" => "value"]);

        $this->assertEquals(true, $cache->has("testHas"));
        $this->assertEquals(true, $cache->delete("testHas"));
    }
}
