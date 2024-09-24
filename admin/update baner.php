<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/update baner.css">
    <title>Admin Page</title>
</head>
<body>
    <div class="container">
        <h1>Add Weekly Offer Page</h1>
        <form id="bannerForm" action="" method="post" enctype="multipart/form-data">
            <label for="photoUpload" class="custom-file-upload">
                Choose Photo
            </label>
            <input type="file" id="photoUpload" name="photoUpload" accept="image/*" required>
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter title" required>
            
            <label for="subtitle">Subtitle:</label>
            <input type="text" id="subtitle" name="subtitle" placeholder="Enter subtitle" required>
            
            <button type="submit">Save</button>

        </form>

        <?php
 
        $servername = "localhost"; 
        $username = "root";        
        $password = "";            
        $dbname = "gallery_cafe";


        $conn = new mysqli($servername, $username, $password, $dbname);


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
            $uploadPath = '../uploads/'; 

           
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle the file upload
            $photoPath = '';
            if (isset($_FILES['photoUpload']) && $_FILES['photoUpload']['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photoUpload']['tmp_name'];
                $fileName = $_FILES['photoUpload']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                // Define allowed file extensions
                $allowedExts = array('jpg', 'jpeg', 'png' , 'avif');
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $dest_path = $uploadPath . $newFileName;

                if (in_array($fileExtension, $allowedExts)) {
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $photoPath = $dest_path;
                    } else {
                        echo "<p>Error moving the file</p>";
                        exit;
                    }
                } else {
                    echo "<p>Invalid file type</p>";
                    exit;
                }
            } else {
                echo "<p>No file uploaded or there was an upload error</p>";
                exit;
            }

         
            $title = $conn->real_escape_string($_POST['title']);
            $subtitle = $conn->real_escape_string($_POST['subtitle']);

           
            $sql = "INSERT INTO banner_details (photo_path, title, subtitle) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $photoPath, $title, $subtitle);

           
            if ($stmt->execute()) {
                echo "<p>Banner details saved successfully</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }

            // Close statement
            $stmt->close();
        }

        
        if (isset($_GET['delete_id'])) {
            $deleteId = (int) $_GET['delete_id'];

            // Fetch the photo path
            $sql = "SELECT photo_path FROM banner_details WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $deleteId);
            $stmt->execute();
            $result = $stmt->get_result();
            
           
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $photoPathToDelete = $row['photo_path'];

                // Delete the record from the database
                $sql = "DELETE FROM banner_details WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $deleteId);

                if ($stmt->execute()) {
                    // Delete the photo file
                    if (file_exists($photoPathToDelete)) {
                        unlink($photoPathToDelete);
                    }
                    echo "<p>Banner deleted successfully</p>";
                } else {
                    echo "<p>Error: " . $stmt->error . "</p>";
                }
            } else {
                echo "<p>Banner not found</p>";
            }

        
            $stmt->close();
        }

        // Display banners
        $sql = "SELECT id, photo_path, title, subtitle FROM banner_details ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="banner-table">';
            echo '<tr><th>Photo</th><th>Title</th><th>Subtitle</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td><img src="' . htmlspecialchars($row["photo_path"]) . '" alt="' . htmlspecialchars($row["title"]) . '"></td>
                        <td>' . htmlspecialchars($row["title"]) . '</td>
                        <td>' . htmlspecialchars($row["subtitle"]) . '</td>
                        <td><a href="?delete_id=' . urlencode($row["id"]) . '" class="delete-button">Delete</a></td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo "<p>No banners found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
