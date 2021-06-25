<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners\Fields;

use Phalcon\Events\Event;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Services\FlashService;
use VitesseCms\Core\Services\UrlService;
use VitesseCms\Datafield\Models\Datafield;
use VitesseCms\Form\Interfaces\AbstractFormInterface;
use VitesseCms\Twitter\Enums\TwitterEnum;
use VitesseCms\Twitter\Services\TwitterService;

// https://smarttutorials.net/sign-in-with-twitter-oauth-api-using-php/

class SocialShareListener
{
    /**
     * @var TwitterService
     */
    private $twitter;

    /**
     * @var UrlService
     */
    private $url;

    /**
     * @var FlashService
     */
    private $flash;

    public function __construct(TwitterService $twitterService, UrlService $urlService, FlashService $flashService)
    {
        $this->twitter = $twitterService;
        $this->url = $urlService;
        $this->flash = $flashService;
    }

    public function buildItemFormElement(Event $event, AbstractFormInterface $form): void
    {
        $form->addToggle('%TWITTER_SHARE_ITEM%', TwitterEnum::SHARE_ITEM);
    }

    public function beforeItemSave(Event $event, Item $item, Datafield $datafield): void
    {
        if ($item->getBool(TwitterEnum::SHARE_ITEM) && !$item->has(TwitterEnum::TWEET_ID)) :
            $tweet = $this->twitter->tweet($item->getNameField() . ' ' . $this->url->getBaseUri() . $item->getSlug());
            if ($tweet !== null) :
                $tweet->setItemId((string)$item->getId());
                $tweet->setPublished(true);
                $tweet->set('name',$tweet->getText());
                $tweet->save();

                $item->set(TwitterEnum::TWEET_ID, $tweet->getTweetId());
                $this->flash->setSucces('%TWITTER_TWEET_SENT%');
            else :
                $this->flash->setError('%TWITTER_TWEET_NOTSENT%');
            endif;
        endif;

        $item->set(TwitterEnum::SHARE_ITEM, null);
    }
}