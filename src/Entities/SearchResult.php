<?php

namespace Mfonte\ImdbScraper\Entities;

/**
 * Class SearchResult
 * Represents a search result item.
 */
class SearchResult extends Entity
{
    /**
     * @var string Unique IMDb ID (e.g., "tt1234567")
     */
    protected string $id;

    /**
     * @var string The title of the search result
     */
    protected string $title;

    /**
     * @var string|null The URL of the result image
     */
    protected ?string $image = null;

    /**
     * @var int|null The release year
     */
    protected ?int $year = null;

    /**
     * @var string|null The type of the result (e.g., "movie", "tvShow")
     */
    protected ?string $type = null;

    /**
     * @var string|null The category of the result (e.g., "feature film")
     */
    protected ?string $category = null;

    /**
     * @var string|null Starring information
     */
    protected ?string $starring = null;

    /**
     * @var int|null The rank of the result
     */
    protected ?int $rank = null;
}
