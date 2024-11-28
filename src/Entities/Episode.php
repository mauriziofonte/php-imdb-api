<?php

namespace Mfonte\ImdbScraper\Entities;

/**
 * Class Episode
 * Represents an episode of a TV show.
 */
class Episode extends Entity
{
    /**
     * @var string Unique IMDb ID (e.g., "tt1234567")
     */
    protected string $id;

    /**
     * @var string|null The title of the episode
     */
    protected ?string $title = null;

    /**
     * @var string|null The description or plot of the episode
     */
    protected ?string $description = null;

    /**
     * @var float|null The aggregate rating of the episode
     */
    protected ?float $rating = null;

    /**
     * @var int|null The number of votes for the episode
     */
    protected ?int $voteCount = null;

    /**
     * @var string|null The poster URL of the episode
     */
    protected ?string $poster = null;

    /**
     * @var int|null The season number of the episode
     */
    protected ?int $season = null;

    /**
     * @var int|null The episode number within the season
     */
    protected ?int $episode = null;

    /**
     * @var string|null The release date of the episode
     */
    protected ?string $releaseDate = null;
}
