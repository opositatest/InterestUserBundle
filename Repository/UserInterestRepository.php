<?php

namespace Opositatest\InterestUserBundle\Repository;
use Opositatest\InterestUserBundle\Entity\Interest;

class UserInterestRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneByUserAndInterest(Interest $interest, $user) {
        $interestRepository = $this->findOneBy(['interest' => $interest, 'user' => $user]);
        return $interestRepository;
    }
}
