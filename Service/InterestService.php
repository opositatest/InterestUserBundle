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

    public function postInterestUser(Interest $interest, $user, $followMode = self::FOLLOW_INTEREST, $flush = false) {
        $done = false;

        if ($followMode == null) {
            $followMode = self::FOLLOW_INTEREST;
        }
        if ($followMode == self::FOLLOW_INTEREST) {
            if (!$interest->existFollowUser($user)) {
                $interest->addFollowUser($user);
                $done = true;
            }
        } else {
            if (!$interest->existUnfollowUser($user)) {
                $interest->addUnfollowUser($user);
                $done = true;
            }
        }
        $this->em->persist($interest);
        if ($flush) {
            $this->em->flush();
        }

        return $done;
    }

    public function deleteInterestUser(Interest $interest, $user, $followMode = self::FOLLOW_INTEREST, $flush = false) {
        $done = false;

        if ($followMode == null) {
            $followMode = self::FOLLOW_INTEREST;
        }
        if ($followMode == self::FOLLOW_INTEREST) {
            if ($interest->existFollowUser($user)) {
                $done = $interest->removeFollowUser($user);
            }
        } else {
            if ($interest->existUnfollowUser($user)) {
                $done = $interest->removeUnfollowUser($user);
            }
        }
        $this->em->persist($interest);
        if ($flush) {
            $this->em->flush();
        }

        return $done;
    }

    public function getInterests() {
        /** @var InterestRepository $repositoryInterest */
        $repositoryInterest = $this->em->getRepository("OpositatestInterestUserBundle:Interest");
        return $repositoryInterest->findAll();
    }
}

?>