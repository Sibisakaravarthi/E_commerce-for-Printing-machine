<?php
session_start();
include("dbconfig.php");

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM complaints WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints</title>
    <style>
        /* General Styles */
        body {
            background: linear-gradient(to right, #dfe9f3, #97c1e7);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Heading */
        h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background: #2c3e50;
            color: white;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tr:hover {
            background: #d6e4f0;
            transition: 0.3s ease;
        }

        /* Image */
        img {
            width: 80px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #ccc;
            padding: 3px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            .table th, .table td {
                padding: 8px;
                font-size: 14px;
            }

            img {
                width: 60px;
            }
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <h2>Your Complaints</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Complaint</th>
                    <th>Status</th>
                    <th>Admin Reply</th>
                    <th>Resolved Image</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["complaint_text"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td><?php echo $row["reply_text"] ? $row["reply_text"] : "No reply yet"; ?></td>
                        <td>
                            <?php if ($row["resolved_image"]) { ?>
                                <img src="<?php echo $row["resolved_image"]; ?>" alt="Resolved Image" width="100">
                            <?php } else { ?>
                                No image uploaded
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
