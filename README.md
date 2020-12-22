# Test task - Full Stack Developer

Test task - Service Registry, Developed by Yii2 Framework, VueJs.

## Installation

1) Download 

```bash
git clone https://github.com/a7e6j2/test-task22.git
composer update
```
2) Import the database into the Mysql

```
The sql file is located in /sql/full_db.sql
```
3) Config the database setting 

```
the database configuration file is located in /config/db.php
```


## Demonstration

Website : [http://api.joey.im/test.html](http://api.joey.im/test.html) 

## Online APIs Documentation
Documentation (OpenAPI 3.0) [http://api.joey.im/docs](http://api.joey.im/docs) 

## Testing
API testing with codeception, the source code located in ./tests/
```bash
./vendor/bin/codecept run 
```
By steps
```bash
./vendor/bin/codecept run --steps
```

## Folder Structure
    .
    ├── ...
    ├── api                                # APIs
    │   └── modules                        # Module folder
    │      └── v1                          # V1.0 folder
    │          ├── Controller.php          # Custom Controller (extended from Yii2 Rest Controller)
    │          ├── controllers             # API controllers folder  
    │          ├── helpers                 # Custom Helpers folder      
    │          ├── models                  # API Models folder      
    │          └── Module.php              # Module global setting 
    ├── components                         # Global components folder
    ├── config                             # Configuration files folder (you can set the database, routes and default setting)
    ├── controllers                        # Back-end web controllers
    ├── models                             # Global models folder     
    ├── runtime                            # Runtime folder (for caching...)      
    ├── sql                                # Sql import file (only for demo)
    ├── tests                              # Test code folder          
    ├── vendor                             # Vendor code       
    ├── web                                # Server root (Please set the root folder to this file in Nginx configuration)                  
    └── codeception.yml                    # Codeception setting (for testing)


## Apache and Nginx configurations

## Nginx

Nginx
You can use Yii with Nginx and PHP with FPM SAPI. Here is a sample host configuration. It defines the bootstrap file and makes yii catch all requests to unexisting files, which allows us to have nice-looking URLs.

```

server {
    set $host_path "/www/mysite";
    access_log  /www/mysite/log/access.log  main;

    server_name  mysite;
    root   $host_path/htdocs;
    set $yii_bootstrap "index.php";

    charset utf-8;

    location / {
        index  index.html $yii_bootstrap;
        try_files $uri $uri/ /$yii_bootstrap?$args;
    }

    location ~ ^/(protected|framework|themes/\w+/views) {
        deny  all;
    }

    #avoid processing of calls to unexisting static files by yii
    location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        try_files $uri =404;
    }

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
    location ~ \.php {
        fastcgi_split_path_info  ^(.+\.php)(.*)$;

        #let yii catch the calls to unexising PHP files
        set $fsn /$yii_bootstrap;
        if (-f $document_root$fastcgi_script_name){
            set $fsn $fastcgi_script_name;
        }

        fastcgi_pass   127.0.0.1:9000;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fsn;

        #PATH_INFO and PATH_TRANSLATED can be omitted, but RFC 3875 specifies them for CGI
        fastcgi_param  PATH_INFO        $fastcgi_path_info;
        fastcgi_param  PATH_TRANSLATED  $document_root$fsn;
    }

    # prevent nginx from serving dotfiles (.htaccess, .svn, .git, etc.)
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }
}
```


## Apache

Yii is ready to work with a default Apache web server configuration. The .htaccess files in Yii framework and application folders restrict access to the restricted resources. To hide the bootstrap file (usually index.php) in your URLs you can add mod_rewrite instructions to the .htaccess file in your document root or to the virtual host configuration:

```
RewriteEngine on

# prevent httpd from serving dotfiles (.htaccess, .svn, .git, etc.)
RedirectMatch 403 /\..*$
# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# otherwise forward it to index.php
RewriteRule . index.php
```
