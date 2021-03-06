<?php
/*Copyright (c) 2009, 2017, Dan "Ducky" Little & GeoMOOSE.org

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.*/

/*
 * File: download.php
 * Serves a file from the temp with the proper mimetype based
 * on the id and extension.
 *
 */

include('config.php');
$tempDir = $CONFIGURATION['temp'];

$id = $_REQUEST['id'];
$ext = $_REQUEST['ext'];
$as_download = $_REQUEST['download'];

# test that ID is only letters, numbers, underscores, and dashes
if(preg_match("/^[a-zA-Z0-9_\-]+$/", $id) !== 1) {
	http_response_code(404);
	echo "Not found";
# ensure that the extension is only letters.
} else if(preg_match("/^[a-zA-Z]+$/", $ext) !== 1) {
	http_response_code(404);
	echo "Not found (ext).";
# validation has passed, return the file.
} else {

	$mimetypes = array(
		'pdf' => 'application/pdf',
		'jpeg' => 'image/jpeg',
		'png' => 'image/png',
		'gif' => 'image/gif',
		'html' => 'text/html',
		'csv' => 'text/csv'
	);

	header('Content-type: '.$mimetypes[$ext]);
	if($as_download == 'true') {
		header('Content-Disposition: attachment; filename=download_'.getmypid().time().'.'.$ext);
	}
	readfile($tempDir.$id.'.'.$ext);
}
?>
