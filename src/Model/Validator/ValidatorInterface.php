<?php 

namespace App\Model\Validator;

interface ValidatorInterface
{
    public function isValid(mixed $data): bool;
    
    public function getErrors(): ?array;
}
