<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Factories;

use VitesseCms\Twitter\Models\Tweet;

class TweetFactory {
    public static function createFromResult(int $tweetId, string $text) : Tweet
    {
        return (new Tweet())
            ->setTweetId($tweetId)
            ->setText($text)
        ;
    }
}