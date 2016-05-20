<?php

/*
place this file to server and then download output of this file
wget -O download.sh 'http://example.com/downloadeverything.php'
and then run:
chmod a+x download.sh && ./download.sh
and in directory you have this download.sh located every file/folder from server will be downloaded
 */

// root dir from where every file will be downloaded
$dir = __DIR__;

ini_set('display_errors', 0);

$filelist = array();
$dirs = array();

$getjson = isset($_GET['getjson']);


function listfiles($dirscan) {
	global $dir;
	global $filelist;
	global $dirs;

	$files = scandir($dirscan);
	foreach ($files as $file) {
		if ($file == '.' || $file == '..') { continue; }

		$full = $dirscan . '/' . $file;
		$rel = ltrim(str_replace($dir, '', $full), '/');

		if (!is_dir($file)) {
			$filelist[$rel] = filesize($full);
			continue;
		}
	}


	foreach ($files as $file) {
		if ($file == '.' || $file == '..') { continue; }

		$full = $dirscan . '/' . $file;
		$rel = ltrim(str_replace($dir, '', $full), '/');

		if (is_dir($file)) {
			$dirs[] = $rel;
			listfiles($full);
			continue;
		}
	}
}


listfiles($dir);

if (!empty($_GET['getfile'])) {
	$getfile = (string)$_GET['getfile'];
	if (isset($filelist[$getfile])) {
		$full = $dir . '/' . $getfile;
    if (function_exists('mime_content_type')) {
      header('Content-Type: ' . mime_content_type($full));
    }
		readfile($full);
	} else {
		header('HTTP/1.1 500 Internal Server Error');
	}
	exit;
}

if ($getjson) {
	header('Content-Type: application/json');
	echo json_encode(array(
			'sizesum' => array_sum($filelist),
			'count' => count($filelist),
			'files' => $filelist
	));
	exit;
}


header('Content-Type: text/plain');

$url_root = $_SERVER['REQUEST_SCHEME'] .'://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

echo "#download this file\n";
echo "#wget -O download.sh " . escapeshellarg($url_root) .  "\n";
echo "#and then run:\n";
echo "#chmod a+x download.sh && ./download.sh\n";
echo "#\n";

foreach ($dirs as $dir_create) {
	echo "mkdir -p " . escapeshellarg($dir_create) . "\n";
}

foreach ($filelist as $file => $size) {
	$urlDownload = $url_root . '?' . http_build_query(array('getfile' => $file));
	echo "echo " . escapeshellarg("download " . ++$downloaded . "/" . count($filelist)) . "\n";
	echo "wget -O " . escapeshellarg($file) . " " . escapeshellarg($urlDownload) .  "\n";
}
