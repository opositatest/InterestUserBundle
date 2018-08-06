<?php
namespace Opositatest\InterestUserBundle\Service;

use Doctrine\ORM\EntityManager;
use Opositatest\InterestUserBundle\Entity\Interest;
use Opositatest\InterestUserBundle\Model\UserInterface;
use Opositatest\InterestUserBundle\Model\UserTrait;
use Opositatest\InterestUserBundle\Repository\InterestRepository;

class InterestService {
    const FOLLOW_INTEREST = "followInterest";
    const UNFOLLOW_INTEREST = "unfollowInterest";

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Add Interest to User
     *
     * @param Interest $interest
     * @param $user
     * @param string $followMode - by default: "followInterest"
     * @param bool $flush
     * @return bool
     */
    public function postInterestUser(Interest $interest, $user, $followMode = self::FOLLOW_INTEREST, $flush = false) {
        $done = false;

        if ($followMode == null || ($followMode != self::FOLLOW_INTEREST && $followMode != self::UNFOLLOW_INTEREST)) {
            $followMode = self::FOLLOW_INTEREST;
        }
        if ($followMode == self::FOLLOW_INTEREST) {
            if ($user != null && !$interest->existFollowUser($user)) {
                $interest->addFollowUser($user);
                // Remove unfollowUser if exists
                if ($interest->existUnfollowUser($user)) {
                    $interest->removeUnfollowUser($user);
                }
                $done = true;
            }
        } else {
            if ($user != null && !$interest->existUnfollowUser($user)) {
                $interest->addUnfollowUser($user);
                // Remove followUser if exists
                if ($interest->existFollowUser($user)) {
                    $interest->removeFollowUser($user);
                }
                $done = true;
            }
        }

        $this->em->persist($interest);
        if ($flush) {
            $this->em->flush();
        }

        return $done;
    }

    /**
     * Remove Interest from User
     *
     * @param Interest $interest
     * @param $user
     * @param string $followMode - by default: "followInterest"
     * @param bool $flush
     * @return bool
     */
    public function deleteInterestUser(Interest $interest, $user, $followMode = self::FOLLOW_INTEREST, $flush = false) {
        $done = false;

        if ($followMode == null || ($followMode != self::FOLLOW_INTEREST && $followMode != self::UNFOLLOW_INTEREST)) {
            $followMode = self::FOLLOW_INTEREST;
        }
        if ($followMode == self::FOLLOW_INTEREST) {
            if ($user != null && $interest->existFollowUser($user)) {
                $done = $interest->removeFollowUser($user);
            }
        } else {
            if ($user != null && $interest->existUnfollowUser($user)) {
                $done = $interest->removeUnfollowUser($user);
            }
        }
        $this->em->persist($interest);
        if ($flush) {
            $this->em->flush();
        }

        return $done;
    }

    /**
     * Return all Interests
     *
     * @return array
     */
    public function getInterests() {
        /** @var InterestRepository $repositoryInterest */
        $repositoryInterest = $this->em->getRepository("OpositatestInterestUserBundle:Interest");
        return $repositoryInterest->findAll();
    }
}

?>