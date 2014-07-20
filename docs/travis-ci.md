Travis-CI
=======================================

will explain how to send a report of code coverage in the **travis-ci** environment.  
You have to write some code, but you will be able to send the report immediately.

Create a script file
---------------------------------------

Create a script file to send the report to the **script** directory.  
Want to **coveralls.php** file name.

Located in the **script directory** of this repository file would be helpful.  
[https://github.com/holyshared/coveralls-kit/blob/master/script/coveralls.php](https://github.com/holyshared/coveralls-kit/blob/master/script/coveralls.php)


Get a report of code coverage data.
---------------------------------------

Will get a report of code coverage data by using the api of [xdebug](http://xdebug.org/index.php).  
This is an example of using the [pho](https://github.com/danielstjules/pho).

	xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

	$argv = array('../vendor/bin/pho', '--reporter', 'spec');

	require_once __DIR__ . "/../vendor/bin/pho";

	$result = xdebug_get_code_coverage();
	xdebug_stop_code_coverage();


Perform the required settings
---------------------------------------

Specify **repository token**, **service name**, **the directory of the repository**.

1. **repository token** - Repository token of coveralls
2. **service name** - *TravisCI::ci()* or *TravisCI::pro()*
3. **repository** - the directory of the repository

### Example in the case of TravisCI

	$builder = new ReportBuilder();
	$builder->token('your repository token')
		->service(Travis::travisCI())
		->repository(new Repository(__DIR__ . '/../'));


Reflect the code coverage
---------------------------------------

$result is a report of code coverage data.  
Please look at the [xdebug_get_code_coverage](http://xdebug.org/docs/code_coverage) for more information.

	foreach ($result as $file => $coverage) {
    	if (preg_match('/vendor/', $file) || preg_match('/spec/', $file)) {
        	continue;
	    }

	    $source = new SourceFile($file);

	    foreach ($coverage as $line => $status) {
    	    try {
        	    if ($status === 1) {
            	    $source->addCoverage(Coverage::executed($line));
            	} else if ($status === -1) {
                	$source->addCoverage(Coverage::unused($line));
	            }
    	    } catch (LineOutOfRangeException $exception) {
        	    echo $source->getName() . PHP_EOL;
            	echo $exception->getMessage() . PHP_EOL;
	        }
    	}

	    $builder->addSource($source);
	}

Dump of a json file, and upload 
---------------------------------------

Dump the file by specifying a path.  
Please look at the specifications of the json file of [coveralls](https://coveralls.io/docs/api_reference) for more information.

	$coverageFile = __DIR__ . '/coverage.json';
	$builder->build()->saveAs($coverageFile)->upload();


Update the .travis.yml
--------------------------------------

Please add to the script **after_script** that you created.

	after_script: php script/coveralls.php
