<?php
// connect to the database
//$conn = mysqli_connect('localhost', 'root', '', 'file-management');

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $uuid = guidv4();
    mkdir('uploads/'.$uuid, 0755, true);
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    // $destination = 'uploads/' . $filename;
    
    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $destination = 'uploads/' .$uuid .'/' . $filename;

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    $parts_size = $_POST['parts_size'];
    $position = $_POST['position'];

    if($parts_size > 20 || $parts_size < 1) {
        echo "Invalid size";
    }

    if($position > 3 || $parts_size < 0) {
        echo "Invalid position";
    }

    if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
        echo "You file extension must be .jpg, .png or .jpeg";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $result = shell_exec('/bin/bash /var/www/crop '.$parts_size.' '.$position.' '.$destination.' /var/www/html/crop/uploads/'.$uuid);
            echo $result;
            // $sql = "INSERT INTO files (name, size, downloads) VALUES ('$filename', $size, 0)";
            // if (mysqli_query($conn, $sql)) {
            //     echo "File uploaded successfully";
            // }

            // exit(header('Location: /result.php?id='.$uuid));
            echo '<script> window.location="result.php?id='.$uuid.'"; </script> ';

            // $dir_name = "/var/www/html/uploads/".$uuid;
            // $images = glob($dir_name."file-*.jpg");
            // foreach($images as $image) {
            //     echo '<img src="'.$image.'" /><br />';
            // }
        } else {
            echo "Failed to upload file.";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dir_name = "uploads/".$id;

    $images = glob($dir_name."/file-*.jpg");
    //     foreach($images as $image) {
    //     echo '<img src="'.$image.'" /> <a href="whatsapp://send?text='.$image.'" data-action="share/whatsapp/share">Share</a> <br />';
    // }
}

// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    // $sql = "SELECT * FROM files WHERE id=$id";
    // $result = mysqli_query($conn, $sql);

    // $file = mysqli_fetch_assoc($result);
    // $filepath = 'uploads/' . $file['name'];
    $filepath = 'uploads/' . $id;

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        // header('Content-Length: ' . filesize('uploads/' . $file['name']));
        header('Content-Length: ' . filesize('uploads/' . $id));
        // readfile('uploads/' . $file['name']);
        readfile('uploads/' . $id);

        // Now update downloads count
        // $newCount = $file['downloads'] + 1;
        // $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        // mysqli_query($conn, $updateQuery);
        exit;
    }

}

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}