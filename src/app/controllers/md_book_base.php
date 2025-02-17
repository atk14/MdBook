<?php
require_once(ATK14_DOCUMENT_ROOT . "/app/controllers/application.php");

/**
 * Chci, aby to vypadalo jako http://progit.org/book/index.html
 * Chci pouzivat Markdown http://daringfireball.net/projects/markdown/
 */
class MdBookBaseController extends ApplicationController{

	var $book = null; // MdBook
	var $book_dir = "";
	var $book_title = "";

	function index(){
		$this->_prepare_book();

		if($this->params->getString("format")=="sitemap"){
			$this->render_template = false;
			$this->response->setContentType("text/xml");
			$this->response->writeln('<?xml version="1.0" encoding="UTF-8"?>');
			$this->response->writeln('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
			foreach($this->book->getChapters() as $chapter){
				$this->response->writeln($this->_get_sitemap_chapter_item($chapter));
				foreach($chapter->getSubChapters() as $subchapter){
					$this->response->writeln($this->_get_sitemap_chapter_item($subchapter));
				}
			}
			$this->response->write('</urlset>');

			return;
		}

		$this->template_name = "md_book_base/index";
		$this->page_title = $this->breadcrumbs[] = $this->book->getTitle();
	}

	function detail(){
		$this->_prepare_book();

		$this->template_name = "md_book_base/detail";

		if(!$chapter = $this->chapter = $this->book->getChapter($this->params->getString("id"))){
			return $this->_execute_action("error404");
		}

		$this->tpl_data["chapter"] = $chapter;
		$this->tpl_data["parent_chapter"] = $parent = $chapter->getParentChapter();
		$this->tpl_data["page_content"] = $chapter->getContent();
		$this->tpl_data["subchapters"] = $chapter->getSubChapters();
		$this->page_title = $parent ? sprintf('%s (%s)',$chapter->getTitle(),$parent->getTitle()) : $chapter->getTitle();

		$this->breadcrumbs[] = [$this->book->getTitle(),$this->_link_to("index")];
		if($parent){
			$this->breadcrumbs[] = [$parent->getTitle(),$this->_link_to(["action" => "detail", "id" => $parent->getId()])];
		}
		$this->breadcrumbs[] = [$chapter->getTitle(),$this->_link_to(["action" => "detail", "id" => $chapter->getId()])];
	}

	function _get_book(){
		if($this->book){ return $this->book; }

		$controller = $this;
		$book = new MdBook($this->book_dir,array(
			"renderer" => function($template_name) use($controller){
				return $controller->_render($template_name,[
					"book" => $controller->book,
				]);
			},
			"preferred_lang" => $this->lang,
		));
		return $book;

		/*
		$controller = $this;

		$controller = $this;
		$this->book = $this->tpl_data["book"] = new MdBook($this->book_dir,array(
			"prefilter" => new MdBookPrefilter([
				"renderer" => function($template_name) use($controller){
					return $controller->_render($template_name,[
						"book" => $controller->book,
					]);
				}
			])
		));
		*/
	}

	function _prepare_book(){
		$this->book = $this->tpl_data["book"] = $this->_get_book(); 
		if($this->book_title){ $this->book->setTitle($this->book_title); }
	}

	function _get_sitemap_chapter_item($chapter){
		return "<url><loc>".$this->_link_to(array(
			"action" => "detail",
			"id" => $chapter,
		),array(
			"with_hostname" => true,
		))."</loc></url>";
	}
}
