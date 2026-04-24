{if $subchapters}
	<h2>{t}Subchapters{/t}</h2>
	<ul class="table-of-contents list-unstyled">
		{foreach $subchapters as $subchapter}
			<li><h4>{$subchapter->getNo()} {a action=detail id=$subchapter}{$subchapter->getTitle()|h}{/a}</h4></li>
		{/foreach}
	</ul>
{/if}
