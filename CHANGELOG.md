# Change Log
All notable changes to MdBook will be documented in this file.

## [0.2.6] - 2025-03-04

* 811ba65 - Renderer improved - it searches for partial templates also in app/views/md_book_base/
* 69aa88d - Added variable MdBookBaseController::$book_options = array()

## [0.2.5] - 2025-03-02

* 6230360 - Reorganisation of templates

## [0.2.4] - 2025-03-01

* 0414176 - Template md_book_base/index.tpl or md_book_base/detail.tpl is used if there is no corresponding template for the current controller

## [0.2.3] - 2025-03-01

* ed4b932 - Package is compatible with PHP>=5.6.0
* 745b04b - The renderer is passed as an option to MdBook::__construct()
* 227e197 - Template _table_of_contents.tpl updated

## [0.2.2] - 2023-07-19

* c1a5596 - PHP8 compatibility

## [0.2.1] - 2022-08-24

* 85b4869 - Method MdBookChapter::CmpChapters() fixed

## [0.2] - 2022-02-14

- Added support for multilingual books

## [0.1.9] - 2020-06-24

- The Table of Contents template fixed

## [0.1.8] - 2020-06-16

- HTML purification is disabled by default

## [0.1.7] - 2020-06-14

- Auto syntax highlighter disabled

## [0.1.6] - 2020-06-14

- Fix

## [0.1.5] - 2020-05-27

- Fixes & optimizations

## [0.1.4] - 2020-05-19

- Added css selectors

## [0.1.3] - 2020-05-13

- Enabled shortcodes in markdown_transformer

## [0.1.2] - 2020-05-11

- Markup tuned for BOOTSTRAP 3

## [0.1.1] - 2020-05-11

- MdBookBaseController fixed

## [0.1] - 2020-05-11

First official release.
