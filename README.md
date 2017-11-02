# PHP Zip Class
A better PHP zipping/unzipping class.

## The problem
When building a CMS that is supposed to be redistributable and functioning on a range of hosting solutions (shared, VPS, dedicated) a problem often occurs in zipping and unzipping files. since not all PHP installation have the `zipArchive` class exists.

##### Case: Duplicator plugin for WordPress
For a number of clients, a problem seemed often occurring due to missing `zipArchive` class:
    
- [VPS](https://wordpress.org/support/topic/plugin-duplicator-no-zip-archive-enabled-on-vps-what-next)
- [VPS again](https://wordpress.org/support/topic/plugin-duplicator-ziparchive-extension-required-for-compression)
- [Shared dreamhost](https://wordpress.org/support/topic/dreamhost-duplicator-and-ziparchive)
- [Shared X10 Hosting](https://x10hosting.com/community/threads/zip-extension-how-to-turn-on-please-help.193531/)
- [Shared dreamhost](https://discussion.dreamhost.com/thread-136038.html)
- [cPanel](https://forums.cpanel.net/threads/installing-activating-php-ziparchive-module.470511/)
- [Yet another case](http://codecharismatic.com/the-stupid-zip-archive-and-wordpress-duplicator-issue/)

However, although the plugin itself is was distributed as a zip file, the WordPress code was **able** to unzip and install it. This is because the WordPress core code will check if the `zipArchive` class exists, and if it does not, it will use the `PclZip` class which can be included as a PHP file and considered as an alternative for `zipArchive`.

## The solution

In this class, I tried to solve this problem in the same approach that the WordPress core team did; by checking if the class `zipArchive` exists or not, and using `PclZip` if it does not.

This does **NOT** solve missing the `zlib` extension which  is a requirement even for the `PclZip` class. However, missing the `zlib` extension is less common than just missing the `zipArchive` class.

This class also provides a very simple and intuitive way of dealing with zip files.

## Installation

To install this class, simply upload the `src` folder contents to your server and include the `Zip.php` file.

Note: To install in CodeIgniter create a folder called `zip` in your in `application/libraries/` and put the `src` folder contents inside of it, then load it using the library loader `$this->load->library("zip/zip");`.

## Usage Examples:

Note: When I wrote this class, I intended to use it in a multi-line fashion (You'll see what I mean). However, I decided later that I should make a shorthand for this, so it would be usable in a one-line style.

### Adding new files to the zip / Creating new zip file:
#### Multi-line style
- **PHP**: 
```php
    require_once "path/to/src/zip.php";
    $zip = new Zip();
    $zip->zip_start("path/to/new/or/old/zip_file.zip");
    $zip->zip_add("path/to/example.png"); // adding a file
    $zip->zip_add(array("path/to/example1.png","path/to/example2.png")); // adding two files as an array
    $zip->zip_add(array("path/to/example1.png","path/to/directory/")); // adding one file and one directory
    $zip->zip_end();
```
- **CodeIgniter**:
```php
	$this->load->library("zip/zip");
    $this->zip->zip_start("path/to/new/or/old/zip_file.zip");
    $this->zip->zip_add("path/to/example.png"); // adding a file
    $this->zip->zip_add(array("path/to/example1.png","path/to/example2.png")); // adding two files as an array
    $this->zip->zip_add(array("path/to/example1.png","path/to/directory/")); // adding one file and one directory
    $this->zip->zip_end();
```

#### one-line style
- **PHP**: 
```php
    require_once "path/to/src/zip.php";
    $zip = new Zip();
    $zip->zip_files(array("path/to/new/or/old/zip_file.zip","path/to/directory/"),"path/to/zip/file.zip");
```
- **CodeIgniter**:
```php
	$this->load->library("zip/zip");
    $this->zip->zip_files(array("path/to/new/or/old/zip_file.zip","path/to/directory/"),"path/to/zip/file.zip");
```

### Extracting (unzipping) files:
#### Multi-line style
- **PHP**: 
```php
    require_once "path/to/src/zip.php";
    $zip = new Zip();
    $zip->unzip_file("path/to/new/or/old/zip_file.zip");
    $zip->unzip_to("path/to/containing/directory/");
```
- **CodeIgniter**:
```php
	$this->load->library("zip/zip");
    $this->zip->unzip_file("path/to/new/or/old/zip_file.zip");
    $this->zip->unzip_to("path/to/containing/directory/");
```

#### one-line style
- **PHP**: 
```php
    require_once "path/to/src/zip.php";
    $zip = new Zip();
    $zip->unzip_file("path/to/new/or/old/zip_file.zip","path/to/containing/directory/");
```
- **CodeIgniter**:
```php
	$this->load->library("zip/zip");
    $this->zip->unzip_file("path/to/new/or/old/zip_file.zip","path/to/containing/directory/");
```

> Note: The library will throw a new exception in case of error and will return true in case of success.

## Testing
```
    cd test && php test.php
```

## Credits
* This approach of solution was inspired by WordPress.
* [PHPConcept](http://www.phpconcept.net/pclzip) for creating `PclZip`, an awesome alternative for `zipArchive`.

## License: The MIT License (MIT)

Copyright (c) 2017 Alex Corvi

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
