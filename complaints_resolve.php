<?php
session_start();
include("dbconfig.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST["complaint_id"];
    $reply_text = $_POST["reply_text"];
    
    // File upload handling
    $image_path = NULL;
    if (!empty($_FILES["resolved_image"]["name"])) {
        $target_dir = "resolved_images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = basename($_FILES["resolved_image"]["name"]);
        $target_file = $target_dir . time() . "_" . $image_name; // Rename to prevent conflicts
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type (only allow JPG, PNG, GIF)
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.location='complaints.php';</script>";
            exit();
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["resolved_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "<script>alert('Error uploading image.'); window.location='complaints.php';</script>";
            exit();
        }
    }

    // Update complaint status, reply text, and resolved image path
    $sql = "UPDATE complaints SET reply_text = ?, resolved_image = ?, status = 'Resolved' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssi", $reply_text, $image_path, $complaint_id);

    if ($stmt->execute()) {
        echo "<script>alert('Complaint Resolved'); window.location='complaints.php';</script>";
    } else {
        die("Execution failed: " . $stmt->error);
    }
}

// Fetch complaint details
if (isset($_GET["id"])) {
    $complaint_id = $_GET["id"];
    $stmt = $conn->prepare("SELECT * FROM complaints WHERE id = ?");
    
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();
} else {
    header("Location: complaints.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolve Complaint</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow-sm p-3">
                    <h4>Resolve Complaint</h4>
                    <p><strong>User ID:</strong> <?php echo $complaint["user_id"]; ?></p>
                    <p><strong>Complaint:</strong> <?php echo $complaint["complaint_text"]; ?></p>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="complaint_id" value="<?php echo $complaint["id"]; ?>">
                        
                        <div class="mb-3">
                            <label for="reply_text" class="form-label">Your Reply</label>
                            <textarea class="form-control" name="reply_text" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="resolved_image" class="form-label">Upload Resolved Image</label>
                            <input type="file" class="form-control" name="resolved_image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-success">Submit Reply</button>
                        <a href="complaints.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
