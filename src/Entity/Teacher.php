<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="teachers",
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="teachers_unique", 
 *            columns={"first_name", "second_name", "third_name", "course_id"})
 *    }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository")
 */
class Teacher
{
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }
    
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
     * @ORM\ManyToOne(targetEntity=Course::class)
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    protected $course;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dashboard", mappedBy="teacher", orphanRemoval=true)
     */
    protected $events;
    
    public function getId(): int|null
    {
        return $this->id;
    }
    
    public function getFullName(): string
    {
        return sprintf('%s %s %s',
            $this->second_name,
            $this->first_name,
            $this->third_name
        );
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
    
    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;

        return $this;
    }   
    
    /**
     * @return Collection|FineAccrual[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Dashboard $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setTeacher($this);
        }

        return $this;
    }

    public function removeEvent(Dashboard $event): self
    {
        if ($this->fineAccruals->contains($event)) {
            $this->fineAccruals->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getTeacher() === $this) {
                $event->setTeacher(null);
            }
        }

        return $this;
    }
}
