# 🦊 FoxContact Automator

> **The Ultimate Multi-Threaded Exploit Tool for Joomla Com_FoxContact**

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Security](https://img.shields.io/badge/Security-Exploit-red?style=for-the-badge&logo=kalilinux&logoColor=white)
![Multi-Threaded](https://img.shields.io/badge/Speed-Blazing-orange?style=for-the-badge&logo=speedtest&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

## 🚀 Overview

**FoxContact Automator** is a modernized, high-performance exploitation framework designed to audit the critical **Arbitrary File Upload** vulnerability (CVE-2016-\*\*\*\*) in the Joomla `com_foxcontact` component.

By replacing legacy sequential scripts with asynchronous **`curl_multi`** architecture, this tool achieves **100x faster** scan rates while maintaining high accuracy through intelligent verification.

---

## ✨ Key Features

| Feature                      | Description                                                               |
| :--------------------------- | :------------------------------------------------------------------------ |
| **⚡ Turbo Multi-Threading** | Scan hundreds of targets concurrently with optimized resource management. |
| **🧠 Smart ID Extraction**   | Regex-based engine parses HTML to auto-fill `cid` & `mid` parameters.     |
| **🛡️ Evasion Logic**         | Generates random obfuscated filenames to bypass WAF signatures.           |
| **🎯 Cluster Fuzzing**       | Simultaneously tests component, module, and legacy paths per target.      |
| **✅ Zero-False Verify**     | Performs a secondary HTTP check to confirm shell execution.               |

---

## ⚙️ Prerequisites

Ensure your environment meets these requirements:

- **PHP 7.4** or higher
- **cURL Extension** (enabled in `php.ini`)
- **CLI Access** (Terminal/Command Prompt)

---

## 🛠️ Installation & Usage

### 1. Clone & Setup

```bash
git clone https://github.com/yourusername/fox-automator.git
cd fox-automator
```

### 2. Auto-Dorking (Optional)

Use the built-in dorker to find targets automatically:

```bash
php fox_dorker.php
```

_This will scrape Google and append results to `targets.txt`._

### 3. Run the Automator

```bash
php fox_automator.php targets.txt [threads]
```

#### Examples

**Standard Scan (Default 10 threads):**

```bash
php fox_automator.php targets.txt
```

**High-Performance Scan (50 threads):**

```bash
php fox_automator.php targets.txt 50
```

---

## � Output & Reporting

The tool provides real-time CLI feedback and persistent logging:

- **Console:** Live progress bar and vulnerability alerts.
- **Log File:** Successful exploits are saved to `vuln_fox.txt`.

**Sample Output:**

```text
[VULN] http://target.com -> http://target.com/components/com_foxcontact/idx_a1b2c3.php
```

---

## ❓ Troubleshooting

**Q: I get "Call to undefined function curl_multi_init()"**
_A: Your PHP installation is missing cURL. Install it via `apt-get install php-curl` or enable it in `php.ini`._

**Q: The tool stops after a few targets.**
_A: Check your internet connection or reduce the thread count to avoid strict firewalls (e.g., set threads to 5)._

---

## ⚠️ Legal Disclaimer

> [!CAUTION] > **Use Responsibly.**
> This software is provided for educational purposes and authorized penetration testing **ONLY**.
>
> - Do not use against servers you do not own or have explicit permission to test.
> - The authors assume **NO LIABILITY** for damage caused by this tool.

---

_Created with ❤️ by Antigravity_
