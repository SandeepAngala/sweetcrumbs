<?php
// Script to scan resources/views for emoji characters in blade files

function get_emojis($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $regex = '/[\x{1F300}-\x{1F9FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u';
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'blade' || str_ends_with($file->getFilename(), '.blade.php')) {
            $content = file_get_contents($file->getPathname());
            if (preg_match_all($regex, $content, $matches, PREG_OFFSET_CAPTURE)) {
                echo "File: " . $file->getPathname() . "\n";
                foreach ($matches[0] as $match) {
                    $char = $match[0];
                    $offset = $match[1];
                    // Get line number
                    $line = substr_count(substr($content, 0, $offset), "\n") + 1;
                    // Get line content
                    $lines = explode("\n", $content);
                    $lineContent = isset($lines[$line - 1]) ? trim($lines[$line - 1]) : '';
                    echo "  Line {$line}: '{$char}' -> {$lineContent}\n";
                }
                echo "\n";
            }
        }
    }
}

get_emojis('resources/views');
