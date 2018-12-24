<?php
namespace Opositatest\InterestUserBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opositatest\InterestUserBundle\Entity\FollowInterestUser;
use Opositatest\InterestUserBundle\Entity\Interest;
use Opositatest\InterestUserBundle\Entity\UnFollowInterestUser;
use Symfony\Component\Serializer\Annotation\Groups;

trait UserTrait
{
    /**
     * @Groups({"interestUserView"})
     * @ORM\OneToMany(targetEntity="\Opositatest\InterestUserBundle\Entity\FollowInterestUser", mappedBy="user", cascade={"persist"})
     */
    private $followInterests;

    /**
     * @Groups({"interestUserView"})
     * @ORM\OneToMany(targetEntity="\Opositatest\InterestUserBundle\Entity\UnFollowInterestUser", mappedBy="user", cascade={"persist"})
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

        $followInterestUser = $this->interestToInterestUser($followInterest, new FollowInterestUser());

        $followInterest->addFollowUser($followInterestUser);
        $this->followInterests[] = $followInterestUser;

        if ($includeChildren) {
            foreach($followInterest->getChildren() as $child) {
                if (!$this->existFollowInterest($child)) {
                    $this->addFollowInterest($child, $includeChildren);
                }
            }
        }
        return $this;
    }

    /**
     * @param $followInterestUser
     * @return void
     */
    public function removeFollowInterest($followInterestUser) {
        $this->followInterests->removeElement($followInterestUser);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFollowInterests() {
        $interests = new ArrayCollection();
        /** @var FollowInterestUser $followedinterest */
        foreach ($this->followInterests as $followedinterest) {
            $interests->add($followedinterest->getInterest());
        }
        return $interests;
    }

    /**
     * @param \Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest
     * @return $this
     */
    public function addUnfollowInterest(\Opositatest\InterestUserBundle\Entity\Interest $unfollowInterest, $includeChildren = true) {
        $unfollowInterestUser = $this->interestToInterestUser($unfollowInterest, new UnFollowInterestUser());
        $unfollowInterest->addUnfollowUser($unfollowInterestUser);
        $this->unfollowInterests[] = $unfollowInterestUser;

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
     * @return bool
     */
    public function removeUnfollowInterest( UnFollowInterestUser $unfollowInterestUser) {
        $this->unfollowInterests->removeElement($unfollowInterestUser);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUnfollowInterests() {
        $interests = new ArrayCollection();
        /** @var FollowInterestUser $followedinterest */
        foreach ($this->unfollowInterests as $unfollowedinterest) {
            $interests->add($unfollowedinterest->getInterest());
        }
        return $interests;
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

    private function interestToInterestUser(Interest $interest, $interestUser) {
        $interestUser->setInterest($interest);
        $interestUser->setUser($this);
        return $interestUser;
    }

    /**
     * @param Interest $interest
     * @return bool
     */
    public function isLastChild($interest)
    {
        $parent = $interest->getParent();

        if (!$parent or $this->existUnfollowInterest($parent)) {
            $result = false;
        } else {
            $result = true;
            foreach ($parent->getChildren() as $child) {
                if ($child != $interest and $this->existFollowInterest($child)) {
                    $result = false;
                }
            }
        }

        return $result;

    }
}
?>