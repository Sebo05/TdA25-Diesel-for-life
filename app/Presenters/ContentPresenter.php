<?php 

declare(strict_types=1);
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class ContentPresenter extends Nette\Application\UI\Presenter{

    public function __construct(
        private Nette\Database\Explorer $database,
    ){
    }

    protected function createComponentContentForm(): Form{
        $form = new Form;

        $form->addText('nazev', 'Nazev:')
            ->setRequired('Prosím zadejte nazev.');  

        $form->addTextArea('content1', 'Obsah:')
            ->setRequired('Prosím zadejte obsah.');

        $form->addSubmit('send','Uložit');
        $form->onSuccess[] = [$this,'contentFormSucceeded'];
    
        return $form;
    }

    public function contentFormSucceeded(Form $form, \stdClass $values): void {
        $id = $this->getParameter('id');

        if ($id) {
            $content = $this->database->table('content')->get($id);

            if (!$content) {
                $this->error('Obsah nebyl nalezen.', Nette\Http\IResponse::S404_NOT_FOUND);
                return;
            }

            $content->update([
                'nazev' => $values->nazev,
                'content1' => $values->content1,
            ]);
        } else {
            $content = $this->database->table('content')->insert([
                'nazev' => $values->nazev,
                'content1' => $values->content1,
            ]);
            $id = $content->id;
        }
        $this->flashMessage('Obsah byl vytvoren.', 'success');
        $this->redirect('admin:admin');
    }

    public function renderEdit(int $id): void { 
        $content = $this->database->table('content')->get($id);
        if (!$content) {
            $this->error('Obsah nebyl nalezen.');
            return;
        }
        $this['contentForm']->setDefaults($content->toArray());
    }

    public function renderContent(int $id): void{
        $content = $this->database->table('content')->get('id');

        if(!$content){
            $this->error('Obsah nebyl nalezen');
        }
        $this->template->content = $content;
    }
}
