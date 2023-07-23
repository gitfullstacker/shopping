<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
// Set a higher maximum execution time (e.g., 1200 seconds)
set_time_limit(1200);

function hasKoreanCharacters($string)
{
    // Regular expression pattern to match Korean characters
    $pattern = '/[\x{AC00}-\x{D7AF}|\x{1100}-\x{11FF}|\x{3130}-\x{318F}|\x{A960}-\x{A97F}|\x{D7B0}-\x{D7FF}]+/u';

    // Check if the string matches the pattern
    return preg_match($pattern, $string);
}

function downloadFile($url, $localPath)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $fileData = curl_exec($ch);

    if ($fileData === false) {
        echo "cURL Error: " . curl_error($ch);
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    // Set a random file name for the downloaded file
    $originalFileName = basename($url); // Extract the original file name from the URL
    $randomFileName = getRandomFileName($originalFileName);
    $destinationPath = $localPath . $randomFileName;

    // Save the file locally using file_put_contents
    $result = file_put_contents($destinationPath, $fileData);

    if ($result === false) {
        echo "Failed to save the file locally.";
        return "";
    }

    return $randomFileName;
}

$url = "https://www.ablanc.co.kr/admincenter/files/bann/";
$destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/bann/";

if (!is_dir($destinationPath)) {
    mkdir($destinationPath, 0777, true);
}

$SQL_QUERY =    'SELECT 
                    INT_NUMBER, STR_IMAGE1
                FROM 
                    `' . $Tname . 'comm_banner`
                WHERE 
                    STR_IMAGE1 COLLATE utf8_general_ci REGEXP "[가-힣]"';


$image_list_result = mysql_query($SQL_QUERY);

while ($row = mysql_fetch_assoc($image_list_result)) {
    for ($i = 1; $i <= 12; $i++) {
        if (hasKoreanCharacters($row['STR_IMAGE' . $i])) {
            $imageFileName = $row['STR_IMAGE' . $i];

            $result = downloadFile($url . $imageFileName, $destinationPath);

            if ($result) {
                $SQL_QUERY = 'UPDATE ' . $Tname . 'comm_banner SET STR_IMAGE1="' . $result . '" WHERE INT_NUMBER=' . $row['INT_NUMBER'];
                mysql_query($SQL_QUERY);
                echo "Image downloaded and saved successfully! - " . $result;
            } else {
                echo "Failed to download or save the image.";
            }
        }
    }
}
?>