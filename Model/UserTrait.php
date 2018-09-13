<?php
namespace Opositatest\InterestUserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Opositatest\InterestUserBundle\Entity\Interest;
use Symfony\Component\Serializer\Annotation\Groups;

trait UserTrait
{
    /**
     * @Groups({"interestUserView"})
     * @ORM\ManyToMany(targetEntity="\Opositatest\InterestUserBundle\Entity\Interest", mappedBy="followUsers")
     */
    private $followInterests;

    /**
     * @Groups({"interestUserView"})
     * @ORM\ManyToMany(targetEntity="\Opositatest\InterestUserBundle\Entity\Interest", mappedBy="unfollowUsers")
     */
    private $unfollowInterests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->followInterests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unfollowInterests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $followInterest
     * @return $this
     */
    public function addFollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $followInterest, $includeChildren = true) {

        $followInterest->addFollowUser($this);
        $this->followInterests[] = $followInterest;
        if ($includeChildren) {
            foreach($followInterest->getChildren() as $child) {
                if (!$this->existFollowInterest($child)) {
                    $this->addFollowInterest($child, $includeChildren);
                }
            }
        }
        $parent = $followInterest->getParent();
        if ($parent and !$this->existFollowInterest($parent)) {
            $this->addFollowInterest($parent, false);
        }

        return $this;
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $followInterest
     * @return bool
     */
    public function removeFollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $followInterest, $includeChildren = true) {
        $followInterest->removeFollowUser($this);
        $this->followInterests->removeElement($followInterest);
        if ($includeChildren) {
            foreach($followInterest->getChildren() as $child) {
                if ($this->existFollowInterest($child)) {
                    $this->removeFollowInterest($child, $includeChildren);
                }
            }
        }

        return true;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFollowInterests() {
        return $this->followInterests;
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest
     * @return $this
     */
    public function addUnfollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest, $includeChildren = true) {
        $unfollowInterest->addUnfollowUser($this);
        $this->unfollowInterests[] = $unfollowInterest;
        if ($includeChildren) {
            foreach($unfollowInterest->getChildren() as $child) {
                if (!$this->existUnfollowInterest($child)) {
                    $this->addUnfollowInterest($child, $includeChildren);
                }
            }
        }
        return $this;
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest
     */
    public function removeUnfollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest, $includeChildren = true) {
        $unfollowInterest->removeUnfollowUser($this);
        $this->unfollowInterests->removeElement($unfollowInterest);
        if ($includeChildren) {
            foreach($unfollowInterest->getChildren() as $child) {
                if ($this->existUnfollowInterest($child)) {
                    $this->removeUnfollowInterest($child, $includeChildren);
                }
            }
        }
        return true;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUnfollowInterests() {
        return $this->unfollowInterests;
    }

    /**
     * Return if exists followInterest
     *
     * @param Interest $followInterest
     * @return bool
     */
    public function existFollowInterest(Interest $followInterest) {
        return in_array($followInterest, $this->getFollowInterests()->toArray(), TRUE);
    }

    /**
     * Return if exists unfollowInterest
     *
     * @param Interest $unfollowInterest
     * @return bool
     */
    public function existUnfollowInterest(Interest $unfollowInterest) {
        return in_array($unfollowInterest, $this->getUnfollowInterests()->toArray(), TRUE);
    }
}
?>