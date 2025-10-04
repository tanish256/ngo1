<?php
session_start();
if (!$_SESSION['role'] == 'admin') {
    header("Location: login.php");
}
header('Content-Type: application/json');
if (isset($_POST['video_id']) && isset($_FILES['video'])) {
    $video_id = $_POST['video_id'];
    $file = $_FILES['video'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('mp4', 'webm', 'ogg');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 500000000) { // 500MB limit
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '../videos/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $videos_json = file_get_contents('../videos.json');
                $videos = json_decode($videos_json, true);
                $videos[$video_id] = 'videos/' . $fileNameNew;
                file_put_contents('../videos.json', json_encode($videos, JSON_PRETTY_PRINT));

                echo json_encode([
                    "success" => true,
                    "file_path" => $fileNameNew,
                    "message" => "Video updated successfully"
                ]);
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
