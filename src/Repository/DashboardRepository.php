<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\Course;


class DashboardRepository extends EntityRepository
{
    public function isSetEntity(Course $course, int $week_day, string $l_time): bool
    {
        $item = $this->createQueryBuilder('c')
            ->andWhere('IDENTITY(c.course) = :course')
            ->andWhere('c.week_day = :week_day')
            ->andWhere('c.l_time = :l_time')
            ->setParameter('course', $course)
            ->setParameter('week_day', $week_day)
            ->setParameter('l_time', \DateTime::createFromFormat('H:i', $l_time))
            ->getQuery()
            ->getOneOrNullResult()
        ;
        
        return ($item) ? true : false;
    }
}
