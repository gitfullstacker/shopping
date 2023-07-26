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

$url = "https://www.ablanc.co.kr/admincenter/files/boad/2/";
$destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/admincenter/files/boad/2/";

if (!is_dir($destinationPath)) {
    mkdir($destinationPath, 0777, true);
}

$SQL_QUERY =    'SELECT 
                    IMG_SEQ, IMG_F_NAME
                FROM 
                    `' . $Tname . 'b_img_data@01`
                WHERE 
                    IMG_F_NAME COLLATE utf8_general_ci REGEXP "[가-힣]"';


$image_list_result = mysql_query($SQL_QUERY);

while ($row = mysql_fetch_assoc($image_list_result)) {
    if (hasKoreanCharacters($row['IMG_F_NAME'])) {
        $imageFileName = $row['IMG_F_NAME'];

        $result = downloadFile($url . $imageFileName, $destinationPath);

        if ($result) {
            $SQL_QUERY = 'UPDATE `' . $Tname . 'b_img_data@01` SET IMG_F_NAME="' . $result . '", IMG_F_NICK="' . $result . '" WHERE IMG_SEQ=' . $row['IMG_SEQ'];
            mysql_query($SQL_QUERY);
            echo "Image downloaded and saved successfully! - " . $result;
        } else {
            echo "Failed to download or save the image.";
        }
    }
}
?>