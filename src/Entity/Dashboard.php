<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dashboard",
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="teachers_unique", 
 *            columns={"week_day", "l_time", "course_id"})
 *    }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DashboardRepository")
 */
class Dashboard
{
    const WEEK_DAYS = [
        self::WEEK_DAY_MO => 'Понедельник',
        self::WEEK_DAY_TU => 'Вторник',
        self::WEEK_DAY_WE => 'Среда',
        self::WEEK_DAY_TH => 'Четверг',
        self::WEEK_DAY_FR => 'Пятница',
        self::WEEK_DAY_SU => 'Суббота',
        self::WEEK_DAY_SO => 'Воскресенье',
    ];
    
    const WEEK_DAY_MO = '1';
    const WEEK_DAY_TU = '2';
    const WEEK_DAY_WE = '3';
    const WEEK_DAY_TH = '4';
    const WEEK_DAY_FR = '5';
    const WEEK_DAY_SU = '6';
    const WEEK_DAY_SO = '7';    
    
    const START_TIME_STR = '09:00';
    const END_TIME_STR = '18:00';
    const L_DELAY = '1 Hour';
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $week_day;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class)
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    protected $student;
    
    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class)
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
     */
    protected $teacher;    

    /**
     * @ORM\ManyToOne(targetEntity=Course::class)
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    protected $course;

    /**
     * @ORM\Column(type="time")
     */
    protected $l_time;

    public function getId(): int|null
    {
        return $this->id;
    }
    
    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;

        return $this;
    }
    
    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): self
    {
        $this->teacher = $teacher;

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
    
    public function getWeekDay(): int
    {
        return $this->week_day;
    }

    public function setWeekDay(int $week_day): self
    {
        $this->week_day = $week_day;

        return $this;
    }
    
    public function getLTime(): ?\DateTimeInterface
    {
        return $this->l_time;
    }

    public function setLTime(\DateTimeInterface $l_time): self
    {
        $this->l_time = $l_time;

        return $this;
    }
}
