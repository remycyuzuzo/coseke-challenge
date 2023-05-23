<?php
include './public/app.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/res/styles.css">
    <title>File Management System | COSEC</title>
</head>

<body>
    <div class="header">
        <div class="nav">
            <h3>FMS</h3>
        </div>
    </div>
    <div class="container">
        <div class="app">
            <div class="upload">
                <div class="drop-area-container">
                    <label for="uploader" class="drop_area">
                        drop file here or click to upload
                    </label>
                    <div class="preview"></div>
                </div>
                <form method="POST" action="./public/app.php" class="input" enctype="multipart/form-data">
                    <input type="file" style="display: none" id="uploader" name="file" />
                    <input type="hidden" name="csrf_fms" value="<?= App::generate_random_token() ?>">
                    <button type="submit" name="submit_btn" class="submit">Upload</button>
                </form>
            </div>
            <div class="display">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th> </th>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($files as $file) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $file["file_name"] ?></td>
                                <td><a href="<?= $file["path"] ?>" download="<?= $file["path"] ?>" target="_blank">Download</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<script src="./public/res/script.js"></script>

</html>