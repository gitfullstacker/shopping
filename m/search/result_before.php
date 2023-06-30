<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?php
$search_key = $_GET['search_key'] ?: '';

if ($search_key) {
    $searchHistory = isset($_COOKIE['SEARCH_KEY_DATA']) ? unserialize(stripslashes($_COOKIE['SEARCH_KEY_DATA'])) : array();

    if (!in_array($search_key, $searchHistory)) {
        $searchHistory[] = $search_key;

        $maxHistorySize = 20;
        if (count($searchHistory) > $maxHistorySize) {
            $searchHistory = array_slice($searchHistory, -1 * $maxHistorySize);
        }

        $cookieValue = serialize($searchHistory);
        setcookie('SEARCH_KEY_DATA', $cookieValue, time() + (86400 * 30), '/'); // Cookie expiry set to 30 days
    }
}

?>

<script>
    url = "result.php";
    url += "?search_key=<?= $search_key ?>";

    document.location.href = url;
</script>

<?php
exit;
