<?php

namespace Mfonte\ImdbScraper\Entities;

/**
 * Class Title
 * Represents detailed information about a title.
 */
class Title extends Entity
{
    /**
     * @var string Unique IMDb ID (e.g., "tt1234567")
     */
    protected string $id;

    /**
     * @var string The title of the movie or TV show
     */
    protected string $title;

    /**
     * @var array List of genres
     */
    protected array $genres = [];

    /**
     * @var int|null The release year
     */
    protected ?int $year = null;

    /**
     * @var string|null The length of the title (e.g., "2h 15m")
     */
    protected ?string $length = null;

    /**
     * @var string|null The plot summary
     */
    protected ?string $plot = null;

    /**
     * @var float|null The IMDb rating
     */
    protected ?float $rating = null;

    /**
     * @var int|null The number of votes
     */
    protected ?int $ratingVotes = null;

    /**
     * @var array|null Aggregate rating information
     */
    protected ?array $ratingAggregate = null;

    /**
     * @var string|null The poster URL
     */
    protected ?string $poster = null;

    /**
     * @var array|null Trailer information
     */
    protected ?array $trailer = null;

    /**
     * @var bool|null Indicates if this is a TV show
     */
    protected ?bool $tvShow = null;

    /**
     * @var array List of cast members
     */
    protected array $cast = [];

    /**
     * @var array List of seasons
     */
    protected array $seasons = [];

    /**
     * @var array List of technical specifications
     */
    protected array $technicalSpecs = [];
}
