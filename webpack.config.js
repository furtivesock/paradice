var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    // Images

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]'
    })

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addStyleEntry('css/app', './assets/sass/app.scss')
    
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/order/stories', './assets/js/order/stories.js')
    .addEntry('js/filter/top-universe', './assets/js/filter/top-universe.js')
    .addEntry('js/chat/messages', './assets/js/chat/messages.js')
    .addEntry('js/accept/application', './assets/js/accept/application.js')
    .addEntry('js/status/story', './assets/js/status/story.js')
    //.addEntry('js/folder/filename_without_extension', './assets/js/folder/file.js')
    //.addStyleEntry('css/folder/your_cssfile_without_extension', './assets/css/your_file.scss')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .disableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();