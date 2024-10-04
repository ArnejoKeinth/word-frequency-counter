<?php
session_start();

function tokenizeText($text) {
    $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', strtolower($text));

    $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

    $splitWords = [];
    foreach ($words as $word) {
        if (is_numeric($word)) {
            $splitWords = array_merge($splitWords, str_split($word));
        } else {
            $splitWords[] = $word;
        }
    }

    return $splitWords;
}

function calculateWordFrequency($words, $stopWords) {
    $frequency = array_count_values($words);
    foreach ($stopWords as $word) {
        unset($frequency[$word]);
    }
    return $frequency;
}

function sortWordFrequency($frequency, $order) {
    if ($order === 'asc') {
        asort($frequency);
    } else {
        arsort($frequency);
    }
    return $frequency;
}

$text = '';
$sort = 'desc';
$limit = 20;
$results = null;

if (isset($_SESSION['results'])) {
    $results = $_SESSION['results'];
    unset($_SESSION['results']);
}

if (isset($_SESSION['text'])) {
    $text = $_SESSION['text'];
    unset($_SESSION['text']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['text'])) {
    $text = $_POST['text'];
    $sort = $_POST['sort'];
    $limit = intval($_POST['limit']);

    $stopWords = ['the', 'and', 'in', 'to', 'of', 'a', 'is', 'it', 'that', 'with', 'as', 'for', 'on', 'was', 'but', 'by', 'are', 'this', 'or', 'an', 'be', 'not', 'at', 'from', 'which'];
    $words = tokenizeText($text);
    $frequency = calculateWordFrequency($words, $stopWords);
    $sortedFrequency = sortWordFrequency($frequency, $sort);
    $results = array_slice($sortedFrequency, 0, $limit, true);

    $_SESSION['results'] = $results;
    $_SESSION['text'] = $text;

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <form method="post">
        <label for="text">Paste your text here:</label>
        <textarea id="text" name="text" rows="10" required><?php echo htmlspecialchars($text); ?></textarea>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc" <?php echo $sort === 'asc' ? 'selected' : ''; ?>>Ascending</option>
            <option value="desc" <?php echo $sort === 'desc' ? 'selected' : ''; ?>>Descending</option>
        </select>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="<?php echo htmlspecialchars($limit); ?>" min="1">
        
        <input type="submit" value="Calculate Word Frequency">
    </form>

    <?php if ($results): ?>
    <h2>Results</h2>
    <div class="output-container">
        <table>
            <tr>
                <th>Word</th>
                <th>Frequency</th>
            </tr>
            <?php foreach ($results as $word => $count): ?>
            <tr>
                <td><?php echo htmlspecialchars($word); ?></td>
                <td><?php echo $count; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
</body>
</html>
