<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Forms;

use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Twitter\Models\Tweet;

class TweetForm extends AbstractForm
{
    /**
     * @var Tweet
     */
    protected $_entity;

    public function buildForm(): TweetForm
    {
        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired()->setReadonly());
        $this->addText('%CORE_TEXT%', 'text', (new Attributes())->setRequired()->setReadonly());
        $this->addHtml('<a class="btn btn-info" href="'.$this->_entity->getTweetUrl().'" target="_blank" >
            %TWITTER_VIEW_TWEET%
            &nbsp;<i class="fa fa-external-link" aria-hidden="true"></i>
        </a>');

        return $this;
    }
}