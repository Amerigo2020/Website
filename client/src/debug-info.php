<?php
header('Content-Type: text/plain');
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script: " . __FILE__ . "\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "vendor/autoload.php exists: " . (file_exists(__DIR__ . '/vendor/autoload.php') ? 'YES' : 'NO') . "\n";
echo "includes/blog-helpers.php exists: " . (file_exists(__DIR__ . '/includes/blog-helpers.php') ? 'YES' : 'NO') . "\n";
echo "content/posts dir exists: " . (is_dir(__DIR__ . '/content/posts') ? 'YES' : 'NO') . "\n";
echo "\nDirectory listing of __DIR__:\n";
foreach (scandir(__DIR__) as $item) echo "  " . $item . "\n";
