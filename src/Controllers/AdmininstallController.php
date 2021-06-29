<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Controllers;

use VitesseCms\Install\AbstractCreatorController;
use VitesseCms\Setting\Enum\TypeEnum;
use VitesseCms\Twitter\Enums\SettingEnum;
use VitesseCms\Twitter\Forms\oAuthForm;

class AdmininstallController extends AbstractCreatorController
{
    public function createAction(): void
    {
        $this->view->setVar(
            'content',
            (new oAuthForm())->buildForm()->renderForm('admin/twitter/admininstall/parseCreateForm')
        );
        $this->prepareView();
    }

    public function parseCreateFormAction()
    {
        $settings = [];

        if (
            !$this->setting->has(SettingEnum::TWITTER_CONSUMER_KEY, false)
            && $this->request->has(SettingEnum::TWITTER_CONSUMER_KEY)
        ) :
            $settings[SettingEnum::TWITTER_CONSUMER_KEY] = [
                'type' => TypeEnum::TEXT,
                'value' => $this->request->get(SettingEnum::TWITTER_CONSUMER_KEY),
                'name' => 'Twitter %TWITTER_CONSUMER_KEY%',
            ];
        endif;

        if (
            !$this->setting->has(SettingEnum::TWITTER_CONSUMER_SECRET, false)
            && $this->request->has(SettingEnum::TWITTER_CONSUMER_SECRET)
        ) :
            $settings[SettingEnum::TWITTER_CONSUMER_SECRET] = [
                'type' => TypeEnum::TEXT,
                'value' => $this->request->get(SettingEnum::TWITTER_CONSUMER_SECRET),
                'name' => 'Twitter %TWITTER_CONSUMER_SECRET%',
            ];
        endif;

        if (
            !$this->setting->has(SettingEnum::TWITTER_OAUTH_TOKEN, false)
            && $this->request->has(SettingEnum::TWITTER_OAUTH_TOKEN)
        ) :
            $settings[SettingEnum::TWITTER_OAUTH_TOKEN] = [
                'type' => TypeEnum::TEXT,
                'value' => $this->request->get(SettingEnum::TWITTER_OAUTH_TOKEN),
                'name' => 'Twitter %TWITTER_OAUTH_TOKEN%',
            ];
        endif;

        if (
            !$this->setting->has(SettingEnum::TWITTER_OAUTH_TOKENSECRET, false)
            && $this->request->has(SettingEnum::TWITTER_OAUTH_TOKENSECRET)
        ) :
            $settings[SettingEnum::TWITTER_OAUTH_TOKENSECRET] = [
                'type' => TypeEnum::TEXT,
                'value' => $this->request->get(SettingEnum::TWITTER_OAUTH_TOKENSECRET),
                'name' => 'Twitter %TWITTER_OAUTH_TOKENSECRET%',
            ];
        endif;

        $this->createSettings($settings);

        $this->flash->setSucces('Twitter properties created');

        $this->redirect('admin/install/sitecreator/index');
    }
}