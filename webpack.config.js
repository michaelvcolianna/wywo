const config = require( './project.config' ),
    path = require( 'path' ),
    webpack = require( 'webpack' )
    ;

module.exports = {
    entry: config.theme.path + config.source.path + config.source.scripts.path + config.source.scripts.build.entry,
    devtool: "inline-source-map", // https://webpack.js.org/configuration/devtool/
    output: {
        filename: config.asset.scripts.output,
        path: path.resolve( __dirname, config.theme.path + config.asset.path + config.asset.scripts.path )
    },
    resolve: {
        alias: {
            jquery: 'jquery/dist/jquery.js'
        },
        modules: [
            path.resolve( __dirname, config.theme.path + config.source.path + config.source.scripts.path + 'vendor' ),
            path.resolve( __dirname, config.theme.path + config.source.path + config.source.scripts.path + 'modules' ),
            path.resolve( __dirname, config.theme.path + config.source.path + config.source.scripts.path + 'models' ),
            "node_modules"
            ]
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                query: {
                    presets: [ 'env' ]
                }
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin( {
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        } )
    ]
};