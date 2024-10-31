<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\Responses\JsonResponse;

class ApiPresenter extends Nette\Application\UI\Presenter
{
    public function actionGetOrganization(): void
    {
        $filePath = __DIR__ . '/../data/Api.json';
        
        if (!file_exists($filePath)) {
            $this->error('Soubor nebyl nalezen.', Nette\Http\IResponse::S404_NOT_FOUND);
        }
        
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Error decoding JSON.', Nette\Http\IResponse::S500_INTERNAL_SERVER_ERROR);
        }
        
        $this->sendResponse(new JsonResponse($data));
    }
}
