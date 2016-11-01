<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Reports")
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    private $cause;

    /**
     * @ORM\Column(type="string")
     */
    private $solution;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $time_created;

    /**
     * @ORM\ManyToOne(targetEntity="Problem")
     * @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     */
    private $problem;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="technician_id", referencedColumnName="id")
     */
    private $technician;

    /**
     * @return mixed
     */
    public function getTechnician()
    {
        return $this->technician;
    }

    /**
     * @param mixed $technician
     */
    public function setTechnician($technician)
    {
        $this->technician = $technician;
    }

    /**
     * @return mixed
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * @param mixed $problem
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;
    }



    /**
     * @return mixed
     */
    public function getTimeCreated()
    {
        return $this->time_created;
    }

    /**
     * @param mixed $time_created
     */
    public function setTimeCreated($time_created)
    {
        $this->time_created = $time_created;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * @param mixed $cause
     */
    public function setCause($cause)
    {
        $this->cause = $cause;
    }

    /**
     * @return mixed
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @param mixed $solution
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;
    }
}