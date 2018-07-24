<?php
namespace Opositatest\InterestUserBundle\Service;

class InterestService {
    const FOLLOW_INTEREST = "followInterest";
    const UNFOLLOW_INTEREST = "unfollowInterest";

    public function __construct()
    {

    }

    public function addInterestUser($interestString, $userId, $mode = self::FOLLOW_INTEREST) {

    }

    public function removeInterestUser($interestString, $userId, $mode = self::FOLLOW_INTEREST) {

    }
}

?>