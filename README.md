# lennis-dev's email-obfuscater

> You all know the problem with email spam, I have a simple solution

I have written a small tool that allows you to disguise your email address on your site and hide it from crawlers, the user has no major restriction except that Javascript must be enabled in the browser. and the best thing is it's no big effort for you, you just have to paste your email in a text field and your browser creates a code that you then paste on your website at the place where the email address should be.

## Try it

try it now on my github page: [Link](https://lennis-dev.github.io/email-obfuscater/)

## How does it work?

This tool encodes your email address in base64 and splits this base64 character string into different sized parts and reverses the order.

the browser splits the string back into the different parts and inverts the sequence again, then decodes the valid base64 code. After that it creates a new link element with the email address and the matching mailto link. finally it inserts this element on the page at the position where the code was.
