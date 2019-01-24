<?php
namespace Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Tricks;


class TricksTest extends TestCase
{
	public function testSlug() {
		$trick = new Tricks();
		$trick->setName('Oùlà Houp !');
		$trick->setSlug($trick->getName());
		$this->assertEquals('Oùlà Houp !', $trick->getName());
		$this->assertEquals('oula-houp', $trick->getSlug());
	}
}
