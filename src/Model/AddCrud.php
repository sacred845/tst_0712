<?php 

namespace App\Model;

use Doctrine\ORM\EntityManager;
use App\Model\Validator\ValidatorInterface;
use App\Model\Builder\BuilderInterface;

class AddCrud implements CrudInterface
{
    private $em;
    private $validator;
    private $builder;    
    private $data;    
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function setBuilder(BuilderInterface $builder): CrudInterface
    {
        $this->builder = $builder;
        
        return $this;        
    }
    
    public function setValidator(ValidatorInterface $validator): CrudInterface
    {
        $this->validator = $validator;
        
        return $this;
    }
    
    public function setData(mixed $data): CrudInterface
    {
        $this->data = $data;
        
        return $this;        
    }
    
    public function process(): ?array
    {
        if ($this->validator->isValid($this->data)) {
            $entity = $this->builder->build($this->data);
            $this->em->getConnection()->beginTransaction();
            try {
                $this->em->persist($entity);
                $this->em->flush();
                $this->em->getConnection()->commit();
                return null;
            } catch (\Exception $e) {
                $this->em->getConnection()->rollback();
                return ['При сохранении произошла ошибка'];
            }
        } else {
            return $this->validator->getErrors();
        }
    }
}