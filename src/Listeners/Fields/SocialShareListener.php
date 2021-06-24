<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners\Fields;

use Phalcon\Events\Event;
use VitesseCms\Content\Models\Item;
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

    public function __construct(TwitterService $twitterService, UrlService $urlService)
    {
        $this->twitter = $twitterService;
        $this->url = $urlService;
    }

    public function buildItemFormElement(Event $event, AbstractFormInterface $form): void
    {
        $form->addToggle('%TWITTER_SHARE_ITEM%', TwitterEnum::SHARE_ITEM);
    }

    public function beforeItemSave(Event $event, Item $item, Datafield $datafield): void
    {
        if ($item->getBool(TwitterEnum::SHARE_ITEM)) :
            $this->twitter->tweet($item->getNameField() . ' ' . $this->url->getBaseUri() . $item->getSlug());
            $item->set(TwitterEnum::SHARE_ITEM, null);
        endif;
    }
}