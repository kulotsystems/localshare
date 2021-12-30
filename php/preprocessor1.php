<?php
    session_start();

    $uploaded = false;
    if(isset($_SESSION['status'])) {
        if($_SESSION['status'] != "") {
            echo $_SESSION['status'];
            $_SESSION['status'] = "";
            $uploaded = true;
        }
    }
    if(!$uploaded) {
        echo "<div class='alert alert-primary'>Upload your file.</div>";
    }


    chdir('data');
    $datfile = 'data.txt';
    $current_time = time();

    // create the file if it does not exist
    if(!file_exists($datfile)) {
        $f = fopen($datfile, "w");
        fclose($f);
    }

    chdir('../');

    // when upload button was clicked
    if(isset($_POST['btnUpload'])) {
        // file upload
        $fileupload = $_FILES['fileUpload'];

        // check for file upload error
        if ($fileupload["error"] > 0) {
            echo "<div class='alert alert-danger'>Please select a valid file to upload.</div>";
        }
        else {
            $original_filename = $fileupload["name"];
            // split file name into name and extension
            $filenameparts = pathinfo($original_filename);

            $file_name      = $filenameparts['filename'];
            $file_extension = $filenameparts['extension'];

            $invalid_extensions = ['php', 'exe'];
            if(in_array(strtolower($file_extension), $invalid_extensions))
                $_SESSION['status'] = "<div class='alert alert-danger'>Unable to upload a <b>$file_extension</b> file.</div>";
            else {

                // get file size
                $file_size_bytes = $fileupload["size"];
                $file_size = getFileSize($file_size_bytes);

                // create the folder with the current time
                chdir('files');
                $dir = ''.$current_time.'';
                if(!file_exists($dir)) {
                    mkdir($dir);
                }

                chdir($dir);

                if(file_exists($original_filename)) {
                    $original_filename = $file_name . "_1" . $file_extension;
                }

                // move the file from 'tmp' to $dir
                move_uploaded_file($fileupload['tmp_name'], $original_filename);

                chdir('../');
                chdir('../');

                // record the file

                chdir('data');
                $fa = fopen($datfile, "a");
                $line = $current_time . "|" . $file_name . "|" . $file_extension . "|" . $file_size . "\n";
                fwrite($fa, $line);
                fclose($fa);
                chdir('../');

                $_SESSION['status'] =  "<div class='alert alert-success'>You've successfully uploaded a <b>" . strtoupper($file_extension) . "</b> file. Check it out below.</div>";
            }
            header('Location: '. $_SERVER['PHP_SELF']);
        }
    }

    function getFileSize($bytes) {
        $file_size_kb = intval($bytes / 1024);
        $file_size = "";
        if($file_size_kb < 1024) {
            $file_size = $file_size_kb . " Kb";
        }
        else if($file_size_kb >= 1024 && $file_size_kb <= (1024 * 1024)) {
            $file_size = intval(($bytes / 1024) / 1024) . " Mb";
        }
        else {
            $file_size = intval((($bytes / 1024) / 1024) / 1024) . " Gb";
        }
        return $file_size;
    }

?>
