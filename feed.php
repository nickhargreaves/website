<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/rss+xml; charset=utf-8");
header("Cache-Control: public, max-age=3600");

$cache = __DIR__ . "/feed-cache.xml";
$ttl   = 3600;

if (file_exists($cache) && (time() - filemtime($cache)) < $ttl) {
    readfile($cache);
    exit;
}

$ctx = stream_context_create([
    "http" => [
        "method"  => "GET",
        "header"  => "User-Agent: Mozilla/5.0 (compatible; FeedFetcher)\r\n",
        "timeout" => 10,
    ],
]);

$feed = @file_get_contents("https://medium.com/feed/@nickhargreaves", false, $ctx);

if ($feed === false) {
    if (file_exists($cache)) {
        readfile($cache);
    } else {
        http_response_code(502);
        echo "<!-- Could not fetch feed -->";
    }
    exit;
}

file_put_contents($cache, $feed);
echo $feed;
