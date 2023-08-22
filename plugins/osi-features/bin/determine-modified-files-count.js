/**
 * Determine the modified files count.
 *
 * Usage:
 * node determine-modified-files-count.js <file-path-pattern> <file paths delimited by newlines> [--invert]
 *
 * Example:
 * node determine-modified-files-count.js "foo\/bar|bar*" "foo/bar/baz\nquux" --invert
 *
 * Output: 1
 */

const args = process.argv.slice( 2 );

const filePattern = args[ 0 ];
const filePaths = args[ 1 ].split( '\n' );

const filteredFiles = filePaths.filter( ( filePath ) => {
	return filePath.match( new RegExp( filePattern, 'g' ) );
} );

/* eslint-disable no-console */
if ( args[ 2 ] === '--invert' ) {
	console.log( filePaths.length - filteredFiles.length );
} else {
	console.log( filteredFiles.length );
}
/* eslint-enable no-console */
