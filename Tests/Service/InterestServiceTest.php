<?php
namespace Opositatest\InterestUserBundle\Tests\Service;

use Doctrine\Common\Collections\Collection;
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

    public function testPostInterestUser()
    {
        $interests = $this->interestService->getInterests();
        $this->assertInternalType('array', $interests);
    }
}