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

This code is written in PHP & connects to a Mongo database. In addition to using a standard LAMP server, you'll need to install the MongoDB driver for PHP, which can be a little tricky. This may be different depending on your specific server instance, but I installed it using the following commands:

    #install a compiler
    sudo yum install gcc
    
    #download and compile the mongo driver
    sudo pecl install mongo
    
    # make a new mongo.ini file to load the extension
    cd /etc/php.d
    sudo vi mongo.ini
    #add the following text to this file --> extension=mongo.so
    
    # restart apache
    sudo /etc/init.d/httpd restart

    
