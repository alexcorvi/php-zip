<?php

    function dirToArray($dir) { 
        $result = array(); 
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) { 
            if(substr( $value, 0, 1 ) === ".") {
                continue;
            }
            if (!in_array($value,array(".","..",".DS_STORE"))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
                } 
                else {
                    $result[] = $value; 
                }
            }
        }
        return $result; 
    }

    require_once "../src/Zip.php";

    $directory = "/Users/alisaleem/Projects/php-zip/test/sample/dir_1";
    $arr = array(
        "/Users/alisaleem/Projects/php-zip/test/sample/dir_2/file_c",
        "/Users/alisaleem/Projects/php-zip/test/sample/dir_2/file_d"
    );
    $file1 = "/Users/alisaleem/Projects/php-zip/test/sample/dir_3/file_e";
    $file2 = "/Users/alisaleem/Projects/php-zip/test/sample/dir_3/file_f";

    // using zipArchive class
    $zip1 = new Zip();
    $zip1->zip_start("test1.zip");
    $zip1->zip_add($directory);
    $zip1->zip_add($arr);
    $zip1->zip_add($file1);
    $zip1->zip_add($file2);
    $zip1->zip_end(1);

    // using PclZip class
    $zip2 = new Zip();
    $zip2->zip_start("test2.zip");
    $zip2->zip_add($directory);
    $zip2->zip_add($arr);
    $zip2->zip_add($file1);
    $zip2->zip_add($file2);
    $zip2->zip_end(2);

    $extract1 = new Zip();
    $extract1->unzip_file("./test1.zip");
    $extract1->unzip_to("./test1");

    $extract2 = new Zip();
    $extract2->unzip_file("./test2.zip");
    $extract2->unzip_to("./test2");

    echo "Testing equality between original and ZipArchive Result\n\t\t";
    var_dump(dirToArray("./sample") == dirToArray("./test1"));

    echo "Testing equality between original and PclZip Result\n\t\t";
    var_dump(dirToArray("./sample") == dirToArray("./test2"));

    echo "Testing equality between ZipArchive and PclZip Result\n\t\t";
    var_dump(dirToArray("./test1") == dirToArray("./test2"));

    echo "Deleting test related files...\n";
    exec("rm -rf ./test1");
    exec("rm -rf ./test2");
    unlink("./test1.zip");
    unlink("./test2.zip");
?>