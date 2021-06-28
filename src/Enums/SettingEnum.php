<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Enums;

use VitesseCms\Core\AbstractEnum;

class SettingEnum extends AbstractEnum
{
    public const TWITTER_CONSUMER_KEY = 'TWITTER_CONSUMER_KEY';
    public const TWITTER_CONSUMER_SECRET = 'TWITTER_CONSUMER_SECRET';
    public const TWITTER_OAUTH_TOKEN = 'TWITTER_OAUTH_TOKEN';
    public const TWITTER_OAUTH_TOKENSECRET = 'TWITTER_OAUTH_TOKENSECRET';
}