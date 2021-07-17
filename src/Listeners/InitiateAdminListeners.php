<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners;

use Abraham\TwitterOAuth\TwitterOAuth;
use VitesseCms\Communication\Fields\SocialShare;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Export\Repositories\ItemRepository;
use VitesseCms\Twitter\Listeners\Admin\AdminMenuListener;
use VitesseCms\Twitter\Enums\SettingEnum;
use VitesseCms\Twitter\Listeners\Fields\SocialShareListener;
use VitesseCms\Twitter\Listeners\Models\TweetListener;
use VitesseCms\Twitter\Models\Tweet;
use VitesseCms\Twitter\Repositories\TweetRepository;
use VitesseCms\Twitter\Services\TwitterService;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        if(
            $di->setting->has(SettingEnum::TWITTER_CONSUMER_KEY)
            && $di->setting->has(SettingEnum::TWITTER_CONSUMER_SECRET)
        ) :
            $di->eventsManager->attach(SocialShare::class, new SocialShareListener(
                new TwitterService(
                    new TwitterOAuth(
                        $di->setting->getString(SettingEnum::TWITTER_CONSUMER_KEY),
                        $di->setting->getString(SettingEnum::TWITTER_CONSUMER_SECRET),
                        $di->setting->getString(SettingEnum::TWITTER_OAUTH_TOKEN),
                        $di->setting->getString(SettingEnum::TWITTER_OAUTH_TOKENSECRET)
                    ),
                    $di->log
                ),
                $di->url,
                $di->flash,
                new TweetRepository()
            ));
        endif;
        $di->eventsManager->attach(Tweet::class, new TweetListener(
            new ItemRepository()
        ));
    }
}
