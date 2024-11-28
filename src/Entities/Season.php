<?php
namespace Mfonte\ImdbScraper\Entities;

/**
 * Class Season
 * Represents a season of a TV show.
 */
class Season extends Entity
{
    /**
     * @var int The season number
     */
    protected int $number;

    /**
     * @var Dataset<Episode> The episodes in the season
     */
    protected Dataset $episodes;

    public function __construct()
    {
        $this->episodes = new Dataset;
    }

    /**
     * Add an episode to the season.
     *
     * @param Episode $episode
     *
     * @return void
     */
    public function addEpisode(Episode $episode): void
    {
        $this->episodes->put("s{$this->number}e{$episode->episode}", $episode);
    }
}
