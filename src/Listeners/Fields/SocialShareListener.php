<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners\Fields;

use Phalcon\Events\Event;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Services\FlashService;
use VitesseCms\Core\Services\UrlService;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Datafield\Models\Datafield;
use VitesseCms\Form\Interfaces\AbstractFormInterface;
use VitesseCms\Twitter\Enums\TwitterEnum;
use VitesseCms\Twitter\Repositories\TweetRepository;
use VitesseCms\Twitter\Services\TwitterService;

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

    /**
     * @var TweetRepository
     */
    private $tweetRepository;

    public function __construct(
        TwitterService $twitterService,
        UrlService $urlService,
        FlashService $flashService,
        TweetRepository $tweetRepository
    ){
        $this->twitter = $twitterService;
        $this->url = $urlService;
        $this->flash = $flashService;
        $this->tweetRepository = $tweetRepository;
    }

    public function buildItemFormElement(Event $event, AbstractFormInterface $form, AbstractCollection $data = null): void
    {
        if ($data === null || !$data->has(TwitterEnum::TWEET_ID)) :
            $form->addToggle('%TWITTER_SHARE_ITEM%', TwitterEnum::SHARE_ITEM);
        else :
            $tweet = $this->tweetRepository->getById((string)$data->_(TwitterEnum::TWEET_ID));
            if($tweet !== null) :
                $form->addHtml('<a class="btn btn-info" href="'.$tweet->getTweetUrl().'" target="_blank" >
                    %TWITTER_VIEW_TWEET%
                    &nbsp;<i class="fa fa-external-link" aria-hidden="true"></i>
                </a>');
            else :
                $form->addHtml('%TWITTER_TWEET_NOT_FOUND%');
            endif;
        endif;
    }

    public function beforeItemSave(Event $event, Item $item, Datafield $datafield): void
    {
        if ($item->getBool(TwitterEnum::SHARE_ITEM) && !$item->has(TwitterEnum::TWEET_ID)) :
            $text = '';
            if ($item->has('introtext')):
                $text = $item->_('introtext');
            endif;

            if (empty(trim($text)) && $item->has('bodytext')):
                $text = $item->_('bodytext');
            endif;

            $text = $item->getNameField().' : '.trim($text);
            $textChunks = str_split($text, 200);
            if(count($textChunks) > 1 ):
                $textChunks[0] .= '...';
            endif;

            $tweet = $this->twitter->tweet($textChunks[0] . '  ' . $this->url->getBaseUri() . $item->getSlug());
            if ($tweet !== null) :
                $tweet->setItemId((string)$item->getId());
                $tweet->setPublished(true);
                $tweet->set('name',$tweet->getText());
                $tweet->save();

                $item->set(TwitterEnum::TWEET_ID, $tweet->getId());
                $this->flash->setSucces('%TWITTER_TWEET_SENT%');
            else :
                $this->flash->setError('%TWITTER_TWEET_NOTSENT%');
            endif;
        endif;

        $item->set(TwitterEnum::SHARE_ITEM, null);
    }
}