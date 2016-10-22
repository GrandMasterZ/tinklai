<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Problems")
 */
class Problem
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
    private $hardware_name;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     */
    private $state;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time_taken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time_fixed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time_created;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="problems")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param mixed $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
    public function getHardwareName()
    {
        return $this->hardware_name;
    }

    public function gethardware_name()
    {
        return $this->hardware_name;
    }

    /**
     * @param mixed $hardware_name
     */
    public function setHardwareName($hardware_name)
    {
        $this->hardware_name = $hardware_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getTimeTaken()
    {
        return $this->time_taken;
    }

    /**
     * @param mixed $time_taken
     */
    public function setTimeTaken($time_taken)
    {
        $this->time_taken = $time_taken;
    }

    /**
     * @return mixed
     */
    public function getTimeFixed()
    {
        return $this->time_fixed;
    }

    /**
     * @param mixed $time_fixed
     */
    public function setTimeFixed($time_fixed)
    {
        $this->time_fixed = $time_fixed;
    }


}