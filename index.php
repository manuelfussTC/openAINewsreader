<?php

error_reporting(E_ERROR | E_PARSE);
//https://github.com/serpwow/google-search-results-php#simple-example

require_once('classes/NewsReader.php');
require_once('classes/ChatGPT.php');


//YOUR SerpWow API KEY HERE!!!
$serpwow = new GoogleSearchResults("YOUR SerpWow API KEY HERE. You get it here: https://app.serpwow.com/");

// What should I look for?
const TOPIC = "artificial intelligence";
// Which language do you prefer? Hint: In the prompt in the end, everything is translated to german.
const LANGUAGE = "en";
// How many pages to receive from the news search?
const INDEX = 10;


// SerpWow Params
$params = [
    "q" => TOPIC,
    "search_type" => "news",
    "engine" => "google",
    "show_duplicates" => "false",
    "sort_by" => "date",
    "time_period" => "last_day",
    "hl" => LANGUAGE,
    "num" => INDEX
];


$result = $serpwow->json($params);
$newsResults = $result->news_results;

$newsResultLinks = [];
foreach ($newsResults as $newsResult => $newsResultVal) {
    $newsResultTemp = [];
    $newsResultTemp['title'] = $newsResultVal->title;
    $newsResultTemp['link'] = $newsResultVal->link;
    $newsResultTemp['source'] = $newsResultVal->source;
    $newsResultTemp['snippet'] = $newsResultVal->snippet;
    $newsResultLinks[] = $newsResultTemp;
}


$chatGPT = new ChatGPT();
$combineTexts = '';
foreach ($newsResultLinks as $newsResultLink => $newsResultLinkVal) {
    $url = $newsResultLinkVal['link'];
    $source = $newsResultLinkVal['source'];
    $newsReader = new NewsReader();
    $newsResult = $newsReader->readNewsByUrl($url);
    $numberTokens = 2500 / INDEX;
    $numberCutText = 2500 - $numberTokens;
    if ($newsResult) {
        echo "<h2 style='color: green;'>Quelle: " . $source . "</h2>";
        echo "<h3 style='color: green;'>Link: <a href='$url'>" . $url . "</a></h3>";
        $articleClean = strip_tags(utf8_encode($newsResult));
        $articleClean = str_replace(' ', '', $articleClean);
        $articleClean = substr($articleClean,0,$numberCutText);
        $newsResultSummarized = $chatGPT->summarizeArticles($articleClean, TOPIC);
        $newsResultSummarized = str_replace('Stichwort', '<br/><br/>Stichwort', $newsResultSummarized);
        $newsResultSummarized = str_replace('Stichwörter', '<br/><br/>Stichwörter', $newsResultSummarized);
        $newsResultSummarized = str_replace('Schlüsselwörter', '<br/><br/>Schlüsselwörter', $newsResultSummarized);
        $newsResultSummarized = str_replace('Keywords', '<br/><br/>Keywords', $newsResultSummarized);
        echo "<h4 style='color: green;'>Text: <p style='color: black; font-weight: normal'>" . $newsResultSummarized . "</p></h4>";
        echo "<br/>";
        echo "------------------------------------------------------------------------------------------";
        echo "<br/>";
    }
}
