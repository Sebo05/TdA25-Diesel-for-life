<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class EditPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ){
    }

    protected function createComponentPageForm(): Form
    {
        $form = new Form;
        //tady muzes
        $form->addText('title', 'Titulek:')
            ->setRequired('Prosím zadejte titulek stránky.');

        $form->addTextArea('description', 'Popisek:')
            ->setRequired('Prosím zadejte popisek stránky.');

        $form->addTextArea('content', 'Obsah:')
            ->setRequired('Prosím zadejte obsah stránky.');
            
        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'pageFormSucceeded'];

        return $form;
    }

    public function pageFormSucceeded(Form $form, \stdClass $values): void
{
    $id = $this->getParameter('id');

    if ($id) {
        $page = $this->database->table('page')->get($id);

        if (!$page) {
            $this->error('Stránka nebyla nalezena.', Nette\Http\IResponse::S404_NOT_FOUND);
            return;
        }

        $page->update([
            'title' => $values->title,
            'description' => $values->description,
            'content' => $values->content,
        ]);
    } else {
        $page = $this->database->table('page')->insert([
            'title' => $values->title,
            'description' => $values->description,
            'content' => $values->content,
        ]);
        $id = $page->id;
    }

    $this->flashMessage('Stránka byla vytvorena.', 'success');
    $this->redirect('Page:show', ['id' => $id]);
}

    public function renderEdit(int $id): void
    {
        $page = $this->database->table('page')->get($id);
        if (!$page) {
            $this->error('Stránka nebyla nalezena.');
            return;
        }

        $this['pageForm']->setDefaults($page->toArray());
    }
}
