const
    autoprefixer = require ( 'gulp-autoprefixer' ),
    config = require( './project.config' ),
    gulp = require( 'gulp' ),
    exec = require( 'child_process' ).exec,
    sass = require( 'gulp-sass' ),
    imagemin = require( 'gulp-imagemin' ),
    sourcemaps = require( 'gulp-sourcemaps' ),
    newer = require( 'gulp-newer' )
    ;

/** Utilities **/
function capitalize_word ( string ) {
    return string.charAt( 0 ).toLocaleUpperCase() + string.slice( 1 )
}
function copy_assets( callback, id ) {
    var source_path = config.theme.path + config.source.path + config.source[ id ].path,
        asset_path = config.theme.path + config.asset.path + config.asset[ id ].path
        ;

    console.log( '---------------------------------' );
    console.log( 'Copying ' + capitalize_word( id ) );
    console.log( 'source: ' + source_path );
    console.log( 'destination: ' + asset_path );
    console.log( '---------------------------------' );

    // callback();
    return gulp.src( source_path + config.source.images.pattern )
        .pipe( newer( asset_path ) )
        .pipe( gulp.dest( asset_path ) );
}
function optimize( callback, environment ){
    let command_string = 'npm run webpack_dev';

    if ( environment == 'production' ) {
        command_string = 'npm run webpack_prod';
    }

    exec( command_string, function (err, stdout, stderr) {
        console.log( stdout );
        console.log( stderr );
        console.log( err );
        callback();
    } );
}

/** Optimize (JS) **/
gulp.task( "optimize:production", function ( callback_done ){
    // This is a placeholder until the builds are actually distinguished
    optimize( callback_done, 'production' );
} );

gulp.task( "optimize:development", function ( callback_done ){
    // This is a (default) placeholder until the builds are actually distinguished
    optimize( callback_done, 'development' );
} );

/** Images **/
gulp.task('images', function( callback_done ) {
    var source_path = config.theme.path + config.source.path + config.source[ 'images' ].path,
        asset_path = config.theme.path + config.asset.path + config.asset[ 'images' ].path
        ;

    console.log( '---------------------------------' );
    console.log( 'Compressing Images' );
    console.log( 'source: ' + source_path );
    console.log( 'destination: ' + asset_path );
    console.log( '---------------------------------' );

    return gulp.src( source_path + config.source[ 'images' ].pattern )
        .pipe( newer( asset_path ) )
        .pipe( imagemin() )
        .pipe( gulp.dest( asset_path ) );

});

/** Fonts **/
gulp.task( 'fonts', function ( callback_done ) {
    return copy_assets( callback_done, "fonts" );
} );

/** Styles **/
gulp.task('sass', function() {

    console.log( '---------------------------------' );
    console.log( 'Compiling SASS for "' + config.theme.path + config.source.path + config.source.sass.path + config.source.sass.pattern + '"' );
    console.log( '---------------------------------' );

    // del([ config.theme.path + config.asset.path + config.asset.css.path + '/**/*' ]);
    return gulp.src( config.theme.path + config.source.path + config.source.sass.path + config.source.sass.pattern )
        .pipe( sourcemaps.init() )
        .pipe( sass().on( 'error', sass.logError ) )
        .pipe( sourcemaps.write() )
        .pipe( autoprefixer() )
        .pipe( gulp.dest( config.theme.path + config.asset.path + config.asset.css.path ) );
});

/** Watch **/
gulp.task( 'watch', function() {
    var source_path = config.theme.path + config.source.path,
        asset_path = config.theme.path + config.asset.path,
        watchers = {}
        ;

    [ "sass", "images", "fonts", "scripts" ].forEach( function ( current, index, array ) {
        console.log('---------------------------------');
        console.log(' Watching "' + current + '": ' + source_path + config.source[ current ].path );
        console.log('---------------------------------');
        watchers[ current ] = gulp.watch( source_path + config.source[ current ].path + config.source[ current ].pattern );
        watchers[ current ].on( 'all', gulp.parallel( ( current == "scripts" ) ? "optimize:development" : current ) );
    } );

});

gulp.task( 'scriptless-watch', function() {
    var source_path = config.theme.path + config.source.path,
        asset_path = config.theme.path + config.asset.path,
        watchers = {}
        ;

    [ "sass", "fonts" ].forEach( function ( current, index, array ) {
        console.log('---------------------------------');
        console.log(' NOT WATCHING SCRIPTS!! OR IMAGES!! ');
        console.log(' Watching "' + current + '": ' + source_path + config.source[ current ].path );
        console.log('---------------------------------');
        watchers[ current ] = gulp.watch( source_path + config.source[ current ].path + config.source[ current ].pattern );
        watchers[ current ].on( 'all', gulp.parallel( ( current == "scripts" ) ? "optimize:development" : current ) );
    } );

});

gulp.task( 'default', gulp.series( gulp.parallel( 'fonts', 'sass', 'optimize:development', 'images' ), 'watch' ) );
gulp.task( 'qa', gulp.series('sass', 'fonts', 'optimize:development','images' ) );
gulp.task( 'dev', gulp.series( 'default' ) );
gulp.task( 'build', gulp.parallel( 'fonts', 'sass', 'optimize:production', 'images' ) );
gulp.task( 'prod', gulp.series( 'build' ) );