<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners\Fields;

use Phalcon\Events\Event;
use VitesseCms\Form\Interfaces\AbstractFormInterface;

class SocialShareListener
{
    public function buildItemFormElement(Event $event, AbstractFormInterface $form): void
    {
        var_dump('in SocialShareListener');
        die();
    }
}