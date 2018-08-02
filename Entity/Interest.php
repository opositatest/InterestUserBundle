<?php
namespace Opositatest\InterestUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Opositatest\InterestUserBundle\Model\UserInterface;
use Opositatest\InterestUserBundle\Model\UserTrait;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Opositatest\InterestUserBundle\Repository\InterestRepository")
 * @ORM\Table(name="opositatest_interestuser_interest")
 */
class Interest {
    /**
     * @Groups({"interestUserView"})
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Groups({"interestUserView"})
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="\Opositatest\InterestUserBundle\Model\UserInterface", inversedBy="followInterests")
     * @ORM\JoinTable(name="opositatest_interestuser_followUsers_followInterests")
     */
    private $followUsers;

    /**
     * @ORM\ManyToMany(targetEntity="\Opositatest\InterestUserBundle\Model\UserInterface", inversedBy="unfollowInterests")
     * @ORM\JoinTable(name="opositatest_interestuser_unfollowUsers_unfollowInterests")
     */
    private $unfollowUsers;

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->followUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unfollowUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add followUser.
     *
     * @param \Opositatest\InterestUserBundle\Model\UserInterface $followUser
     *
     * @return Interest
     */
    public function addFollowUser($followUser)
    {
        /** @var UserTrait $followUser */
        $followUser->addFollowInterest($this);
        $this->followUsers[] = $followUser;

        return $this;
    }

    /**
     * Remove followUser.
     *
     * @param \Opositatest\InterestUserBundle\Model\UserInterface $followUser
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFollowUser($followUser)
    {
        /** @var UserTrait $followUser */
        $followUser->removeFollowInterest($this);
        return $this->followUsers->removeElement($followUser);
    }

    /**
     * Get followUsers.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowUsers()
    {
        return $this->followUsers;
    }

    /**
     * Exists followUser?
     *
     * @param $followUser
     * @return bool
     */
    public function existFollowUser($followUser) {
        return in_array($followUser, $this->getFollowUsers()->toArray(), TRUE);
    }

    /**
     * Add unfollowUser.
     *
     * @param \Opositatest\InterestUserBundle\Model\UserInterface $unfollowUser
     *
     * @return Interest
     */
    public function addUnfollowUser($unfollowUser)
    {
        /** @var UserTrait $followUser */
        $this->unfollowUsers[] = $unfollowUser;

        return $this;
    }

    /**
     * Remove unfollowUser.
     *
     * @param \Opositatest\InterestUserBundle\Model\UserInterface $unfollowUser
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUnfollowUser($unfollowUser)
    {
        /** @var UserTrait $followUser */
        return $this->unfollowUsers->removeElement($unfollowUser);
    }

    /**
     * Get unfollowUsers.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnfollowUsers()
    {
        return $this->unfollowUsers;
    }

    /**
     * Exists unfollowUser?
     *
     * @param $unfollowUser
     * @return bool
     */
    public function existUnfollowUser($unfollowUser)
    {
        return in_array($unfollowUser, $this->getUnfollowUsers()->toArray(), TRUE);
    }
    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Interest
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
