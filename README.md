# PHP IMDB API

## Install

Install the latest version using [composer](https://getcomposer.org/).

```bash
composer require mfonte/imdb-scraper
```

## Usage

```php
// Assuming you installed from Composer:
require "vendor/autoload.php";
use Mfonte\ImdbScraper\Imdb;

$imdb = new Imdb;

// Search imdb
// -> returns array of films and people found
$imdb->search("Apocalypse");

// Get film data
// -> returns array of film data (title, year, rating...)
$imdb->film("tt0816692");
```

### Options

| Name            | Type   | Default Value          | Description                                                                                      |
| --------------- | ------ | ---------------------- | ------------------------------------------------------------------------------------------------ |
| `cache`         | bool   | `true`                 | Caches film data to speed-up future requests for the same film                                   |
| `locale`        | string | `it`                   | An ISO 639-1 locale string that will be used for Imdb scraping in the preferred language         |
| `seasons`       | bool   | `false`                | Whether to fetch the seasons of a TV show or not (only works with TV shows)                      |
| `guzzleHeaders` | ?array | `null`                 | An array of headers to be sent with the Guzzle requests                                          |
| `guzzleLogFile` | string | `null`                 | Path to a file where Guzzle will log all requests and responses                                  |

```php
$imdb = new Imdb;

//  Options are passed as an array as the second argument
//  These are the default options
$imdb->film("tt0816692", [
    'locale'  => 'it',
    'cache'   => true,
    'seasons' => true,
]);

$imdb->search("Interstellar", [
    'locale'       => 'en',
]);
```

### Best Match

If you do not know the imdb-id of a film, a search string can be entered. This will search imdb and use the first result as the film to fetch data for.

> Note that this will take longer than just entering the ID as it needs to first search imdb before it can get the film data.

```php
// Searches imdb and gets the film data of the first result
// -> will return the film data for 'Apocalypse Now'
$imdb->film("Apocalypse");
```

## Features

### Film Data

```
- Title
- Genres
- Year
- Length
- Plot
- Rating
- Rating Votes (# of votes)
- Poster
- Trailer
    - id
    - link
- Cast
    - actor name
    - actor id
    - character
    - avatar
    - avatar_hq (high quality avatar)
- Technical Specs
```

### Search

Search IMDB to return an array of films, people and companies

```
- Films
    - id
    - title
    - image
- People
    - id
    - name
    - image
- Companies
    - id
    - name
    - image
```

