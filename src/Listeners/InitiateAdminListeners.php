<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners;

use Abraham\TwitterOAuth\TwitterOAuth;
use VitesseCms\Communication\Fields\SocialShare;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Twitter\Listeners\Admin\AdminMenuListener;
use VitesseCms\Twitter\Enums\SettingEnum;
use VitesseCms\Twitter\Listeners\Fields\SocialShareListener;
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
                new TwitterService(new TwitterOAuth(
                    $di->setting->get(SettingEnum::TWITTER_CONSUMER_KEY),
                    $di->setting->get(SettingEnum::TWITTER_CONSUMER_SECRET),
                    $di->setting->get(SettingEnum::TWITTER_OAUTH_TOKEN),
                    $di->setting->get(SettingEnum::TWITTER_OAUTH_TOKENSECRET)
                )),
                $di->url
            ));
        endif;
    }
}
