<?php

namespace Opositatest\InterestUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
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
    private $interestId;

    /**
     * @Groups({"interestUserView"})
     * @ORM\ManyToOne(targetEntity="\Opositatest\InterestUserBundle\Model\UserInterface", inversedBy="unfollowInterests")
     * @ORM\JoinColumn(name="userinterface_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $userinterfaceId;

    public function __construct()
    {
        $this->setCreatedAt( new \DateTime());
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
    public function getInterestId()
    {
        return $this->interestId;
    }

    /**
     * @param mixed $interestId
     */
    public function setInterestId($interestId)
    {
        $this->interestId = $interestId;
    }

    /**
     * @return mixed
     */
    public function getUserinterfaceId()
    {
        return $this->userinterfaceId;
    }

    /**
     * @param mixed $userinterfaceId
     */
    public function setUserinterfaceId($userinterfaceId)
    {
        $this->userinterfaceId = $userinterfaceId;
    }


}