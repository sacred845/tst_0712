<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class TeacherRepository extends EntityRepository
{
    public function getList(): ?array
    {
        $res = null;
        
        $data = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('p', 'course')
            ->from('\App\Entity\Teacher', 'p')
            ->innerJoin('p.course', 'course')   
            ->addOrderBy('course.name', 'ASC')            
            ->addOrderBy('p.second_name', 'ASC')
            ->getQuery()
            ->getResult();
    
        if ($data) {
            $res = array_column(array_map(function($item){
                return [
                    'id' => $item->getId(),
                    'name' => sprintf('%s (%s %s %s)',
                            $item->getCourse()->getName(),
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
