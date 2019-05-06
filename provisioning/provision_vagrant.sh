#!/bin/bash

echo "Updating packages..."
apt-get -y update >/dev/null 2>&1
echo "Adding repo lists..."
apt-get install python-software-properties -y >/dev/null 2>&1
add-apt-repository ppa:ondrej/php -y >/dev/null 2>&1
apt-get -y update >/dev/null 2>&1
echo "Installing Dependencies..."
apt-get install -y php7.2-cli composer php7.2-zip unzip apache2 php7.2 libapache2-mod-php7.2 php7.2-mysql php7.2-mbstring mysql-client apache2-utils >/dev/null 2>&1
echo "Installing MySQL..."
sudo apt-get install debconf-utils -y > /dev/null 2>&1
debconf-set-selections <<< "mysql-server mysql-server/root_password password password" > /dev/null 2>&1
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password password" > /dev/null 2>&1
sudo apt-get -y install mysql-server > /dev/null 2>&1
echo "Creating database..."
mysql -u root -ppassword -e "CREATE DATABASE curlit" >/dev/null 2>&1
echo "Making MySql accessible over network..."
sed -i '43s!127.0.0.1!0.0.0.0!' /etc/mysql/mysql.conf.d/mysqld.cnf
echo "Restarting MySql Service..."
service mysql restart
echo "Updating SQL Permissioins..."
mysql -u root -ppassword -e "USE mysql;UPDATE user SET host='%' WHERE User='root';GRANT ALL ON *.* TO 'root'@'%';FLUSH PRIVILEGES;" >/dev/null 2>&1
echo "Removing placeholder index file..."
rm /var/www/html/index.html
echo "Setting site root..."
sed -i '12s!/var/www/html!/var/www/html/public!' /etc/apache2/sites-enabled/000-default.conf
sed -i '164s!/var/www!/var/www/html/public!' /etc/apache2/apache2.conf
echo "Enabling modrewrite..."
a2enmod rewrite
sed -i '155s!None!All!' /etc/apache2/apache2.conf
sed -i '166s!None!All!' /etc/apache2/apache2.conf
echo "Restarting Apache Service..."
service apache2 restart
echo "Installing CurlIt..."
cd /var/www/html/
composer install >/dev/null 2>&1
echo "Done!"
echo "MySql Credentials: [ Username = root, Password = password, Database = synful ]"
echo "You can access your CurlIt Instance at one of the following addresses:";for ip in $( hostname -I ); do echo "    http://"$ip"/"; done;