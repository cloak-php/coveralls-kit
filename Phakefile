<?php

group('example', function() {
    desc('Run the example program basic');
    task('basic', function() {
        echo shell_exec('TRAVIS_JOB_ID=10 php ' . __DIR__ . '/example/basic_example.php');
    });
});

group('spec', function() {
    desc('Run the unit test with code coverage');
    task('coverage', function() {
        echo shell_exec('php script/coveralls.php');
    });
});
