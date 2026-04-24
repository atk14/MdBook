{assign chapters $book->getChapters()}

<ul class="nav flex-column nav--toc nav--inpage">
	{foreach $chapters as $chapter}
		<li class="nav-item">
			{a action=detail id=$chapter _class="nav-link nav-link--level-1"}<span class="chapter-no">{$chapter->getNo()}.</span> {$chapter->getTitle()}{/a}
			{if $chapters|count<10} {* We don't want to be too long *}
				{if $chapter->hasSubchapters()}
					{assign subchapters $chapter->getSubchapters()}
					<ul class="nav flex-column nav--toc">
						{foreach $subchapters as $subchapter}
							<li class="nav-item">
								{a action=detail id=$subchapter _class="nav-link nav-link--level-2"}<span class="chapter-no">{$subchapter->getNo()}.</span> {$subchapter->getTitle()}{/a}
							</li>
						{/foreach}
					</ul>
				{/if}
			{/if}
		</li>
	{/foreach}
</ul>
