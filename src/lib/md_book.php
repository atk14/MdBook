<?php
/**
 * Base class for reading documentation books.
 * For formatting is used Markdown format which is converted by PHP Markdown library.
 * @link http://michelf.com/projects/php-markdown/
 */

/**
 * Base class for reading documentation books.
 * For formatting is used Markdown format which is converted by PHP Markdown library.
 * @link http://michelf.com/projects/php-markdown/
 *
 * A book consists of a directory structure with optional levels.
 * Each chapter is presented by a file named xx-chapter-name.md
 * If subchapters are needed create a directory named xx-subchapter,
 * place a (optional) file index.md and other chapter files inside following naming scheme mentioned above.
 *
 * xx is a chapter number.
 * 
 * chapter name should only contain characters satisfies url names.
 *
 * or it can be obtained directly from a book instance using whole chapters identifier.
 * Identifier of a chapter consists of two parts joined with semicolon:
 *
 *
 * This code obtains a chapter from a book
 * <code>
 * $book = new MdBook("master-api");
 * $chapter_2 = $book->getChapter("commands");
 * </code>
 *
 * Getting a deeper chapter:
 * <code>
 * $book = new MdBook("master-api");
 * $chapter_2_3 = $book->getChapter("master-api-client:penalty-system:other-clients");
 * </code>
 *
 * or:
 * <code>
 * $book = new MdBook("master-api");
 * $chapter_2_3 = $book->getChapter(array("master-api-client","penalty-system","other-clients"));
 * </code>
 *
 * Getting first level chapters:
 * <code>
 * $book = new MdBook("master-api");
 * $chapters = $book->getChapters();
 * </code>
 *
 * Getting subchapters:
 * <code>
 * $book = new MdBook("master-api");
 * $chapter = $book->getChapter("commands");
 * $subchapters = $chapter->getSubchapters();
 * </code>
 *
 */
class MdBook extends DrinkMarkdown {

	/**
	 * @var string
	 */
	var $book_directory;

	var $chapters = array();

	/**
	 * Not used yet.
	 */
	var $first_chapter = null;
	/**
	 * Not used yet.
	 */
	var $last_chapter = null;

	var $title = null;

	var $preferred_lang = "";

	var $markdown_transformer;

	var $renderer;

	function __construct($book_directory,$options = array()) {

		$options += array(
			"prefilter" => new MdBookPrefilter(),
			"postfilter" => new MdBookPostfilter(),
			"shortcodes_enabled" => true,
			"html_purification_enabled" => false,
			"markdown_transformer" => $this,
			"renderer" => function($template_name){ throw new Exception("No renderer given"); },
			"preferred_lang" => "", // "cs", "en"...
		);

		$prefilter = $options["prefilter"];
		unset($options["prefilter"]);

		$postfilter = $options["postfilter"];
		unset($options["postfilter"]);

		$preferred_lang = $options["preferred_lang"];
		unset($options["preferred_lang"]);

		$this->markdown_transformer = $options["markdown_transformer"];
		unset($options["markdown_transformer"]);

		$this->book_directory = $book_directory;

		$this->renderer = $options["renderer"];

		parent::__construct($options);

		$prefilter && $this->prependPrefilter($prefilter);
		$postfilter && $this->appendPostfilter($postfilter);

		$this->preferred_lang = $preferred_lang;

		$this->_readContent();
		$this->_sortContent();
		$this->_linkChapters();
	}

	/**
	 * Get all first level chapters
	 * @return array
	 */
	function getChapters() {
		return $this->chapters;
	}

	/**
	 * Gets a chapter directly from a book object.
	 *
	 * @param string $section_chapter_id
	 * @return MdBookChapter
	 */
	function getChapter($chapter_ids) {
		if (is_string($chapter_ids)) {
			$chapter_ids = preg_split("/:/", $chapter_ids);
		}
		$chapter = array_shift($chapter_ids);
		foreach($this->chapters as &$_c) {
			if ($_c->getName()==$chapter) {
				if ($chapter_ids) {
					return $_c->getChapter($chapter_ids);
				} else {
					return $_c;
				}
			}
		}
		return null;
	}

	function getTitle(){
		if(!isset($this->title)){
			if($_c = $this->_getIndexContent()){
				$ar = explode("\n",$_c);
				$this->title = trim($ar[0]);
			}
		}

		if(!$this->title){ $this->title = "MdBook"; }
		return $this->title;
	}

	function setTitle($title){
		$this->title = $title;
	}

	function getContent(){
		if(!$raw = $this->_getIndexContent()){
			$raw = $this->getTitle()."\n-------------------";
		}

		return $this->renderContent($raw);
	}

	function renderContent($markdown){
		return $this->markdown_transformer->transform($markdown);
	}

	function _getIndexContent(){
		return $this->_getFileContent("index.md");
	}

	private function _readContent() {
		# pro kazdou polozku, ktera vyhovuje, zalozime kapitolu
		foreach(scandir($this->book_directory) as $entry) {
			# vyradime nevhodne soubory
			if ($entry=="." || $entry=="..")
				continue;
			# vyradime soubory, ktere nevyhovuji schematu
			if (!preg_match("/^(\d+)-(.+)$/",$entry))
				continue;

			$chapter = new MdBookChapter($this,$entry);
			$this->chapters[] = $chapter;
		}
		return true;
	}

	/**
	 * Orders chapters by chapter numbers.
	 *
	 */
	private function _sortContent() {
		if (sizeof($this->chapters)>1) {
			usort($this->chapters, array("MdBookChapter","CmpChapters"));
		}

		$prev_ch = null;
		foreach($this->chapters as $_ch) {
			# jenom nastavime vazby mezi kapitolami na prvni urovni
			if (isset($prev_ch)) {
				$prev_ch->next_chapter = $_ch;
				$_ch->prev_chapter = $prev_ch;
			}
			$prev_ch = $_ch;
		}
		return true;
	}

	/**
	 * Just link all main chapters with subchapters.
	 * Deeper linking is also done in subchapters.
	 */
	private function _linkChapters() {
		$prev_ch = null;
		foreach($this->chapters as &$ch) {
			# vazba mezi indexem a prvni podkapitolou
			if ($ch->hasSubchapters()) {
				$ch->next_chapter = $ch->subchapters[0];
				$ch->subchapters[0]->prev_chapter = $ch;
			}
			# vazba mezi indexem a posledni podkapitolou predchozi kapitoly
			if ($prev_ch) {
				if ($prev_ch->hasSubchapters()) {
					$ch->prev_chapter = $prev_ch->subchapters[sizeof($prev_ch->subchapters)-1];
					$prev_ch->subchapters[sizeof($prev_ch->subchapters)-1]->next_chapter = $ch;
				}
			}
			$prev_ch = $ch;
		}
	}

	/**
	 *
	 *	$full_filename = $this->_getFullFilename("index.md");
	 */
	protected function _getFullFilename($filename){
		if(strlen($this->preferred_lang) && file_exists($_f = "$this->book_directory/$this->preferred_lang/$filename")){
			return $_f;
		}
		return "$this->book_directory/$filename";
	}

	/**
	 *
	 *	$content = $this->_getFileContent("index.md");
	 */
	protected function _getFileContent($filename){
		if(file_exists($_f = $this->_getFullFilename($filename))){
			return Files::GetFileContent($_f);
		}
	}

	function prependPrefilter($prefilter){
		$prefilter->renderer = $this->renderer;
		return parent::prependPrefilter($prefilter);
	}

	function appendPostfilter($postfilter){
		return parent::appendPrefilter($postfilter);
	}
}
