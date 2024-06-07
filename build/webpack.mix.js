let mix = require('laravel-mix')

mix.setPublicPath('build').version()

mix.options({ manifest: false })

// build the plugin files in trunk.
mix.copy('vendor', 'build/trunk/vendor')
mix.copy('src', 'build/trunk/src')

mix.copy([
    'index.php',
    'LICENSE',
    'readme.txt',
    'site-maintenance.php',
], 'build/trunk/')
