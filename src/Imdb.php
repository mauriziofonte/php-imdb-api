<?php
namespace Mfonte\ImdbScraper;

use Mfonte\ImdbScraper\Entities\Dataset;
use Mfonte\ImdbScraper\Entities\SearchResult;
use Mfonte\ImdbScraper\Entities\Title;

/**
* Class Imdb
*
* @package mfonte/imdb-scraper
* @author Harry Merritt
* @author Maurizio Fonte
*/
class Imdb
{
    /**
     * Returns default options extended with any user options
     *
     * @param array $options
     * @return array $defaults
     */
    private function extendOpts(array $options = []): array
    {
        //  Default options
        $defaults = [
            'cache'         => false,
            'locale'        => 'en',
            'seasons'       => false,
            'guzzleLogFile' => null
        ];

        //  Merge any user options with the default ones
        foreach ($options as $key => $option) {
            $defaults[$key] = $option;
        }

        //  Return final options array
        return $defaults;
    }

    /**
     * Gets film data from IMDB.
     *
     * Both compatible with titles (search keyword) and film ids in the form of 'tt1234567'.
     *
     * @param string $idOrKeyword
     * @param array  $options - user options (locale, cache, seasons)
     * @return array
     */
    public function film(string $idOrKeyword, array $options = []): array
    {
        //  Combine user options with default ones
        $options = $this->extendOpts($options);

        $cache = new Cache;

        // Check for 'tt' at start of $filmId
        if (substr($idOrKeyword, 0, 2) === "tt") {
            $imdbId = $idOrKeyword;
        } else {
            $searchResults = $this->search($idOrKeyword, $options);

            if ($searchResults->count() === 0) {
                //  No film found
                return Title::newFromArray([]);
            }

            // Get first search result
            $imdbId = $searchResults->first()->id;
        }

        // early return from cache, if the cache is enabled
        if ($options["cache"]) {
            //  Check cache for film
            if ($cache->has($imdbId)) {
                return $cache->get($imdbId);
            }
        }

        // run the parser against this IMDB ID
        $parser = Parser::parse($imdbId, $options);
        $arrayProps = $parser->getProperties();

        // set the parsed representation, if the cache is enabled
        if ($options["cache"]) {
            //  Add result to the cache
            $cache->add($imdbId, $arrayProps);
        }

        //  Return the response $store
        return $arrayProps;
    }

    /**
     * Searches IMDB for films, people and companies
     * @param string $search
     * @param array  $options
     * @return Dataset<SearchResult>
     */
    public function search(string $search, array $options = []): Dataset
    {
        //  Combine user options with default ones
        $options = $this->extendOpts($options);

        // fetch the search page in json format
        $dom = new Dom;
        $keyword = urlencode(urldecode($search));
        $page = $dom->raw("https://v3.sg.media-imdb.com/suggestion/x/{$keyword}.json?includeVideos=0", $options);

        // try to json-decode the textContent of the page
        $searchData = @json_decode($page, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($searchData) || !array_key_exists('d', $searchData)) {
            return Dataset::new([]);
        }

        return Dataset::new(array_map(function ($item) {
            return SearchResult::newFromArray([
                'id' => $item['id'],
                'title' => $item['l'],
                'image' => $item['i']['imageUrl'] ?? null,
                'year' => $item['y'] ?? null,
                'type' => $item['q'] ?? null,
                'category' => $item['qid'],
                'starring' => $item['s'] ?? null,
                'rank' => $item['rank'] ?? null,
            ]);
        }, $searchData['d']));
    }

    // https://www.imdb.com/_next/data/pM_RU9ZlkqF1_JziHhCvL/en-US/title/tt0898266/episodes.json?season=2&tconst=tt0898266

}
