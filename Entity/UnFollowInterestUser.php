<?php

namespace Opositatest\InterestUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Opositatest\InterestUserBundle\Repository\UserInterestRepository")
 * @ORM\Table(name="opositatest_interestuser_unfollowUsers_unfollowInterests")
 */
class UnFollowInterestUser
{
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Groups({"interestUserView"})
     * @ORM\ManyToOne(targetEntity="\Opositatest\InterestUserBundle\Entity\Interest", inversedBy="unfollowUsers")
     * @ORM\JoinColumn(name="interest_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $interest;

    /**
     * @Groups({"interestUserView"})
     * @ORM\ManyToOne(targetEntity="\Opositatest\InterestUserBundle\Model\UserInterface", inversedBy="unfollowInterests")
     * @ORM\JoinColumn(name="userinterface_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    public function __construct()
    {
        $this->setCreatedAt( new \DateTime());
        $this->setUpdatedAt( new \DateTime());
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
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @param mixed $interest
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}