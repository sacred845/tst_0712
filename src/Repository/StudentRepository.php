<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    public function getList(): ?array
    {
        $res = null;
        
        $data = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from('\App\Entity\Student', 'p')
            ->orderBy('p.second_name', 'ASC')
            ->getQuery()
            ->getResult();
    
        if ($data) {
            $res = array_column(array_map(function($item){
                return [
                    'id' => $item->getId(),
                    'name' => sprintf('%s %s %s',
                            $item->getSecondName(),
                            $item->getFirstName(),
                            $item->getThirdName()
                        )
                ];
            }, $data), 'name', 'id');
        }
    
        return $res;
    }
}
