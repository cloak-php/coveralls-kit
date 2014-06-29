CoverallsKit
====================================

[![Build Status](https://travis-ci.org/holyshared/coveralls-kit.png?branch=master)](https://travis-ci.org/holyshared/coveralls-kit)
[![Stories in Ready](https://badge.waffle.io/holyshared/coveralls-kit.png?label=ready&title=Ready)](https://waffle.io/holyshared/coveralls-kit)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/holyshared/coveralls-kit/badges/quality-score.png?s=659a62f282026153701b67aadcb2398529c9495d)](https://scrutinizer-ci.com/g/holyshared/coveralls-kit/)
[![Coverage Status](https://coveralls.io/repos/holyshared/coveralls-kit/badge.png?branch=master)](https://coveralls.io/r/holyshared/coveralls-kit?branch=master)
[![Dependencies Status](https://depending.in/holyshared/coveralls-kit.png)](http://depending.in/holyshared/coveralls-kit)

**CoverallsKit** is the library for transmitting the report of code coverage to **coveralls**.  
This library works with **PHP5.4** or more.

Requirements
------------------------------------

* PHP >= 5.4
* Xdebug >= 2.2.2

Basic usage
------------------------------------

You can generate a json file using the **coverallskit/JSONFileBuilder**.  
You just set the code coverage of rows that have been executed.  
Code coverage can be obtained easily by using the **HHVM** and **xdebug**.

	$builder = new JSONFileBuilder();
	$builder->token('your repository token')
		->service(Travis::travisCI())
		->repository(new Repository(__DIR__ . '/../'));

	$source = new SourceFile('path/to/file');

	$coverages = $source->getCoverages();

	$coverages->add(Coverage::executed(1));	//The first line was executed
	$coverages->add(Coverage::unused(2));	//The second line is not executed
	$coverages->add(Coverage::executed(3));	//The third line is executed

	$builder->addSource($source);
	$builder->build()->saveAs(__DIR__ . '/tmp/coverage.json');


Detailed documentation
-----------------------------------

* [Work with Travis-CI](docs/travis-ci.md)


Run only unit test
------------------------------------

	vendor/bin/pho

or

	vendor/bin/phake spec:watch

How to run the example
------------------------------------

	vendor/bin/phake example:basic
