<?php

group('example', function() {
    desc('Run the example program basic');
    task('basic', function() {
        require_once __DIR__ . '/example/basic_example.php';
    });
});

group('spec', function() {
    desc('Run the unit test with code coverage');
    task('coverage', function() {
        echo shell_exec('php script/coveralls.php');
    });
});
