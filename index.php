<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Local File Sharing</title>
</head>
<body>
    <div class="container">
        <?php require "php/preprocessor1.php"; ?>
        <form id="frmUpload" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="fileUpload" id="fileUpload">
            </div>
            <button type="submit" name="btnUpload" id="btnUpload" class="btn btn-primary">Upload</button>
        </form>

        <br>

        <table class="table table-responsive table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>FileName</th>
                    <th>Type</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php require "php/preprocessor2.php"; ?>
            </tbody>
        </table>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>