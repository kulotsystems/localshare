<?php
    date_default_timezone_set('Asia/Manila');
    chdir('data');

    $lines = array();
    $fr = fopen($datfile, "r");
    while(!feof($fr)) {
        $line = trim(fgets($fr));
        if($line != "") {
            array_push($lines, $line);
        }
    }
    fclose($fr);

    $lines = array_reverse($lines);
    $lines_to_delete = array();
    foreach($lines as $line) {
        $data = explode('|', $line);
        $time = intval($data[0]);
        $filename = $data[1];
        $filetype = $data[2];
        $filesize = $data[3];

        $link = "files/" . $time . "/" . $filename . "." . $filetype;
        if(file_exists('../' . $link)) {
            echo "<tr>";
            echo "<td>" . date('m/d/Y H:i', $time) . "</td>";
            echo "<td>" . $filename . "</td>";
            echo "<td>" . $filetype . "</td>";
            echo "<td>";
            echo "<a href='" . $link . "' download>Download (" . $filesize . ")</a>";
            echo "</td>";
            echo "</tr>";
        }
        else {
            array_push($lines_to_delete, $line);
        }
    }

    // delete lines with missing files
    if(sizeof($lines_to_delete) > 0) {
        $new_content = "";
        $fr = fopen($datfile, "r");
        while(!feof($fr)) {
            $line = trim(fgets($fr));
            if($line != "") {
                if(!in_array($line, $lines_to_delete)) {
                    $new_content = $new_content . $line . "\n";
                }
            }
        }
        fclose($fr);

        $fw = fopen($datfile, "w");
        fwrite($fw, $new_content);
        fclose($fw);
    }


    chdir('../');
?>
