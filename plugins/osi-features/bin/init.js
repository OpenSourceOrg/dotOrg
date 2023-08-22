#! /usr/bin/env node

/* eslint no-console: 0 */

/**
 * External dependencies
 */
const fs = require( 'fs' );
const path = require( 'path' );
const readline = require( 'readline' );

/**
 * Define Constants
 */
const rl = readline.createInterface( {
	input: process.stdin,
	output: process.stdout,
} );
const info = {
	error: ( message ) => {
		return `\x1b[31m${ message }\x1b[0m`;
	},
	success: ( message ) => {
		return `\x1b[32m${ message }\x1b[0m`;
	},
	warning: ( message ) => {
		return `\x1b[33m${ message }\x1b[0m`;
	},
	message: ( message ) => {
		return `\x1b[34m${ message }\x1b[0m`;
	},
};
let fileContentUpdated = false;
let fileNameUpdated = false;
let pluginCleanup = false;

const args = process.argv.slice( 2 );

if ( 0 === args.length ) {
	rl.question( 'Would you like to setup the plugin? (Y/n) ', ( answer ) => {
		if ( 'n' === answer.toLowerCase() ) {
			console.log( info.warning( '\nPlugin Setup Cancelled.\n' ) );
			process.exit( 0 );
		}
		rl.question( 'Enter plugin name (shown in WordPress admin)*: ', ( pluginName ) => {
			const pluginInfo = setupPlugin( pluginName );
			rl.question( 'Confirm the Plugin Details (Y/n) ', ( confirm ) => {
				if ( 'n' === confirm.toLowerCase() ) {
					console.log( info.warning( '\nPlugin Setup Cancelled.\n' ) );
					process.exit( 0 );
				}
				initPlugin( pluginInfo );
				rl.question( 'Would you like to run the plugin cleanup? (Y/n) ', ( cleanup ) => {
					if ( 'n' === cleanup.toLowerCase() ) {
						console.log( info.warning( '\nExiting without running plugin cleanup.\n' ) );
						process.exit( 0 );
					}
					runPluginCleanup();
					rl.close();
				} );
			} );
		} );
	} );
} else if ( ( args.includes( '--clean' ) || args.includes( '-c' ) ) && 1 === args.length ) {
	rl.question( 'Would you like to run the plugin cleanup? (Y/n) ', ( cleanup ) => {
		if ( 'n' === cleanup.toLowerCase() ) {
			console.log( info.warning( '\nExiting without running plugin cleanup.\n' ) );
			process.exit( 0 );
		}
		runPluginCleanup();
		rl.close();
	} );
} else {
	console.log( info.error( '\nInvalid arguments.\n' ) );
	process.exit( 0 );
}

rl.on( 'close', () => {
	process.exit( 0 );
} );

/**
 * Plugin Setup
 *
 * @param {string} pluginName
 *
 * @return {Object} pluginInfo
 */
const setupPlugin = ( pluginName ) => {
	console.log( info.success( '\nFiring up the plugin setup...' ) );

	// Ask plugin name.
	if ( ! pluginName ) {
		console.log( info.error( '\nPlugin name is required.\n' ) );
		process.exit( 0 );
	}

	// Generate plugin info.
	const pluginInfo = generatePluginInfo( pluginName );

	const pluginDetails = {
		'Plugin Name: ': `${ pluginInfo.pluginName }`,
		'Plugin Version: ': `1.0.0`,
		'Text Domain: ': `${ pluginInfo.kebabCase }`,
		'Package: ': `${ pluginInfo.kebabCase }`,
		'Namespace: ': `${ pluginInfo.pascalSnakeCase }`,
		'Function Prefix: ': `${ pluginInfo.snakeCaseWithUnderscoreSuffix }`,
		'Plugin Build Directory Constant: ': `${ pluginInfo.macroCase }_FEATURES_PATH`,
		'Plugin Build Directory URI Constant: ': `${ pluginInfo.macroCase }_FEATURES_URL`,
	};

	const biggestStringLength = pluginDetails[ 'Plugin Build Directory URI Constant: ' ].length + 'Plugin Build Directory URI Constant: '.length;

	console.log( info.success( '\nPlugin Details:' ) );
	console.log(
		info.warning( '┌' + '─'.repeat( biggestStringLength + 2 ) + '┐' ),
	);
	Object.keys( pluginDetails ).forEach( ( key ) => {
		console.log(
			info.warning( '│' + ' ' + info.success( key ) + info.message( pluginDetails[ key ] ) + ' ' + ' '.repeat( biggestStringLength - ( pluginDetails[ key ].length + key.length ) ) + info.warning( '│' ) ),
		);
	} );
	console.log(
		info.warning( '└' + '─'.repeat( biggestStringLength + 2 ) + '┘' ),
	);

	return pluginInfo;
};

