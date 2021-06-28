<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Twitter\Forms\TweetForm;
use VitesseCms\Twitter\Models\Tweet;

class AdmintweetController extends AbstractAdminController
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Tweet::class;
        $this->classForm = TweetForm::class;
    }
}
