<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\PostFacade;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private PostFacade $postFacade,
    ){
    }

    public function renderDefault(): void{
        $this->template->pages = $this->postFacade->getPublicPage();
    }
}
