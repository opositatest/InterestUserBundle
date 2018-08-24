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
    public function addFollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $followInterest) {
        $followInterest->addFollowUser($this);
        $this->followInterests[] = $followInterest;
        foreach($followInterest->getChildren() as $child) {
            if (!$this->existFollowInterest($child)) {
                $this->addFollowInterest($child);
            }
        }
        return $this;
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $followInterest
     */
    public function removeFollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $followInterest) {
        $followInterest->removeFollowUser($this);
        $this->followInterests->removeElement($followInterest);
        foreach($followInterest->getChildren() as $child) {
            if ($this->existFollowInterest($child)) {
                $this->removeFollowInterest($child);
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
    public function addUnfollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest) {
        $unfollowInterest->addUnfollowUser($this);
        $this->unfollowInterests[] = $unfollowInterest;
        foreach($unfollowInterest->getChildren() as $child) {
            if (!$this->exitUnfollowInterest($child)) {
                $this->addUnfollowInterest($child);
            }
        }
        return $this;
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest
     */
    public function removeUnfollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest) {
        $unfollowInterest->removeUnfollowUser($this);
        $this->unfollowInterests->removeElement($unfollowInterest);
        foreach($unfollowInterest->getChildren() as $child) {
            if ($this->exitUnfollowInterest($child)) {
                $this->removeUnfollowInterest($child);
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
    public function exitUnfollowInterest(Interest $unfollowInterest) {
        return in_array($unfollowInterest, $this->getUnfollowInterests()->toArray(), TRUE);
    }
}
?>