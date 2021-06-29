<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Forms;

use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Twitter\Enums\SettingEnum;

class oAuthForm extends AbstractFormWithRepository
{
    public function buildForm(): FormWithRepositoryInterface
    {
        if(!$this->setting->has(SettingEnum::TWITTER_CONSUMER_KEY,false)):
            $this->addText(
                '%TWITTER_CONSUMER_KEY%',
                SettingEnum::TWITTER_CONSUMER_KEY,
                (new Attributes())->setRequired()
            );
        endif;

        if(!$this->setting->has(SettingEnum::TWITTER_CONSUMER_SECRET, false)):
            $this->addText(
                '%TWITTER_CONSUMER_SECRET%',
                SettingEnum::TWITTER_CONSUMER_SECRET,
                (new Attributes())->setRequired()
            );
        endif;

        if(!$this->setting->has(SettingEnum::TWITTER_OAUTH_TOKEN, false)):
            $this->addText(
                '%TWITTER_OAUTH_TOKEN%',
                SettingEnum::TWITTER_OAUTH_TOKEN,
                (new Attributes())->setRequired()
            );
        endif;

        if(!$this->setting->has(SettingEnum::TWITTER_OAUTH_TOKENSECRET, false)):
            $this->addText(
                '%TWITTER_OAUTH_TOKENSECRET%',
                SettingEnum::TWITTER_OAUTH_TOKENSECRET,
                (new Attributes())->setRequired()
            );
        endif;

        $this->addSubmitButton('%CORE_SAVE%');

        return $this;
    }
}
