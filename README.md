Md Book
-------

A set of features that allow to publish books written in Markdown on web.

Installation
============

    cd path/to/your/project/
    composer require atk14/md-book

    ln -s ../../vendor/atk14/md-book/src/app/controllers/md_book_base.php ./app/controllers/
    ln -s ../../vendor/atk14/md-book/src/app/views/md_book_base ./app/views/

Usage in an Atk14 application
=============================

    <?php
    // file: app/controller/sample_book_controller.php

    require_once(__DIR__ . "/md_book_base.php");

    class SampleBookController extends MdBookBaseController {

      var $book_dir = __DIR__ . "/../../vendor/atk14/md-book/test/sample_book/";

    }

[//]: # ( vim: set ts=2 et: )
