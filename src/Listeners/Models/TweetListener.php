<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners\Models;

use Phalcon\Events\Event;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Twitter\Enums\TwitterEnum;

class TweetListener
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function beforeDelete(Event $event, AbstractCollection $tweet): void
    {
        $item = $this->itemRepository->findFirst(
            new FindValueIterator([new FindValue(TwitterEnum::TWEET_ID, $tweet->getId())])
        );

        if ($item !== null) :
            $item->set(TwitterEnum::TWEET_ID, null)->save();
        endif;
    }
}