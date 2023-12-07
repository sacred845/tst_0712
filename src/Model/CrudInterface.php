<?php 

namespace App\Model;

use App\Model\Validator\ValidatorInterface;
use App\Model\Builder\BuilderInterface;

interface CrudInterface
{
    public function setValidator(ValidatorInterface $validator): CrudInterface;
    
    public function setBuilder(BuilderInterface $builder): CrudInterface;    
    
    public function setData(mixed $data): CrudInterface;
    
    public function process(): ?array;
}
