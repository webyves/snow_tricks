<?php
namespace Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\TrickComment;
use App\Entity\Users;
use App\Entity\Tricks;


class TrickCommentTest extends TestCase
{
	public function testEntity() {
		$comment = new TrickComment();
		$comment->setText('ABC')
				->setDateCreate(new \Datetime)
				->setUserCreate(new Users)
				->setTrick(new Tricks);

		$this->assertEquals('ABC', $comment->getText());
		$this->assertInstanceOf(\Datetime::class, $comment->getDateCreate());
		$this->assertInstanceOf(Users::class, $comment->getUserCreate());
		$this->assertInstanceOf(Tricks::class, $comment->getTrick());
	}
}
