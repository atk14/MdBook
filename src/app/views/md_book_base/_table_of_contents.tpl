<ul class="table-of-contents">
	{foreach $book->getChapters() as $chapter}
		<h4>{$chapter->getNo()}. {a action=detail id=$chapter}{$chapter->getTitle()}{/a}</h4>
	{/foreach}
</ul>
