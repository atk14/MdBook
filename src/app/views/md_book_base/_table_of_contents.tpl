<ul class="table-of-contents">
	{foreach $book->getChapters() as $chapter}
		<li>
			<h4>{$chapter->getNo()}. {a action=detail id=$chapter}{$chapter->getTitle()}{/a}</h4>
			{if $chapter->hasSubchapters()}
				{assign subchapters $chapter->getSubchapters()}
				<ul>
					{foreach $subchapters as $subchapter}
						<li>
							<h4>{$subchapter->getNo()}. {a action=detail id=$subchapter}{$subchapter->getTitle()}{/a}</h4>
						</li>
					{/foreach}
				</ul>
			{/if}
		</li>
	{/foreach}
</ul>
