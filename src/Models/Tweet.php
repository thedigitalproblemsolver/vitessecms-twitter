<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Models;

use VitesseCms\Database\AbstractCollection;

class Tweet extends AbstractCollection
{
    /**
     * @var int
     */
    public $tweetId;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $itemId;

    /**
     * @var string
     */
    public $tweetUrl;

    public function setTweetId(int $tweetId): Tweet
    {
        $this->tweetId = $tweetId;

        return $this;
    }

    public function setText(string $text): Tweet
    {
        $this->text = $text;

        return $this;
    }

    public function setItemId(string $itemId): Tweet
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getTweetId(): int
    {
        return $this->tweetId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getTweetUrl(): string
    {
        return $this->tweetUrl;
    }

    public function setTweetUrl(string $tweetUrl): Tweet
    {
        $this->tweetUrl = $tweetUrl;

        return $this;
    }
}