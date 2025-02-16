<?php
class TcMdBook extends TcBase {

	function test(){
		$book = new MdBook(__DIR__ . "/sample_book/");

		$chapters = $book->getChapters();
		$this->assertEquals(2,sizeof($chapters));

		$this->assertEquals("chapter-1",$chapters[0]->getId());
		$this->assertEquals("Chapter 1",$chapters[0]->getTitle());
		$next_chapter = $chapters[0]->getNextChapter();
		$this->assertNotNull($next_chapter);
		$this->assertEquals("chapter-1:subchapter-1",$next_chapter->getId());
		$next_chapter2 = $next_chapter->getNextChapter();
		$this->assertNotNull($next_chapter2);
		$this->assertEquals("chapter-1:subchapter-2",$next_chapter2->getId());
		$next_chapter3 = $next_chapter2->getNextChapter();
		$this->assertNotNull($next_chapter3);
		$this->assertEquals("chapter-2",$next_chapter3->getId());

		$this->assertEquals("chapter-2",$chapters[1]->getId());
		$this->assertEquals("Chapter 2",$chapters[1]->getTitle());
		$this->assertEquals(null,$chapters[1]->getNextChapter());
	}
}
