<?php
session_start();
class App
{
    public function uploadFile(string $where_to, string $file_name)
    {
        $targetFile = $where_to . basename($file_name);
        $file_name = $_FILES["file"]["name"]; // Get uploaded file name
        $file_size = $_FILES["file"]["size"]; // Get uploaded file size
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        if (empty($file_name)) {
            die($this->show_alert("<strong>No file</strong> Please select a valid file first!"));
        }

        if ($file_size > 6485760) { // Check file size 10mb or not
            die($this->show_alert("The maximum allowed size is 6MB", "error"));
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            echo $this->show_alert("File uploaded successfully.", "success");
        } else {
            echo $this->show_alert("Sorry, there was an error uploading your file. ", "error");
        }
    }

    public function show_alert($message, $type = "error")
    {
        $style = "background-color: #b52419";
        if ($type == "success") {
            $style = "background-color: #1fab21";
        }

        return "
        <div style='display: flex;'>
            <a href='./index.php' style='padding: 10px; border-radius: 10px; background-color: #42379e; color: #fff'>go Back</a>
            <div style='padding: 10px 30px; margin: 0 10px; color: #ffffff; border-radius: 10px; $style'>
                $message
            </div>
        </div>
        ";
    }

    public function getFilesInFolder($folderPath)
    {
        $files = [];

        if (is_dir($folderPath)) {
            $directory = new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS);
            $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
            $i = 0;
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $files[$i]["path"] = $file->getPathname();
                    $files[$i]["file_name"] = $file->getFilename();
                }
                $i++;
            }
        }
        return $files;
    }

    public static function generate_random_token()
    {
        $token = uniqid();
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf_fms'])) {
    if ($_SESSION['csrf_token'] != $_POST['csrf_fms']) {
        echo "Couldn't validate your CSRF token";
        return;
    }
    $app = new App();
    $app->uploadFile('uploads/', $_FILES['file']['name']);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $app = new App();
    $files = $app->getFilesInFolder(__DIR__ . '/uploads/');
}
