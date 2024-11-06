<?php 
namespace App\Model;

use Nette;

final class PostFacade{
    public function __construct(
        private Nette\Database\Explorer $database,
    ){
    }

    public function getPublicPage(){
        return $this
        ->database->table("page");
        // ->where('created_at < ', new \DateTime)
        // ->order('created_at DESC');
    }
}