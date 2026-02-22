<?php
$apiKey = '586f9151ef4127ab5ce6ec8198946c665e26c492'; // move to env var later!
$query = $_GET['q'] ?? '';

if ($query) {
    $url = 'https://google.serper.dev/search';
    $data = json_encode(['q' => $query]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-API-KEY: ' . $apiKey,
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($response, true)['organic'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>xlp.dot search engine</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <h1>xlp.dot search engine</h1>

  <form method="get">
    <input type="search" name="q" value="<?= htmlspecialchars($query) ?>" size="50" autofocus>
    <button type="submit">Search</button>
  </form>

  <?php if ($query): ?>
    <h2>Results for "<?= htmlspecialchars($query) ?>"</h2>
    <?php foreach ($results as $r): ?>
      <div>
        <h3><a href="<?= htmlspecialchars($r['link']) ?>"><?= htmlspecialchars($r['title']) ?></a></h3>
        <p><?= htmlspecialchars($r['snippet']) ?></p>
        <small><?= htmlspecialchars($r['link']) ?></small>
        <hr>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
