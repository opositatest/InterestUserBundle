<?php
namespace Opositatest\InterestUserBundle\Tests\Model;

use Opositatest\InterestUserBundle\Entity\Interest;
use PHPUnit\Framework\TestCase;

class InterestTest extends TestCase
{
    public function testName()
    {
        $interest = $this->getInterest();
        $interest->setName("interes");
        $this->assertSame("interes", $interest->getName());
    }

    public function testFollow()
    {
        $interest = $this->getInterest();
        $this->assertEquals(0, count($interest->getFollowUsers()->toArray()));
    }

    public function testUnfollow()
    {
        $interest = $this->getInterest();
        $this->assertEquals(0, count($interest->getUnfollowUsers()->toArray()));
    }

    /**
     * @return Interest
     */
    protected function getInterest()
    {
        return $this->getMockForAbstractClass('Opositatest\InterestUserBundle\Entity\Interest');
    }
}