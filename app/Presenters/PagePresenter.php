<?php 

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class PagePresenter extends Nette\Application\UI\Presenter{
    public function __construct(
        private Nette\Database\Explorer $database,
    ){
    }

    public function renderShow(int $id): void{
        $page = $this->database->table('page')->get($id);

        if  (!$page){
            $this->error('Stránka nebyla nalezena');
        }

        $this->template->page = $page;
    }

}