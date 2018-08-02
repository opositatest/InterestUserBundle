<?php
namespace Opositatest\InterestUserBundle\Tests\Service;

use Doctrine\Common\Collections\Collection;
use Opositatest\InterestUserBundle\Entity\Interest;
use Opositatest\InterestUserBundle\Service\InterestService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InterestServiceTest extends WebTestCase
{
    private $container;
    /** @var InterestService $interestService */
    private $interestService;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->container = static::$kernel->getContainer();
        $this->interestService = $this->container->get('interestUser.interest');
    }

    public function testgetInterestUser()
    {
        $interests = $this->interestService->getInterests();
        $this->assertInternalType('array', $interests);


    }

    public function testPostInterestErrorUserNull()
    {
        $interest = new Interest();
        $interest->setName("hello");
        $return = $this->interestService->postInterestUser($interest, null, InterestService::FOLLOW_INTEREST, true);
        $this->assertEquals($return, false);
    }

    public function testDeleteInterestErrorUserNull()
    {
        $interest = new Interest();
        $interest->setName("hello");
        $return = $this->interestService->deleteInterestUser($interest, null, InterestService::FOLLOW_INTEREST, true);
        $this->assertEquals($return, false);
    }
}