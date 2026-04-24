{if $subchapters}
	<h2>{t}Subchapters{/t}</h2>
	<ul class="nav flex-column nav--toc nav--subchapters">
		{foreach $subchapters as $subchapter}
			<li class="nav-item">{a action=detail id=$subchapter _class="nav-link"}<span class="chapter-no">{$subchapter->getNo()}</span> {$subchapter->getTitle()|h}{/a}</li>
		{/foreach}
	</ul>
{/if}
