# PDF Functionality Web Application

This web application is built using **PHP Laravel** and offers PDF processing features for both **authenticated users** and **guest users**.

---

## 🚀 Features

- Built with the **Laravel** PHP framework
- Supports PDF creation and manipulation
- Accessible to both **logged-in** users and **guests**

---

## 🛠️ Installation & Setup

Before using the website, run the following commands to install dependencies and clear caches:

```bash
#server setup
sudo apt install apache2 -y  #Install Apache
php --version
mysql --version
sudo systemctl enable apache 2 
cd /var/www/html  #Place you project folder in this directory
sudo chown -R www-data:www-data /var/www/project-name #set file permission
sudo -R 775 /var/www/html/pdfthisthat/storage /var/www/html/pdfthisthat 
/etc/apache2/sites-available/pdfthisthat.conf # created conf file 
Created the database for PDFthisthat in phpmyadmin #db creation

APP_NAME=Laravel #add the details in the .env files
APP_ENV=production
APP_KEY=       
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_CONNECTION=mysql
DB_HOST=host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password


# Clear Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

#Generate key
php artsian key:generate
composer dump-autoload

#restart apache and myssql
sudo systemctl restart mysql
sudo systemctl restart apache2

# Install required PHP PDF libraries
composer require mpdf # protect pdf
composer require fpdf # jpg to pdf
composer require fpdi # Organize pdf
composer require chrome-php/chrome # Html to pdf
composer require thiagoalessio/tesseract_ocr # OCR pdf
composer require phpoffice/phpword # word to pdf
composer require phpoffice/phpspreadsheet # Excel to pdf
composer require smalot/pdfparser # compare pdf

# System-level dependencies (install manually)
# Imagick
sudo apt install php-imagick imagemagick   # For Ubuntu/Debian
brew install imagemagick                   # For macOS
pecl install imagick                       # Then enable in php.in
sudo apt install ghostscript               # For Ubuntu/Debian
brew install ghostscript                   # For macOS
sudo apt install chromium-browser          # For Ubuntu/Debian
brew install --cask chromium               # For macOS
sudo apt install tesseract-ocr y           #install tesseract


## Database Connection 
This application requires a MySQL-compatible database. Make sure you have a database created with the required structure and update the details in the .env file by providing the appropriate values.
Database with two required tables: users and files.

users table:
| Name                | Type         | Primary Key |
| ------------------- | ------------ | ----------- |
| id                  | bigint(100)  | Yes         |
| name                | varchar(255) | No          |
| google_id          | varchar(255) | No          |
| email               | varchar(255) | No          |
| email_verified_at | timestamp    | No          |
| password            | varchar(255) | No          |
| remember_token     | varchar(100) | No          |
| created_at         | timestamp    | No          |
| updated_at         | timestamp    | No          |

files Table:
| Name                 | Type         | Primary Key |
| -------------------- | ------------ | ----------- |
| file_id             | bigint(100)  | Yes         |
| user_id             | bigint(100)  | No          |
| original_file_name | varchar(255) | No          |
| input_file          | longtext     | No          |
| operation            | varchar(255) | No          |
| output_file_name   | varchar(255) | No          |
| file                 | longtext     | No          |
| date                 | timestamp    | No          |
| status               | varchar(255) | No          |

## Google Auh
Created the Google Auth credentiala from the Google Cloude Console 
Go to: https://console.cloud.google.com/
Create a new project.
Go to APIs & Services > Library → Enable "Google People API"
Go to OAuth consent screen → Choose External → Fill basic info → Save.
Go to Credentials → Click Create Credentials > OAuth client ID
Choose Web application
Set redirect URI:
http://...../auth/google/callback

Copy the Client ID and Client Secret
added those creadentials into the .env file


##SSL
sudo apt install certbot puthon3-certbot-apache
sudo apache2ctl configtest
sudo systemctl reload apache2
sudo ufw allow 'Apache Full'
sudo ufw status
sudo ufw delete 'Apache Full'
sudo ufw status
sudo certbot --apache
sudo systemctl status status certbot.timer
sudo certbot --apache
sudo certbot renew --dry-run


