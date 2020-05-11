{assign current_chapter $chapter}

<h3 class="d-md-none">{t}Table of contents{/t}</h3>
<div class="nav flex-column nav-pills">
	<a href="{link_to action="index"}" class="nav-link{if $action=="index"} active{/if}">{!$book->getTitle()}</a>
	{foreach $book->getChapters() as $ch}
		<a href="{link_to action=detail id=$ch}" class="nav-link{if $current_chapter && $current_chapter->getNo()==$ch->getNo()} active{/if}">{$ch->getNo()}. {$ch->getTitle()}</a>
		{foreach $ch->getSubchapters() as $sub_ch}
			<a href="{link_to action=detail id=$sub_ch}" class="nav-link pl-4{if $current_chapter && $current_chapter->getNo()==$sub_ch->getNo()} active{/if}">{$sub_ch->getNo()}. {$sub_ch->getTitle()}</a>
		{/foreach}
	{/foreach}
</div>
