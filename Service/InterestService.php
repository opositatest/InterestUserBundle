<?php
namespace Opositatest\InterestUserBundle\Service;

class InterestService {
    const FOLLOW_INTEREST = "followInterest";
    const UNFOLLOW_INTEREST = "unfollowInterest";

    public function __construct()
    {

    }

    public function addInterestUser($interestString, $userId, $followMode = self::FOLLOW_INTEREST) {

    }

    public function removeInterestUser($interestString, $userId, $followMode = self::FOLLOW_INTEREST) {

    }
}

?>