<?php

namespace App\Model\Builder;

use App\Entity\Dashboard;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManager;

class DashboardBuilder implements BuilderInterface
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function build(array $data)
    {
        $student = $this->em
            ->getRepository(Student::class)
            ->find((int)$data['student']);
            
        $teacher = $this->em
            ->getRepository(Teacher::class)
            ->find((int)$data['teacher']);
        
        $d = new Dashboard();
        $d->setStudent($student)
            ->setTeacher($teacher)
            ->setWeekDay($data['week_day'])
            ->setCourse($teacher->getCourse())
            ->setLTime(\DateTime::createFromFormat('H:i', $data['l_time']))
        ;
        
        return $d;
    }
}
