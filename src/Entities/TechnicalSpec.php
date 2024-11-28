<?php

namespace Mfonte\ImdbScraper\Entities;

/**
 * Class TechnicalSpec
 * Represents a technical specification of a title.
 */
class TechnicalSpec extends Entity
{
    /**
     * @var string The name of the technical specification (e.g., "Runtime")
     */
    protected string $name;

    /**
     * @var string The value of the technical specification (e.g., "2h 30m")
     */
    protected string $value;
}
