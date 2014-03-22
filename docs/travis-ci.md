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

	$builder = new JSONFileBuilder();
	$builder->token('your repository token')
		->service(TravisCI::ci())
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
    	$coverages = $source->getCoverages();

	    foreach ($coverage as $line => $status) {
    	    if ($status === 1) {
        	    $coverages->add(Coverage::executed($line));
	        } else if ($status === -1) {
    	        $coverages->add(Coverage::unused($line));
        	}
	    }

	    $builder->addSource($source);
	}


Dump the json file
---------------------------------------

Dump the file by specifying a path.  
Please look at the specifications of the json file of [coveralls](https://coveralls.io/docs/api_reference) for more information.

	$coverageFile = __DIR__ . '/coverage.json';
	$builder->build()->saveAs($coverageFile);


Send a json file
---------------------------------------

Sent using the api json file.  
This is an example to be sent using the [Guzzle](https://github.com/guzzle/guzzle).

	$client = new Client();
	$request = $client->post('https://coveralls.io/api/v1/jobs')
		->addPostFiles(array(
			'json_file' => realpath($coverageFile)
    	));

	$request->send();


Update the .travis.yml
--------------------------------------

Please add to the script **after_script** that you created.

	after_script: php script/coveralls.php
	env:
	  - COVERALLS_SERVICE_NAME=travis-ci COVERALLS_REPO_TOKEN=[your repository token]
