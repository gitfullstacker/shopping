<?php
set_time_limit(300);

$zip = new ZipArchive;
$res = $zip->open('/admincenter/files.zip');
if ($res === TRUE) {
  $zip->extractTo('/admincenter/files');
  $zip->close();
  echo 'Extraction complete!';
} else {
  echo 'Extraction failed. Error code: ' . $res;
}
