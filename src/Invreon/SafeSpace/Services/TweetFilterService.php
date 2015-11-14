<?php
namespace Invreon\SafeSpace\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class TweetFilterService
{
    /**
     * Sends a request to twitter for tweets, and filters out negative ones
     * @param $searchString string
     * @param $connection TwitterOAuth
     * @return array
     */
    public function searchAndFilterTweets($searchString, $connection)
    {
        $recentTweets = $connection->get("search/tweets", array(
                "q" => "@" . $searchString
            )
        );

        $parsedTweets = $this->parseSearchResults($recentTweets->statuses);

        return $this->grabPositiveTweets($parsedTweets, $searchString);
    }

    /**
     * Turns array of $tweet search objects to an array of text
     * @param $tweets
     * @return array
     */
    private function parseSearchResults($tweets)
    {
        $textArray = [];

        $size = count($tweets);

        for ($i = 0; $i < $size; $i++) {
            array_push($textArray, $tweets[$i]->text);
        }

        return $textArray;
    }

    /**
     * Filters an array of texts by removing the search string and using
     * the sentiment analysis service
     * @param $username
     * @param $tweetArray
     * @return array
     */
    private function grabPositiveTweets($tweetArray, $username)
    {
        $sentimentService = new SentimentAnalysisService();

        $positiveTweets = [];
        foreach ($tweetArray as $tweet) {
            $tweet = urldecode($tweet);
            // replace username that was in search
            $pureText = str_replace('@' . $username, "", $tweet);
            if ($sentimentService->isPositiveText($pureText)) {
                array_push($positiveTweets, $tweet);
            }
        }

        return $positiveTweets;
    }
}
