<?php

return [
    'baseDir' => __DIR__,
    'files' => [
		'index.php',
	    'LICENSE',
	    'readme.txt',
	    'build/composer.json' => 'composer.json',
	    'sim-site-maintenance.php',
	    'uninstall.php',
        'src',
        'vendor',
    ],
    'outputDir' => __DIR__ . '/build',
    'outputFile' => 'sim-site-maintenance.zip',
];
