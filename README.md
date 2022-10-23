# cvat_chat
***********
# Installation
```bash
git clone https://github.com/delltaxa/cvat_chat.git
cd cvat_chat/
chmod +x ./clean_chat
```
***********
# Usage
Install apache2, php-cli, xampp, etc. to host the page

php-cli Example:

```bash
cd cvat_chat/
php -sS 127.0.0.1:80
```

How to change your Password:

edit the config.php file
and replace the default value "`!***1FA45BD90***`"
with your custom password

***********
# Info
All the caht messages are encrypted with aes256
(without an vi) you can change that by editing the
endecr.php file and change the "00000000000...." value
with an other string (atleast 16 chars long)
***********
# Warning
On chromium based browsers it's buggy basically it refershes the site in a 
while loop until you switch back to the login screen
(just don't try it) (fix will come out soon)
