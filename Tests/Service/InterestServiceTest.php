<?php

declare(strict_types=1);

namespace Opositatest\InterestUserBundle\Tests\Service;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Opositatest\InterestUserBundle\Entity\Interest;
use Opositatest\InterestUserBundle\Repository\InterestRepository;
use Opositatest\InterestUserBundle\Service\InterestService;
use PHPUnit\Framework\TestCase;

class InterestServiceTest extends TestCase
{
    private $container;
    /** @var InterestService $interestService */
    private $interestService;
    /**
     * {@inheritDoc}
     */
    private $interestRepository;

    protected function setUp(): void
    {
        $em = $this->createMock(EntityManager::class);
        $this->interestService = new InterestService($em);
        $this->interestRepository = $this->createMock(InterestRepository::class);


        $em->expects($this->any())
            ->method('getRepository')
            ->with("OpositatestInterestUserBundle:Interest")
            ->willReturn($this->interestRepository);
    }

    public function testgetInterestUser(): void
    {
        $this->interestRepository->expects($this->any())
            ->method('findAll')
            ->willReturn([]);
        
        $interests = $this->interestService->getInterests();
        $this->assertIsArray($interests);
    }

    public function testPostInterestErrorUserNull(): void
    {
        $interest = new Interest();
        $interest->setName("hello");
        $return = $this->interestService->postInterestUser($interest, null, InterestService::FOLLOW_INTEREST, true);
        $this->assertEquals($return, false);
    }

    public function testDeleteInterestErrorUserNull(): void
    {
        $interest = new Interest();
        $interest->setName("hello");
        $return = $this->interestService->deleteInterestUser($interest, null, InterestService::FOLLOW_INTEREST, true);
        $this->assertEquals($return, false);
    }
}