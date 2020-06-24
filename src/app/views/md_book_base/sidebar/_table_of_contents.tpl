{assign current_chapter $chapter}

{if USING_BOOTSTRAP4}

	<h3 class="d-md-none">{t}Table of contents{/t}</h3>
	<div class="nav flex-column nav-pills">
		<a href="{link_to action="index"}" class="nav-link{if $action=="index"} active{/if}">{!$book->getTitle()}</a>
		{foreach $book->getChapters() as $ch}
			<a href="{link_to action=detail id=$ch}" class="nav-link{if $current_chapter && $current_chapter->getNo()===$ch->getNo()} active{/if}">{$ch->getNo()}. {$ch->getTitle()}</a>
			{foreach $ch->getSubchapters() as $sub_ch}
				<a href="{link_to action=detail id=$sub_ch}" class="nav-link pl-4{if $current_chapter && $current_chapter->getNo()===$sub_ch->getNo()} active{/if}">{$sub_ch->getNo()}. {$sub_ch->getTitle()}</a>
			{/foreach}
		{/foreach}
	</div>

{else}

	{* BOOTSTRAP 3 *}

	<h3>{t}Table of contents{/t}</h3>
	<ul class="nav nav-pills nav-stacked">
		<li{if $action=="index"} class="active"{/if}><a href="{link_to action="index"}">{!$book->getTitle()}</a></li>
		{foreach $book->getChapters() as $ch}
			<li{if $current_chapter && $current_chapter->getNo()===$ch->getNo()} class="active"{/if}><a href="{link_to action=detail id=$ch}">{$ch->getNo()}. {$ch->getTitle()}</a></li>
			{foreach $ch->getSubchapters() as $sub_ch}
				<li{if $current_chapter && $current_chapter->getNo()===$sub_ch->getNo()} class="active"{/if}><a href="{link_to action=detail id=$sub_ch}">{$sub_ch->getNo()}. {$sub_ch->getTitle()}</a></li>
			{/foreach}
		{/foreach}
	</ul>

{/if}
