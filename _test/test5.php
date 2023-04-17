<?
$url = 'https://www.youtube.com/watch?v=GY2yZlEh49I'; 
$id = str_replace('https://www.youtube.com/watch?v=', '', $url); 
$content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
parse_str($content, $data);
echo "제목 : " . $data['title'];
echo '<br>';
echo "조회수 : " . $data['view_count'];
?>