/**
 * Initialize new plugin
 *
 * @param {Object} pluginInfo
 */
const initPlugin = ( pluginInfo ) => {
	const chunksToReplace = {
		'osi': pluginInfo.pluginNameLowerCase,
		'OSI': pluginInfo.pluginName,
		'OSI': pluginInfo.pluginNameCobolCase,
		'osi': pluginInfo.kebabCase,
		'Osi': pluginInfo.trainCase,
		'OSI': pluginInfo.cobolCase,
		osi: pluginInfo.snakeCase,
		Osi: pluginInfo.pascalSnakeCase,
		OSI: pluginInfo.macroCase,
		'osi-': pluginInfo.kebabCaseWithHyphenSuffix,
		'Osi-': pluginInfo.trainCaseWithHyphenSuffix,
		'OSI-': pluginInfo.cobolCaseWithHyphenSuffix,
		osi_: pluginInfo.snakeCaseWithUnderscoreSuffix,
		Osi_: pluginInfo.pascalSnakeCaseWithUnderscoreSuffix,
		OSI_: pluginInfo.macroCaseWithUnderscoreSuffix,
	};

	const files = getAllFiles( getRoot() );

	// File name to replace in.
	const fileNameToReplace = {};
	files.forEach( ( file ) => {
		const fileName = path.basename( file );
		Object.keys( chunksToReplace ).forEach( ( key ) => {
			if ( fileName.includes( key ) ) {
				fileNameToReplace[ fileName ] = fileName.replace( key, chunksToReplace[ key ] );
			}
		} );
	} );

	// Replace files contents.
	console.log( info.success( '\nUpdating plugin details in file(s)...' ) );
	Object.keys( chunksToReplace ).forEach( ( key ) => {
		replaceFileContent( files, key, chunksToReplace[ key ] );
	} );
	if ( ! fileContentUpdated ) {
		console.log( info.error( 'No file content updated.\n' ) );
	}

	// Replace file names
	console.log( info.success( '\nUpdating plugin file(s) name...' ) );
	Object.keys( fileNameToReplace ).forEach( ( key ) => {
		replaceFileName( files, key, fileNameToReplace[ key ] );
	} );
	if ( ! fileNameUpdated ) {
		console.log( info.error( 'No file name updated.\n' ) );
	}

	if ( fileContentUpdated || fileNameUpdated ) {
		console.log( info.success( '\nYour new plugin is ready to go!' ), '✨' );
		// Docs link
		console.log( info.success( '\nFor more information on how to use this plugin, please visit the following link: ' + info.warning( 'https://github.com/rtCamp/features-plugin-skeleton/blob/master/README.md\n' ) ) );
	} else {
		console.log( info.warning( '\nNo changes were made to your plugin.\n' ) );
	}
};

/**
 * Get all files in a directory
 *
 * @param {Array} dir - Directory to search
 */
const getAllFiles = ( dir ) => {
	const dirOrFilesIgnore = [
		'.git',
		'.github',
		'node_modules',
		'vendor',
	];

	try {
		let files = fs.readdirSync( dir );
		files = files.filter( ( fileOrDir ) => ! dirOrFilesIgnore.includes( fileOrDir ) );

		const allFiles = [];
		files.forEach( ( file ) => {
			const filePath = path.join( dir, file );
			const stat = fs.statSync( filePath );
			if ( stat.isDirectory() ) {
				allFiles.push( ...getAllFiles( filePath ) );
			} else {
				allFiles.push( filePath );
			}
		} );
		return allFiles;
	} catch ( err ) {
		console.log( info.error( err ) );
	}
};

/**
 * Replace content in file
 *
 * @param {Array}  files           Files to search
 * @param {string} chunksToReplace String to replace
 * @param {string} newChunk        New string to replace with
 */
const replaceFileContent = ( files, chunksToReplace, newChunk ) => {
	files.forEach( ( file ) => {
		const filePath = path.resolve( getRoot(), file );

		try {
			let content = fs.readFileSync( filePath, 'utf8' );
			const regex = new RegExp( chunksToReplace, 'g' );
			content = content.replace( regex, newChunk );
			if ( content !== fs.readFileSync( filePath, 'utf8' ) ) {
				fs.writeFileSync( filePath, content, 'utf8' );
				console.log( info.success( `Updated [${ info.message( chunksToReplace ) }] ${ info.success( 'to' ) } [${ info.message( newChunk ) }] ${ info.success( 'in file' ) } [${ info.message( path.basename( file ) ) }]` ) );
				fileContentUpdated = true;
			}
		} catch ( err ) {
			console.log( info.error( `\nError: ${ err }` ) );
		}
	} );
};

