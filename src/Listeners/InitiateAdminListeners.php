<?php
declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners;

use Abraham\TwitterOAuth\TwitterOAuth;
use VitesseCms\Communication\Fields\SocialShare;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Twitter\Enums\SettingEnum;
use VitesseCms\Twitter\Listeners\Admin\AdminMenuListener;
use VitesseCms\Twitter\Listeners\Fields\SocialShareListener;
use VitesseCms\Twitter\Listeners\Models\TweetListener;
use VitesseCms\Twitter\Models\Tweet;
use VitesseCms\Twitter\Repositories\TweetRepository;
use VitesseCms\Twitter\Services\TwitterService;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        if (
            $injectable->setting->has(SettingEnum::TWITTER_CONSUMER_KEY)
            && $injectable->setting->has(SettingEnum::TWITTER_CONSUMER_SECRET)
        ) :
            $injectable->eventsManager->attach(
                SocialShare::class,
                new SocialShareListener(
                    new TwitterService(
                        new TwitterOAuth(
                            $injectable->setting->getString(SettingEnum::TWITTER_CONSUMER_KEY),
                            $injectable->setting->getString(SettingEnum::TWITTER_CONSUMER_SECRET),
                            $injectable->setting->getString(SettingEnum::TWITTER_OAUTH_TOKEN),
                            $injectable->setting->getString(SettingEnum::TWITTER_OAUTH_TOKENSECRET)
                        ),
                        $injectable->log
                    ),
                    $injectable->url,
                    $injectable->flash,
                    new TweetRepository()
                )
            );
        endif;
        $injectable->eventsManager->attach(
            Tweet::class,
            new TweetListener(
                new ItemRepository()
            )
        );
    }
}
