<?php

namespace Opositatest\InterestUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="opositatest_interestuser_unfollowUsers_unfollowInterests")
 */
class UnFollowInterestUser
{
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="interest_id")
     */
    private $interestId;

    /**
     * @ORM\Column(type="integer", name="userinterface_id")
     */
    private $userinterfaceId;

}