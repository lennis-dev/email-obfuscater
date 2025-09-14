<?php
/*
Plugin Name: lennis-dev's email-obfuscater
Plugin URI: https://github.com/lennis-dev/email-obfuscater
Description: Obfuscates email addresses, which makes it difficult for spam bot to crawl your emails address
Version: 1.0.2
Author: Lennis Jaumann
Author URI: https://github.com/lennis-dev
License: GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
/* Filter – Email Obfuscater Integration */

add_filter("the_content", "fn_emailObfuscater");
add_filter("wp_footer", "fn_emailObfuscater");

/**
 * Obfuscates email addresses, which makes it difficult for spam bot to crawl your emails address
 * @param string $content Content of the post
 * @return string Content of the post with obfuscated emails
 */
function fn_emailObfuscater(string $content): string
{
    // while match replace emails
    while (
        preg_match(
            "/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)/",
            $content,
            $matches,
        )
    ) {
        $mailBase64 = base64_encode($matches[0]); // encode email
        $mailExplode = str_split($mailBase64, 1); // split email
        $length = count($mailExplode); // get length of encoded email
        $offset = $length;
        $pairs = [];
        while ($offset > 0) {
            // create random pairs
            $max = min($offset, 8); // max 8 chars per pair
            $rand = rand(1, $max); // random number between 1 and max
            $string = ""; // create string
            for ($i = 0; $i < $rand; $i++) {
                // add a random number of chars to string
                $string .= $mailExplode[$length - $offset];
                $offset--;
            }
            $pairs[] = $string; // add string to pairs
        }
        $emailObfuscated = implode("?", array_reverse($pairs)); // reverse pairs and implode
        $mailCode =
            '<script>var a=atob("' .
            $emailObfuscated .
            '".split("?").reverse().join("")),b=document.createElement("a");b.innerText=a;b.href="mailto:"+a;document.currentScript.replaceWith(b);</script>'; // create mailto link
        $content = str_replace($matches[0], $mailCode, $content); // replace email with mailto link
    }
    return $content; // return content
}
