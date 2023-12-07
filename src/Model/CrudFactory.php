<?php

namespace App\Model;

use Doctrine\ORM\EntityManager;

class CrudFactory
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getAddCrud(): CrudInterface
    {
        return new AddCrud($this->em);
    }
}
