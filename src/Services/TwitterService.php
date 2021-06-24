<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    /**
     * @var TwitterOAuth
     */
    private $twitterOauth;

    public function __construct(TwitterOAuth $twitterOAuth)
    {
        $this->twitterOauth = $twitterOAuth;
    }

    /**
    * @return array|object
    */
    public function tweet(string $tweet)
    {
        return $this->twitterOauth->post("statuses/update",
            ["status" => $tweet]
        );
    }
}