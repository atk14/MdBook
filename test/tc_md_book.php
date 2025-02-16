<?php
class TcMdBook extends TcBase {

	function test(){
		$book = new MdBook(__DIR__ . "/sample_book/");

		$this->assertEquals("Sample Book",$book->getTitle());
		$this->assertStringContains(trim('
<h1>Sample Book</h1>

<p>This is Sample Book written in Markdown.</p>

<h2>Introduction</h2>

<p>Lorem ipsum dolor sit amet
		'),$book->getContent());

		$chapters = $book->getChapters();
		$this->assertEquals(2,sizeof($chapters));

		$this->assertEquals("chapter-1",$chapters[0]->getId());
		$this->assertEquals("Chapter 1",$chapters[0]->getTitle());
		$this->assertStringContains(trim('
<h1>Chapter 1</h1>

<p>Lorem ipsum dolor sit amet
		'),$chapters[0]->getContent());

		$next_chapter = $chapters[0]->getNextChapter();
		$this->assertNotNull($next_chapter);
		$this->assertEquals("Subchapter 1",$next_chapter->getTitle());
		$this->assertStringContains(trim('
<h1>Subchapter 1</h1>

<p>Morbi ac turpis tellus
		'),$next_chapter->getContent());
		$this->assertEquals("chapter-1:subchapter-1",$next_chapter->getId());

		$next_chapter2 = $next_chapter->getNextChapter();
		$this->assertNotNull($next_chapter2);
		$this->assertEquals("Subchapter 2",$next_chapter2->getTitle());
		$this->assertStringContains(trim('
<h1>Subchapter 2</h1>

<p>Duis tellus nulla, auctor vel arcu non
		'),$next_chapter2->getContent());
		$this->assertEquals("chapter-1:subchapter-2",$next_chapter2->getId());

		$next_chapter3 = $next_chapter2->getNextChapter();
		$this->assertNotNull($next_chapter3);
		$this->assertEquals("chapter-2",$next_chapter3->getId());

		$this->assertEquals("chapter-2",$chapters[1]->getId());
		$this->assertEquals("Chapter 2",$chapters[1]->getTitle());
		$this->assertStringContains(trim('
<h1>Chapter 2</h1>

<p>Lorem ipsum dolor sit amet
		'),$chapters[1]->getContent());
		$this->assertEquals(null,$chapters[1]->getNextChapter());
	}
}
