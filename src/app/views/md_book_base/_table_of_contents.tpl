{assign chapters $book->getChapters()}

<ul class="table-of-contents list-unstyled">
	{foreach $book->getChapters() as $chapter}
		<li>
			<h4>{$chapter->getNo()}. {a action=detail id=$chapter}{$chapter->getTitle()}{/a}</h4>

			{if $chapters|count<10} {* We do not want to be too long *}
			{if $chapter->hasSubchapters()}
				{assign subchapters $chapter->getSubchapters()}
				<ul class="list-unstyled {if USING_BOOTSTRAP3 || USING_BOOTSTRAP4}pl-4{else}ps-4{/if}">
					{foreach $subchapters as $subchapter}
						<li>
							<h4>{$subchapter->getNo()}. {a action=detail id=$subchapter}{$subchapter->getTitle()}{/a}</h4>
						</li>
					{/foreach}
				</ul>
			{/if}
			{/if}
		</li>
	{/foreach}
</ul>
