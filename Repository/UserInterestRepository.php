<?php

namespace Opositatest\InterestUserBundle\Repository;
use Opositatest\InterestUserBundle\Entity\Interest;
use Opositatest\InterestUserBundle\Model\UserInterface;

class UserInterestRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneByUserAndInterest(Interest $interest, $user) {
        $interestRepository = $this->findOneBy(['interestId' => $interest, 'userinterfaceId' => $user]);
        return $interestRepository;
    }

}