/**
 * Change File Name
 *
 * @param {Array}  files       Files to search
 * @param {string} oldFileName Old file name
 * @param {string} newFileName New file name
 */
const replaceFileName = ( files, oldFileName, newFileName ) => {
	files.forEach( ( file ) => {
		if ( oldFileName !== path.basename( file ) ) {
			return;
		}
		const filePath = path.resolve( getRoot(), file );
		const newFilePath = path.resolve( getRoot(), file.replace( oldFileName, newFileName ) );
		try {
			fs.renameSync( filePath, newFilePath );
			console.log( info.success( `Updated file [${ info.message( path.basename( filePath ) ) }] ${ info.success( 'to' ) } [${ info.message( path.basename( newFilePath ) ) }]` ) );
			fileNameUpdated = true;
		} catch ( err ) {
			console.log( info.error( `\nError: ${ err }` ) );
		}
	} );
};

/**
 * Generate Plugin Info from Plugin Name
 *
 * @param {string} pluginName
 */
const generatePluginInfo = ( pluginName ) => {
	const pluginNameLowerCase = pluginName.toLowerCase();

	const kebabCase = pluginName.replace( /\s+/g, '-' ).toLowerCase();
	const snakeCase = kebabCase.replace( /\-/g, '_' );
	const kebabCaseWithHyphenSuffix = kebabCase + '-';
	const snakeCaseWithUnderscoreSuffix = snakeCase + '_';

	const trainCase = kebabCase.replace( /\b\w/g, ( l ) => {
		return l.toUpperCase();
	} );
	const pluginNameTrainCase = trainCase.replace( /\-/g, ' ' );
	const pascalSnakeCase = trainCase.replace( /\-/g, '_' );
	const trainCaseWithHyphenSuffix = trainCase + '-';
	const pascalSnakeCaseWithUnderscoreSuffix = pascalSnakeCase + '_';

	const cobolCase = kebabCase.toUpperCase();
	const pluginNameCobolCase = pluginNameTrainCase.toUpperCase();
	const macroCase = snakeCase.toUpperCase();
	const cobolCaseWithHyphenSuffix = cobolCase + '-';
	const macroCaseWithUnderscoreSuffix = macroCase + '_';

	return {
		pluginName,
		pluginNameLowerCase,
		kebabCase,
		snakeCase,
		kebabCaseWithHyphenSuffix,
		snakeCaseWithUnderscoreSuffix,
		trainCase,
		pluginNameTrainCase,
		pascalSnakeCase,
		trainCaseWithHyphenSuffix,
		pascalSnakeCaseWithUnderscoreSuffix,
		cobolCase,
		pluginNameCobolCase,
		macroCase,
		cobolCaseWithHyphenSuffix,
		macroCaseWithUnderscoreSuffix,
	};
};

/**
 * Return root directory
 *
 * @return {string} root directory
 */
const getRoot = () => {
	return path.resolve( __dirname, '../' );
};

/**
 * Run plugin cleanup to delete files and directories
 *
 * It will remove following directories and files:
 * 1. .git
 * 3. bin
 */
const runPluginCleanup = () => {
	const deleteDirs = [
		'.git',
		'bin/init.js',
	];

	deleteDirs.forEach( ( dir ) => {
		const dirPath = path.resolve( getRoot(), dir );
		try {
			if ( fs.existsSync( dirPath ) ) {
				if ( true === fs.lstatSync( dirPath ).isDirectory() ) {
					fs.rmdirSync( dirPath, {
						recursive: true,
					} );
					console.log( info.success( `Removed directory [${ info.message( dir ) }]` ) );
				} else {
					fs.unlinkSync( dirPath );
					console.log( info.success( `Removed file [${ info.message( dir ) }]` ) );
				}
				pluginCleanup = true;
			}
		} catch ( err ) {
			console.log( info.error( `\nError: ${ err }` ) );
		}
	} );

	if ( pluginCleanup ) {
		console.log( info.success( '\nPlugin cleanup completed!' ), '✨' );
	} else {
		console.log( info.warning( '\nNo plugin cleanup required!\n' ) );
	}
};
