<?php
set_time_limit(300);

// Set the timezone to your desired timezone
date_default_timezone_set('America/New_York');

// Define the directory to be zipped
$directory = '../www';

// Create a zip filename using the current timestamp
$zipname = 'backup_' . date('Ymd_His') . '.zip';

// Create a ZipArchive object
$zip = new ZipArchive();

// Open the zip file for writing
if ($zip->open($zipname, ZIPARCHIVE::CREATE) !== TRUE) {
    exit("Could not open zip file for writing.");
}

// Add all the files in the directory to the zip file
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($directory) + 1);
        $zip->addFile($filePath, $relativePath);
    }
}

// Close the zip file
$zip->close();

echo "Backup created: $zipname";