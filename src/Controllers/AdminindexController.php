<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Setting\Enum\TypeEnum;
use VitesseCms\Setting\Factory\SettingFactory;
use VitesseCms\Twitter\Enums\SettingEnum;
use VitesseCms\Twitter\Forms\oAuthForm;

class AdminindexController extends AbstractAdminController
{
    public function onConstruct()
    {
        parent::onConstruct();
    }

    public function indexAction(): void
    {
        $form = null;

        if(
            !$this->setting->has(SettingEnum::TWITTER_CONSUMER_KEY,false)
            || !$this->setting->has(SettingEnum::TWITTER_CONSUMER_SECRET,false)
            || !$this->setting->has(SettingEnum::TWITTER_OAUTH_TOKEN,false)
            || !$this->setting->has(SettingEnum::TWITTER_OAUTH_TOKENSECRET,false)
        ):
            $form = (new oAuthForm())->buildForm()->renderForm('admin/twitter/adminindex/parseadminindexform');
        endif;

        $this->view->setVar('content', $this->view->renderTemplate(
            'adminIndex',
            $this->configuration->getVendorNameDir() . 'twitter/src/Resources/views/admin/',
            [
                'form' => $form,
                'settingsLink' => 'admin/setting/adminsetting/adminList?filter[name.nl]=twitter',
                'tweetsLink' => 'admin/twitter/admintweet/adminList'
            ]
        ));

        $this->prepareView();
    }

    public function parseadminindexformAction(): void
    {
        if($this->request->has(SettingEnum::TWITTER_CONSUMER_KEY)) :
            SettingFactory::create(
                SettingEnum::TWITTER_CONSUMER_KEY,
                TypeEnum::TEXT,
                $this->request->get(SettingEnum::TWITTER_CONSUMER_KEY),
                '',
                true
            )->save();
        endif;

        if($this->request->has(SettingEnum::TWITTER_CONSUMER_SECRET)) :
            SettingFactory::create(
                SettingEnum::TWITTER_CONSUMER_SECRET,
                TypeEnum::TEXT,
                $this->request->get(SettingEnum::TWITTER_CONSUMER_SECRET),
                '',
                true
            )->save();
        endif;

        if($this->request->has(SettingEnum::TWITTER_OAUTH_TOKEN)) :
            SettingFactory::create(
                SettingEnum::TWITTER_OAUTH_TOKEN,
                TypeEnum::TEXT,
                $this->request->get(SettingEnum::TWITTER_OAUTH_TOKEN),
                '',
                true
            )->save();
        endif;

        if($this->request->has(SettingEnum::TWITTER_OAUTH_TOKENSECRET)) :
            SettingFactory::create(
                SettingEnum::TWITTER_OAUTH_TOKENSECRET,
                TypeEnum::TEXT,
                $this->request->get(SettingEnum::TWITTER_OAUTH_TOKENSECRET),
                '',
                true
            )->save();
        endif;

        $this->flash->setSucces('%ADMIN_SETTINGS_CREATED%');

        $this->redirect('admin/twitter/adminindex/index');
    }
}
