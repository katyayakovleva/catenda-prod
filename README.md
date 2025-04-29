# Table of Contents

1. [WordPress Website Migration Guide](#1-wordpress-website-migration-guide)

2. [WordPress Theme Update and Management](#2-wordpress-theme-update-and-management)




# 1.WordPress Website Migration Guide  
*Migrating WordPress to a New Hosting with Domain Change and Server Configuration*



### 1. Preparation Before Migration

- Create a full **backup**:
  - Website files
  - Database

#### Commands to export:

```bash
# Archive website files
cd /var/www/html/
tar -czvf site-backup.tar.gz .

# Export MySQL database
mysqldump -u db_user -p db_name > database-backup.sql
```

- Prepare the new server:
  - Install a web server (Nginx)
  - Install PHP (recommended: PHP 8.3)
  - Install MySQL
  - Configure SSL certificate for the new domain


### 2. Uploading Files to the New Server

- Connect via SSH or FTP
- Create a directory:

```bash
mkdir -p /var/www/new-domain.com
```

- Upload `site-backup.tar.gz` and extract:

```bash
tar -xzvf site-backup.tar.gz -C /var/www/new-domain.com
```

- Adjust permissions:

```bash
chown -R www-data:www-data /var/www/new-domain.com
chmod -R 755 /var/www/new-domain.com
```


### 3. Importing the Database

- Create a new database:

```sql
CREATE DATABASE new_database_name DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'new_db_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON new_database_name.* TO 'new_db_user'@'localhost';
FLUSH PRIVILEGES;
```

- Import the database:

```bash
mysql -u new_db_user -p new_database_name < /path/to/database-backup.sql
```


### 4. Updating WordPress Configuration

Edit `wp-config.php`:

```php
define('DB_NAME', 'new_database_name');
define('DB_USER', 'new_db_user');
define('DB_PASSWORD', 'strong_password');
define('DB_HOST', 'localhost');
```


### 5. Updating Site URL

#### Option 1: Using WP-CLI

```bash
wp search-replace 'old-domain.com' 'new-domain.com' --skip-columns=guid
```

#### Option 2: Using SQL

```sql
UPDATE wp_options SET option_value = replace(option_value, 'old-domain.com', 'new-domain.com') WHERE option_name = 'home' OR option_name = 'siteurl';
UPDATE wp_posts SET guid = replace(guid, 'old-domain.com', 'new-domain.com');
UPDATE wp_posts SET post_content = replace(post_content, 'old-domain.com', 'new-domain.com');
UPDATE wp_postmeta SET meta_value = replace(meta_value,'old-domain.com','new-domain.com');
```


### 6. Configuring the Web Server

#### Example Nginx Configuration:

```nginx

server {
	listen 80;

	server_name new-domain.com www.new-domain.com;
 
    root /var/www/html;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param HTTP_X_FORWARDED_PROTO https;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_param HTTP_HOST $host;
        fastcgi_param REQUEST_URI $request_uri;

        try_files $uri =404; 
   }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|otf|eot|mp4|webm|ogg|mp3|wav)$ {
        expires max;
        log_not_found off;
    }

    location = /xmlrpc.php {
        deny all;
    }

    location ~* /wp-config.php {
        deny all;
    }

    location ~* /wp-admin/includes {
        deny all;
    }

    location ~* /wp-content/uploads/.*\.php$ {
        deny all;
    }

    client_max_body_size 64M;
}
```

- Enable site and reload:

```bash
ln -s /etc/nginx/sites-available/new-domain.com /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```



### 7. Setting Up SSL Certificate

Install SSL using Certbot:

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d new-domain.com -d www.new-domain.com
```

Test auto-renewal:

```bash
certbot renew --dry-run
```



### 8. Final Steps

- Update **DNS A-records** to the new server IP
- Clear browser and server cache
- Verify:
  - Homepage loading
  - Admin dashboard access
  - Site functionality
  - Media uploads and downloads

---


# 2. WordPress Theme Update and Management
*There are three methods for updating the theme on your WordPress website.*
 

## 2.1. Upload New Theme Version from GitHub

To update the **catenda** theme:

1. Download the latest theme archive named `catenda.zip`.
2. In WordPress Admin:
   - Go to **Appearance > Themes > Add New > Upload Theme**.
   - Select `catenda.zip` and click **Install Now**.
   - Activate the theme if needed.

**Alternative method:**

1. Activate another temporary theme.
2. Delete the current **catenda** theme.
3. Upload the new `catenda.zip`.
4. Activate the updated theme.

## 2.2. Modify Theme Files via SSH

Connect via SSH


```bash
ssh username@server-ip
```

Navigate to the theme folder:


```bash
cd /var/www/html/wp-content/themes/catenda/
```
Upload updated files:


```bash
scp -r /path/to/local/theme/files username@server-ip:/var/www/html/wp-content/themes/catenda/

```

If using a zip:

```bash
scp catenda.zip username@server-ip:/var/www/html/wp-content/themes/
ssh username@server-ip
cd /var/www/html/wp-content/themes/
unzip -o catenda.zip
```

Set correct permissions:


```bash
sudo chown -R www-data:www-data /var/www/html/wp-content/themes/catenda/
sudo find /var/www/html/wp-content/themes/catenda/ -type d -exec chmod 755 {} \;
sudo find /var/www/html/wp-content/themes/catenda/ -type f -exec chmod 644 {} \;

```

## 2.3. Modify Theme Files via FTP

1. **Connect to the server via FTP**.

2. **Navigate to** `/wp-content/themes/catenda/`.

3. **Upload updated files**:
    - Either overwrite individual files.
    - Or rename the old `catenda` folder to `catenda_old` and upload the new folder.

4. **Verify file permissions** if possible.

5. **Check the website** after making the changes.
