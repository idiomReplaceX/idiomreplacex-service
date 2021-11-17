# IdiomReplaceX service

## Testing

with httpie:

~~~
http --verify false  'https://bgbm14463lap/service/methods'     
http --verify false  'https://bgbm14463lap/service/filter' Content-Type:"application/json"  html="hallo du <strong>welt</strong>, wie geht es dir? Hoffe du hast kein Fieber" htmlChecksum="435335345"     
~~~

## Troubleshooting

**Class not found?**

Try `composer dump-autoload` to update the autoloader cache

## Web-Servers

### Apache configuration

(see https://github.com/mikecao/flight)

Ensure that the Apache mod_rewrite module is installed and enabled. In order to enable mod_rewrite you can type the following command in the terminal:

~~~
sudo a2enmod rewrite
sudo a2enmod actions
~~~

Ensure your .htaccess and index.php files are in the same public-accessible directory. The .htaccess file should contain this code:

~~~
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
~~~

This .htaccess file requires URL rewriting.

Make sure to enable Apache’s mod_rewrite module and your virtual host is configured with the AllowOverride option so that the .htaccess rewrite rules can be used: To do this, the file /etc/apache2/apache2.conf must be opened in an editor with root privileges.

Change the <Directory ...> directive from AllowOverride None to AllowOverride All.

Example

~~~
<Directory /var/www/idiomreplacex-service/src>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted
</Directory>
~~~

Finally, the configuration of Apache must be reloaded. To restart Apache web server, enter:

~~~
sudo service apache2 restart
~~~

This command works on most Debian/Ubuntu variants. For all other Linux distributions, please consult the documentation of your specific Linux distribution to find out how to restart Apache.

Running in a sub-directory

This example assumes that the front controller is located in `src/index.php`.

To “redirect” the sub-directory to the front-controller create a second .htaccess file above the public/ directory.

The second .htaccess file should contain this code:

~~~
RewriteEngine on
RewriteRule ^$ src/ [L]
RewriteRule (.*) src/$1 [L]
~~~

## Controller end points

* POST|GET /filter(/@method)
* GET /methods

