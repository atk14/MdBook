<div class="md_book_body">
	<div class="toc-toggler d-lg-none">
		<button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#toc-container" aria-controls="toc-container">{!"list"|icon} {t}Table of contents{/t}</button>
	</div>
	<div class="row">

		<div class="col col-lg-9 md_book_content" role="main">
			{$page_content nofilter}
			{render partial="shared/md_book/subchapters" subchapters=$chapter->getSubchapters()}
		</div>

		<div class="col col-lg-3 md_book_sidebar" role="complementary">
			<div class="offcanvas-lg offcanvas-end" tabindex="-1" id="toc-container" aria-labelledby="offcanvasResponsiveLabel">
				{render partial="shared/md_book/sidebar/table_of_contents"}
			</div>
		</div>

	</div>
</div>
