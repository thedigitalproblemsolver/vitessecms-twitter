<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners;

use VitesseCms\Communication\Fields\SocialShare;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Twitter\Listeners\Fields\SocialShareListener;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach(SocialShare::class, new SocialShareListener());
    }
}
