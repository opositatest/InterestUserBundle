<?php
namespace Opositatest\InterestUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Opositatest\InterestUserBundle\Model\UserTrait;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Opositatest\InterestUserBundle\Repository\InterestRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\ManyToOne(targetEntity="Interest", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @Groups({"interestUserView"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Interest", mappedBy="parent")
     */
    private $children;

    /**
     * @Groups({"interestUserView"})
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="\Opositatest\InterestUserBundle\Entity\FollowInterestUser", mappedBy="interest")
     */
    private $followUsers;

    /**
     * @ORM\OneToMany(targetEntity="\Opositatest\InterestUserBundle\Entity\UnFollowInterestUser", mappedBy="interest")
     */
    private $unfollowUsers;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

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
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->followUsers[] = $followUser;

        return $this;
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
     * Remove followUser.
     *
     * @param \Opositatest\InterestUserBundle\Entity\FollowInterestUser $followUser
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFollowUser($followUser)
    {
        /** @var UserTrait $followUser */
        return $this->followUsers->removeElement($followUser);
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
     * @param \Opositatest\InterestUserBundle\Entity\UnFollowInterestUser $unfollowUser
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

    /**
     * Set parent.
     *
     * @param \Opositatest\InterestUserBundle\Entity\Interest|null $parent
     *
     * @return Interest
     */
    public function setParent(\Opositatest\InterestUserBundle\Entity\Interest $parent = null)
    {
        if ($parent != null) {
            if ($parent->getId() == $this->getId()) {
                return $this;
            }
        }
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \Opositatest\InterestUserBundle\Entity\Interest|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child.
     *
     * @param \Opositatest\InterestUserBundle\Entity\Interest $child
     *
     * @return Interest
     */
    public function addChild(\Opositatest\InterestUserBundle\Entity\Interest $child)
    {
        // Not add child for self
        if ($child->getId() == $this->getId()) {
            return $this;
        }
        $this->children[] = $child;
        $child->setParent($this);

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \Opositatest\InterestUserBundle\Entity\Interest $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\Opositatest\InterestUserBundle\Entity\Interest $child)
    {
        $child->setParent(null);
        return $this->children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
