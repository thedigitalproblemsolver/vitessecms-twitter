<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Repositories;

use VitesseCms\Twitter\Models\Tweet;

class TweetRepository
{
    public function getById(string $id, bool $hideUnpublished = true): ?Tweet
    {
        Tweet::setFindPublished($hideUnpublished);

        /** @var Tweet $tweet */
        $tweet = Tweet::findById($id);
        if ($tweet instanceof Tweet):
            return $tweet;
        endif;

        return null;
    }
}
