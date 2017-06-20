<?php
/*
1.	Check support for zipArchive

<?php 
	phpinfo();
	search for the libzip
?>

2	Check permission for creating zip in definded folder.
 by 
	is_writable();

3	Check each file exist before adding to zip.
by
	file_exists(); or is_readable();

/* creates a compressed zip file */
function create_zip(
	$files = array(),
	$destination = '',
	$overwrite = false
	) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {

		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {

				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

$path=dirname($_SERVER['SCRIPT_FILENAME']);

if(is_writable($path))
	{
		echo 'Writable';

		$files_to_zip=scandir($path);
		//if true, good; if false, zip creation failed
		try{
			$result = create_zip($files_to_zip,'my-archive.zip');
		}catch (Exception $e) {
		    throw $e->getMessage();
		}

	}else{
		echo 'It is not possible to create zip.! please change permission of folder.';
	}




?>
