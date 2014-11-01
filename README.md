byu-sentiment-webtools
======================

Webtools used to monitor and analyze twitter sentiment data.

This code is stored on the server at the location

<!-- asdf -->
    /var/www/byu-sentiment-webtools
    
To update this code on the server
- Modify code locally
- Commit and Push code to GitHub
- SSH into the server and issue the following commands:

<!-- -->
    cd /var/www/byu-sentiment-webtools
    sudo git pull

## Composition

## Setup

## Install Web Server

    sudo yum update -y
    sudo yum groupinstall -y "Web Server" "MySQL Database" "PHP Support"
    sudo yum install -y php-mysql
    sudo service httpd start
    # Update the document root to /var/www/byu-sentiment-webtools... you could use a symbolic link
    
## Configure PHP to use short tags

    Open the php.ini file and turn Short_tags ON

## Install PHP Mongo Driver

This code is written in PHP & connects to a Mongo database. In addition to using a standard LAMP server, you'll need to install the MongoDB driver for PHP, which can be a little tricky. This may be different depending on your specific server instance, but I installed it using the following commands:

    #install a compiler
    sudo yum install gcc
    
    #install php-devel
    sudo yum install php-devel
    
    #download and compile the mongo driver
    sudo pecl install mongo
    
    # make a new mongo.ini file to load the extension
    cd /etc/php.d
    sudo vi mongo.ini
    #add the following text to this file --> extension=mongo.so
    
    # restart apache
    sudo /etc/init.d/httpd restart

    
