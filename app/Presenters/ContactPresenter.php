<?php 

declare(strict_types=1);

namespace App\Presenters;

use Nette;

final class ContactPresenter extends Nette\Application\UI\Presenter {
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function renderDefault(): void {
        $contact = $this->database->table('contact')->fetch();

        $this->template->contact = $contact;
    }
}
