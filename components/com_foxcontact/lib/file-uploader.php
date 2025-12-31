<?php
// Mock Target for com_foxcontact Vulnerability
// Simulates the upload behavior and insecure file handling

$logFile = 'mock_log.txt';
$uploadDir = __DIR__;

// Log the request
$log = date('Y-m-d H:i:s') . " - Request: " . $_SERVER['REQUEST_URI'] . "\n";
file_put_contents($logFile, $log, FILE_APPEND);

// Simulate "cid" scrapeable content
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['qqfile'])) {
    echo '<html><body>
    <h1>Welcome to Mock Target</h1>
    <form>
        <input type="hidden" name="cid_123" value="1">
        <input type="hidden" name="mid_456" value="1">
    </form>
    </body></html>';
    exit;
}

// Simulate Upload Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $headers = getallheaders();

    // Check for Exploit Headers
    if (isset($headers['X-File-Name'])) {
        $fileName = $headers['X-File-Name'];

        // EXPLOIT SIMULATION:
        // The real exploit uses path traversal.
        // If we are running in /lib/, saving to parent (../) puts it in component root.
        // We simulate this success if the filename matches what the exploit sends regardless of actual traversal logic here.

        $fileName = basename($fileName); // Safety first

        $content = file_get_contents('php://input');

        // If we are in lib (detected by path), go up one level
        if (strpos(__DIR__, 'lib') !== false) {
            file_put_contents(__DIR__ . '/../' . $fileName, $content);
        } else {
            // Fallback for root mock
            file_put_contents(__DIR__ . '/' . $fileName, $content);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No X-File-Name']);
    }
}
