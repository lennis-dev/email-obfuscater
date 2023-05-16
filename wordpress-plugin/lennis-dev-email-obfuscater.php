<?php
/*
Plugin Name: lennis-dev's email-obfuscater
Plugin URI: https://github.com/lennis-dev/email-obfuscater
Description: Obfuscates email addresses, which makes it difficult for spam bot to crawl your emails address
Version: 1.0
Author: Lennis Jaumann
Author URI: https://github.com/lennis-dev
License: GPL
*/
/* Filter – Email Obfuscater Integration */

add_filter("the_content", "fn_emailObfuscater");
function fn_emailObfuscater($content)
{
	// while match replace emails
	while (preg_match('/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)/', $content, $matches)) {
		$mailBase64 = base64_encode($matches[0]);
		$mailExplode = str_split($mailBase64, 1);
		$length = count($mailExplode);
		$offset = $length;
		$pairs = array();
		while ($offset > 0) {
			$max = min($offset, 8);
			$rand = rand(1, $max);
			$string = '';
			for ($i = 0; $i < $rand; $i++) {
				$string .= $mailExplode[$length - $offset];
				$offset--;
			}
			$pairs[] = $string;
		}
		$emailObfuscated = implode("?", array_reverse($pairs));
		$mailCode = '<script>var a=atob("' . $emailObfuscated . '".split("?").reverse().join("")),b=document.createElement("a");b.innerText=a;b.href="mailto:"+a;document.currentScript.replaceWith(b);</script>';
		$content = str_replace($matches[0], $mailCode, $content);
	}
	return $content;
}
