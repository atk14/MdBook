<?php
class MdBookPrefilter extends DrinkMarkdownFilter {

	var $renderer;

	function filter($raw,$transformer){
		$out = array();
		$GLOBALS["md_book_replaces"] = array();

		$raw = "\n$raw\n";

		$replaces = array();

		if(preg_match_all('/\n\[Render (.+?)\]\s*?\n/',$raw,$matches_all,PREG_SET_ORDER)){
			foreach($matches_all as $matches){
				$renderer = $this->renderer;
				$_content = $renderer($matches[1]);
				$id = "mdbookreplace".uniqid();
				$GLOBALS["md_book_replaces"][$id] = $renderer($matches[1]);
				$replaces[$matches[0]] = "\n$id\n";
			}
		}

		$raw = strtr($raw,$replaces);

		return $raw;
	}
}
