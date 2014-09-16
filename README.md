CoverallsKit====================================[![Build Status](https://travis-ci.org/cloak-php/coveralls-kit.svg?branch=master)](https://travis-ci.org/cloak-php/coveralls-kit)[![Stories in Ready](https://badge.waffle.io/cloak-php/coveralls-kit.png?label=ready&title=Ready)](https://waffle.io/cloak-php/coveralls-kit)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cloak-php/coveralls-kit/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cloak-php/coveralls-kit/?branch=master)[![Coverage Status](https://coveralls.io/repos/cloak-php/coveralls-kit/badge.png)](https://coveralls.io/r/cloak-php/coveralls-kit)[![Dependency Status](https://www.versioneye.com/user/projects/53fd5949f4df154965000002/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53fd5949f4df154965000002)
**CoverallsKit** is the library for transmitting the report of code coverage to **coveralls**.  This library works with **PHP5.4** or more.Requirements------------------------------------* PHP >= 5.4* Xdebug >= 2.2.2Install------------------------------------Please add the following to composer.json.  Then please run the composer install.	"cloak/coverallskit": "1.3.0"Basic usage------------------------------------You can generate a json file using the **coverallskit/ReportBuilder**.  You just set the code coverage of rows that have been executed.  Code coverage can be obtained easily by using the **HHVM** and **xdebug**.```php$builder = new ReportBuilder();$builder->token('your repository token')	->service(new TravisCI( new Environment($_SERVER) ))	->repository(new Repository(__DIR__ . '/../'));$source = new SourceFile('path/to/file');$coverages = $source->getCoverages();$coverages->add(Coverage::executed(1));	//The first line was executed$coverages->add(Coverage::unused(2));	//The second line is not executed$coverages->add(Coverage::executed(3));	//The third line is executed$builder->addSource($source);$builder->build()->saveAs(__DIR__ . '/tmp/coverage.json');```Using a configuration file-----------------------------------If you use a configuration file, you can send the report more easily.```phpuse coverallskit\Configuration;
use coverallskit\ReportBuilder;

$configration = Configuration::loadFromFile('.coveralls.yml');
$builder = ReportBuilder::fromConfiguration($configration);
$builder->build()->save()->upload();
```Configration file format-----------------------------------It is also possible to use a configuration file.  The file format is **yaml format**.	token: {api-token}
	service: travis-ci
	reportFile:
	  input:
	    type: lcov
	    file: script/report.lcov
	  output: script/coveralls.json
	repositoryDirectory: .

### File format
| Name                | Required    | Default        | Description                                       |
|:--------------------|------------:|:---------------|:--------------------------------------------------|
| token               | optional    | **COVERALLS_REPO_TOKEN** | [coveralls.io](https://coveralls.io/docs/api) api token.  If you do not specify, use the environment variable **COVERALLS_REPO_TOKEN**.                          |
| service             | optional    | **travis-ci** | CI(Continuous Integration) service name. You can use the **travis-ci** or **travis-pro** |
| reportFile          | optional    |               | Please look at the **reportFile section**. |
| repositoryDirectory | optional    | . | Directory path of the **git repository**.  Will specify a relative path from the directory containing the configuration file. |

#### reportFile

##### imput

| Name                | Required    | Default        | Description                                       |
|:--------------------|------------:|:---------------|:--------------------------------------------------|
| type                | optional    |                | Will specify the file type in the code coverage report.  You can specify the **lcov** or **clover**. |
| file                | optional    | coveralls.json | Will specify a file of code coverage report. |

##### output

will specify the json file name to be sent to the [coveralls.io](https://coveralls.io/docs/api).  
Will specify a relative path from the directory containing the configuration file.


Using a CLI
---------------------------------------------------------------------------------

You can send a report from the command line using the **CLI package**.

[https://github.com/cloak-php/coveralls-kit-cli](https://github.com/cloak-php/coveralls-kit-cli)

Detailed documentation-----------------------------------* [Work with Travis-CI](docs/travis-ci.md)Run only unit test------------------------------------	vendor/bin/phoor	vendor/bin/phake spec:watchHow to run the example------------------------------------	vendor/bin/phake example:basic