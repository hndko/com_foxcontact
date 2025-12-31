<?php

/**
 * FoxContact Auto Dorker
 * Scrapes Google for vulnerable targets and saves them to targets.txt
 */

error_reporting(0);
set_time_limit(0);

// Configuration
$dork = '';
if (isset($argv[1])) {
    // allow running like: php fox_dorker.php "inurl:..."
    $dork = $argv[1];
} else {
    // Ask for input
    echo "Enter Dork (e.g., inurl:com_foxcontact): ";
    $handle = fopen("php://stdin", "r");
    $dork = trim(fgets($handle));
    fclose($handle);
}

if (empty($dork)) {
    die("Error: No dork provided.\n");
}
$outputFile = 'targets.txt';
$pagesToDork = 5; // Number of pages to scrape (Caution: too high = captcha)

$userAgents = [
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36",
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:90.0) Gecko/20100101 Firefox/90.0",
    "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.96 Safari/537.36"
];

print "\n[+] Starting Auto Dorker...\n";
print "[+] Dork: $dork\n";
print "[+] Output: $outputFile\n";
print "------------------------------------\n";

$foundCount = 0;

for ($i = 0; $i < $pagesToDork; $i++) {
    $start = $i * 10;
    print "[*] Scraping Page " . ($i + 1) . "...\n";

    $ua = $userAgents[array_rand($userAgents)];
    $url = "https://www.google.com/search?q=" . urlencode($dork) . "&start=$start";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    curl_setopt($ch, CURLOPT_COOKIE, "CONSENT=YES+"); // Try to bypass consent

    // Add random delay to look human
    sleep(rand(2, 5));

    $result = curl_exec($ch);
    curl_close($ch);

    if (!$result) {
        print "[-] Failed to fetch page.\n";
        continue;
    }

    // Check for CAPTCHA
    if (strpos($result, 'google.com/sorry/index') !== false) {
        print "\n[!] CAPTCHA blocked! Google is blocking requests.\n";
        print "[!] Stopping dorker.\n";
        break;
    }

    // Parse URLs
    // Regex to find links starting with http that contain com_foxcontact
    // This is a naive regex but works for basic Google DOM

    // Google's structure changes often, but typically links are in <a href="/url?q=..."
    preg_match_all('#/url\?q=(http[^&]+)&#', $result, $matches);

    if (empty($matches[1])) {
        // Try alternate parsing for newer Google layouts
        preg_match_all('#<a href="(https?://[^"]+)"#', $result, $rawLinks);
        if (!empty($rawLinks[1])) {
            foreach ($rawLinks[1] as $link) {
                if (strpos($link, 'google') === false && strpos($link, 'com_foxcontact') !== false) {
                    saveTarget($link, $outputFile);
                    $foundCount++;
                }
            }
        }
    } else {
        foreach ($matches[1] as $link) {
            $decoded = urldecode($link);
            if (strpos($decoded, 'com_foxcontact') !== false) {
                saveTarget($decoded, $outputFile);
                $foundCount++;
            }
        }
    }
}

print "------------------------------------\n";
print "[+] Dorking Complete.\n";
print "[+] Total New Targets Found: $foundCount\n";


function saveTarget($url, $file)
{
    // Basic deduplication
    $current = file_exists($file) ? file_get_contents($file) : '';
    if (strpos($current, $url) === false) {
        file_put_contents($file, $url . PHP_EOL, FILE_APPEND);
        print "    [+] Found: $url\n";
    }
}
