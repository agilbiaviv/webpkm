<?php
$filePath = 'uploads/test.txt';
file_put_contents($filePath, 'This is a test file.');

if (file_exists($filePath)) {
    echo 'File created successfully: ' . $filePath;
} else {
    echo 'Failed to create file.';
}
