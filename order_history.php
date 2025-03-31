<?php
session_start();
include("dbconfig.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$query = "SELECT id, created_at, total_price, status FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(to right, #f0f8ff, #e3f2fd);
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #ffffff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .container {
            width: 85%;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        .complaint-btn {
            background: #ff5733;
            color: white;
            padding: 7px 14px;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 25px;
            width: 40%;
            border-radius: 12px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.3);
            position: relative;
            text-align: center;
        }
        .close-btn {
            color: #ff3b3b;
            font-size: 22px;
            position: absolute;
            top: 12px;
            right: 15px;
            cursor: pointer;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .submit-btn {
            background: #28a745;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-weight: bold;
        }
        .logout-btn:hover {
            background-color: #28a745;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-left">
        <h2>My Store</h2>
    </div>
    <div class="nav-right">
        <span>Welcome, <?php echo $_SESSION["user_name"]; ?></span>
        <a href="resolved_complaint.php" style="background-color: black; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s ease;">Complaints</a>
        <a href="cart.php" style="background-color: black; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s ease;">Cart</a>
        <a href="logout.php" class="logout-btn" style="background-color: black; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s ease;">Logout</a>
    </div>
</nav>

<!-- Order History -->
<div class="container">
    <h2>Order History</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Complaint</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["created_at"] ?? "N/A"; ?></td>
                <td>₹<?php echo number_format($row["total_price"], 2); ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td>
                    <button class="complaint-btn" onclick="openComplaintForm(<?php echo $row['id']; ?>)">Submit Complaint</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Complaint Modal -->
<div id="complaintModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeComplaintForm()">&times;</span>
        <h2>Submit a Complaint</h2>
        <form id="complaintForm" enctype="multipart/form-data">
            <input type="hidden" name="order_id" id="order_id">
            <div class="input-group">
                <label>Complaint Details:</label>
                <textarea name="complaint" required></textarea>
            </div>
            <div class="input-group">
                <label>Upload Image:</label>
                <input type="file" name="complaint_image" accept="image/*">
            </div>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>

<script>
    function openComplaintForm(orderId) {
        document.getElementById("order_id").value = orderId;
        document.getElementById("complaintModal").style.display = "flex";
    }

    function closeComplaintForm() {
        document.getElementById("complaintModal").style.display = "none";
    }

    window.onclick = function(event) {
        let modal = document.getElementById("complaintModal");
        if (event.target === modal) {
            closeComplaintForm();
        }
    };

    document.getElementById("complaintForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("submit_complaint.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert("Complaint submitted successfully!");
            closeComplaintForm();
        })
        .catch(error => console.error("Error:", error));
    });
</script>

</body>
</html>
