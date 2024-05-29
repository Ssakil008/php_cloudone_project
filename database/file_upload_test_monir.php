<?php
session_start();

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Set the target directory for uploaded images
    $targetDir = "../assets/images/signal/";
    // Ensure the directory exists
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            die("Failed to create directories...");
        }
    }

    if (!empty($_FILES['image']['name'])) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            // Move the uploaded file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Get image size
                list($width, $height) = getimagesize($targetFilePath);

                // Check if resizing and compression are needed
                if ($width > 512 || $height > 512 || filesize($targetFilePath) > 200 * 1024) {
                    // Resize the image to 512x512 and ensure it's under 200KB
                    if (!resizeImage($targetFilePath, 512, 512, 200)) {
                        echo json_encode(['success' => false, 'message' => 'Error resizing the image to the required size.']);
                        exit;
                    }
                }

                // Save the file path for the database
                $img_url = $targetFilePath;
                echo json_encode(['success' => true, 'message' => 'The file has been uploaded and resized.', 'image_url' => $img_url]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error moving the uploaded file.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file format.']);
            exit;
        }
    }
}

function resizeImage($file, $maxWidth, $maxHeight, $maxSizeKB)
{
    list($width, $height, $type) = getimagesize($file);

    $src = null;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($file);
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($file);
            break;
        default:
            return false;
    }

    $dst = imagecreatetruecolor($maxWidth, $maxHeight);

    if ($type == IMAGETYPE_PNG) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
        imagefilledrectangle($dst, 0, 0, $maxWidth, $maxHeight, $transparent);
    }

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $maxWidth, $maxHeight, $width, $height);

    // Save resized image
    $saved = false;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $saved = imagejpeg($dst, $file, 75); // Adjust quality for JPEG
            break;
        case IMAGETYPE_PNG:
            $saved = imagepng($dst, $file, 6); // Adjust compression level for PNG
            break;
        case IMAGETYPE_GIF:
            $saved = imagegif($dst, $file);
            break;
    }

    imagedestroy($src);
    imagedestroy($dst);

    // Check the file size and try to compress further if necessary
    if ($saved && filesize($file) > $maxSizeKB * 1024) {
        compressImage($file, $maxSizeKB);
    }

    return filesize($file) <= $maxSizeKB * 1024;
}

function compressImage($file, $maxSizeKB)
{
    $quality = 75;
    while (filesize($file) > $maxSizeKB * 1024 && $quality > 10) {
        $image = imagecreatefromjpeg($file);
        imagejpeg($image, $file, $quality);
        imagedestroy($image);
        $quality -= 5;
    }
}
?>