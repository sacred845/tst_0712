<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $first_name;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $second_name;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $third_name;
    
    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $email;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;
        
        return $this;
    }
    
    public function getSecondName(): string
    {
        return $this->second_name;
    }

    public function setSecondName(string $second_name): self
    {
        $this->second_name = $second_name;
        
        return $this;
    }
    
    public function getThirdName(): string
    {
        return $this->third_name;
    }

    public function setThirdName(string $third_name): self
    {
        $this->third_name = $third_name;
        
        return $this;
    }
    
    public function getFullName(): string
    {
        return sprintf('%s %s %s',
            $this->second_name,
            $this->first_name,
            $this->third_name
        );
    }
}
