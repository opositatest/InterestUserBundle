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
        /** @var UserTrait $user */
        $done = false;

        if ($followMode == null || ($followMode != self::FOLLOW_INTEREST && $followMode != self::UNFOLLOW_INTEREST)) {
            $followMode = self::FOLLOW_INTEREST;
        }
        if ($followMode == self::FOLLOW_INTEREST) {
            if ($interest != null && !$user->existFollowInterest($interest)) {
                $user->addFollowInterest($interest);
                if ($user->exitUnfollowInterest($interest)) {
                    $user->removeUnfollowInterest($interest);
                }
                $done = true;
            }
        } else {
            if ($interest != null && !$user->exitUnfollowInterest($interest)) {
                $user->addUnfollowInterest($interest);
                if ($user->existFollowInterest($interest)) {
                    $user->removeFollowInterest($interest);
                }
                $done = true;
            }
        }

        $this->em->persist($user);
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
        /** @var UserTrait $user */
        $done = false;

        if ($followMode == null || ($followMode != self::FOLLOW_INTEREST && $followMode != self::UNFOLLOW_INTEREST)) {
            $followMode = self::FOLLOW_INTEREST;
        }
        if ($followMode == self::FOLLOW_INTEREST) {
            if ($interest != null && $user->existFollowInterest($interest)) {
                $done = $user->removeFollowInterest($interest);
            }
        } else {
            if ($interest != null && $user->exitUnfollowInterest($interest)) {
                $done = $user->removeUnfollowInterest($interest);
            }
        }
        $this->em->persist($user);
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