<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use VitesseCms\Log\Services\LogService;
use VitesseCms\Twitter\Factories\TweetFactory;
use VitesseCms\Twitter\Models\Tweet;

class TwitterService
{
    /**
     * @var TwitterOAuth
     */
    private $twitterOauth;

    /**
     * @var LogService
     */
    private $log;

    public function __construct(TwitterOAuth $twitterOAuth, LogService $logService)
    {
        $this->twitterOauth = $twitterOAuth;
        $this->log = $logService;
    }

    public function tweet(string $tweet): ?Tweet
    {
        $result = $this->twitterOauth->post('statuses/update', ['status' => $tweet]);

        if(isset($result->errors) && count($result->errors) > 0) :
            $this->log->message('%TWITTER_TWEET_NOTSENT% : ' . $result->errors[0]->message);

            return null;
        endif;

        return TweetFactory::createFromResult(
            $result->id,
            $result->text,
            'https://twitter.com/'.$result->user->name.'/status/'.$result->id
        );
    }
}