<div class="row">

	<div class="col col-md-9" role="main">
		{$book->getContent() nofilter}
	</div>

	<div class="col col-md-3" role="complementary">
		{render partial="md_book_base/sidebar/table_of_contents"}
	</div>

</div>

