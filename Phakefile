<?php

namespace coveralls\spec;

require_once __DIR__ . "/vendor/autoload.php";

use Illuminate\Filesystem\Filesystem;
use JasonLewis\ResourceWatcher\Tracker;
use JasonLewis\ResourceWatcher\Watcher;
use JasonLewis\ResourceWatcher\Resource\ResourceInterface;
use phake\Application;

group('example', function() {
    desc('Run the example program basic');
    task('basic', function() {
        echo shell_exec('TRAVIS_JOB_ID=10 php ' . __DIR__ . '/example/basic_example.php');
    });

    desc('Run in the example hhvm');
    task('hhvm', function() {
        echo shell_exec('TRAVIS_JOB_ID=10 php ' . __DIR__ . '/example/hhvm_example.php');
    });
});

group('spec', function() {
    desc('Run the unit test with code coverage');
    task('coverage', function() {
        echo shell_exec('php script/coveralls.php');
    });

    desc('Monitoring the source file and rerun the test if there is a change.');
    task('watch-source', function(Application $application) {
        $watcher = $application['watcher'];

        if ($watcher === null) {
            $watcher = new Watcher(new Tracker(), new Filesystem());
        }
 
        $listener = $watcher->watch(__DIR__ . '/src');
        $listener->onModify(function(ResourceInterface $resource, $path) {
            $searchKeywards = ['src', '.php'];
            $replaceKeywards = ['spec', 'Spec.php'];

            $specFile = str_replace($searchKeywards, $replaceKeywards, $resource->getPath());

            if (file_exists($specFile) === false) {
                return;
            }

            $sourceFile = str_replace(getcwd() . '/', '', $resource->getPath());

            echo $sourceFile . " of the file has changed" . PHP_EOL;
            echo shell_exec('vendor/bin/pho --reporter spec ' . $specFile);
        });

    });

    desc('Monitoring the spec file and rerun the test if there is a change.');
    task('watch-spec', function(Application $application) {
        $watcher = $application['watcher'];

        if ($watcher === null) {
            $watcher = new Watcher(new Tracker(), new Filesystem());
        }

        $listener = $watcher->watch(__DIR__ . '/spec');
        $listener->onModify(function(ResourceInterface $resource, $path) {
            $specFile = str_replace(getcwd() . '/', '', $resource->getPath());

            echo $specFile . " of the file has changed" . PHP_EOL;
            echo shell_exec('vendor/bin/pho --reporter spec ' . $specFile);
        });
    });

    desc('Monitors the source files, test files, and rerun the test if there is a change');
    task('watch', function(Application $application) {
        $watcher = new Watcher(new Tracker(), new Filesystem());

        $application['watcher'] = $watcher;
        $application->invoke('spec:watch-source');
        $application->invoke('spec:watch-spec');

        $watcher->start();
    });

});
