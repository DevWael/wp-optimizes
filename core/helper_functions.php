<?php


/**
 * save debug setting from UI
 */
function wpo_save_setting() {
	$config_file_Name    = 'wp-config.php';
	$config_file_content = wpo_file_read( $config_file_Name );
	$config_file_content = wpo_add_const( 1, 'DISABLE_WP_CRON', $config_file_content );

	if ( wpo_file_write( $config_file_content, $config_file_Name ) ) { //done

	} else { //error happened

	}
}

/**
 * save debug setting from UI
 */
function wpo_unset_setting() {
	$config_file_Name    = 'wp-config.php';
	$config_file_content = wpo_file_read( $config_file_Name );
	$config_file_content = wpo_add_const( 0, 'DISABLE_WP_CRON', $config_file_content );

	if ( wpo_file_write( $config_file_content, $config_file_Name ) ) { //done

	} else { //error happened

	}
}

/**
 * modify content of wp-config.php file and add debug variable
 *
 * @param type $option
 * @param type $define
 * @param type $config_file_content
 *
 * @return type
 */
function wpo_add_const( $option, $define, $config_file_content ) {
	if ( $option == 1 ) {
		$config_file_content = str_replace( array(
			"define('" . $define . "', true);",
			"define('" . $define . "', false);"
		), "define('" . $define . "', true);", $config_file_content, $count );
		if ( $count == 0 ) {
			$config_file_content = str_replace( '$table_prefix', "define('" . $define . "', true);" . "\r\n" . '$table_prefix', $config_file_content );
		}
	} else {
		$config_file_content = str_replace( array(
			"define('" . $define . "', true);",
			"define('" . $define . "', false);"
		), "define('" . $define . "', false);", $config_file_content );
	}

	return $config_file_content;
}

/**
 * read file content
 *
 * @param string $config_file_Name
 *
 * @return boolean
 */
function wpo_file_read( $config_file_Name ) {
	$filePath = get_home_path() . $config_file_Name;
	if ( file_exists( $filePath ) ) {
		$file     = fopen( $filePath, "r" );
		$responce = '';
		fseek( $file, - 1048576, SEEK_END );
		while ( ! feof( $file ) ) {
			$responce .= fgets( $file );
		}

		fclose( $file );

		return $responce;
	}

	return false;
}

/**
 * write file content
 *
 * @param string $content
 * @param string $fileName
 *
 * @return type
 */
function wpo_file_write( $content, $fileName ) {
	$output = error_log( '/*test*/', '3', get_home_path() . $fileName );
	if ( $output ) {
		unlink( get_home_path() . $fileName );
		error_log( $content, '3', get_home_path() . $fileName );
		chmod( get_home_path() . $fileName, 0600 );
	}

	return $output;
}