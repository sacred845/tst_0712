<?php 

namespace App\Model\Validator;

use App\Entity\Dashboard;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManager;

class DashboardValidator implements ValidatorInterface
{
    private $em;
    private $data;
    private $errors;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function isValid(mixed $data): bool
    {
        $student = $this->em
            ->getRepository(Student::class)
            ->find((int)$data['student']);
            
        $teacher = $this->em
            ->getRepository(Teacher::class)
            ->find((int)$data['teacher']);
            
        if (!$teacher) {
            $this->errors[] = 'Выбран некорректный предмет или учитель';
        }
        if (!$student) {
            $this->errors[] = 'Выбран некорректный ученик';
        }
        if (!in_array($data['week_day'], array_keys(Dashboard::WEEK_DAYS))) {
            $this->errors[] = 'Выбран некорректный день недели';
        }
        if (!in_array($data['l_time'], array_map(function($item){return $item->format('H:i');}, $data['time_list']))) {
            $this->errors[] = 'Выбрано некорректное время';
        }
        
        if ($this->em->getRepository(Dashboard::class)->isSetEntity($teacher->getCourse(),
                    $data['week_day'], $data['l_time']))
        {
            $this->errors[] = 'Это время занято. Выберите другое время или день.';
        }
        
        return (empty($this->errors)) ? true : false;
    }    
    
    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
