#!/usr/bin/php
<?php
$watchDir = '/home/markcgv/git/Builds';

$apacheRestartCmd = 'sudo systemctl restart apache2';

$inotifyCmd = "inotifywait -m -e create '$watchDir'";

echo "Monitoring directory: $watchDir for new files...\n";
echo "Press [Ctrl+C] to stop.\n";

$handle = popen($inotifyCmd, 'r');

if ($handle) {
    while (!feof($handle)) {
        $line = fgets($handle);
        if ($line) {
            echo "New file detected: $line";
            echo "Restarting Apache...\n";
            exec($apacheRestartCmd, $output, $returnVar);

            if ($returnVar === 0) {
                echo "Apache restarted successfully!\n";
            } else {
                echo "Failed to restart Apache. Check permissions or system logs.\n";
            }
        }
    }
    pclose($handle);
} else {
    echo "Failed to start inotifywait.\n";
}
?>

