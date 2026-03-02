<?php
include 'config.php';

/* INSERT PROCESS */
if (isset($_POST['submit'])) {

    $cat = $_POST['cat'];

    $stmt = $conn->prepare("INSERT INTO category (cat) VALUES (?)");
    $stmt->bind_param("s", $cat);

    if ($stmt->execute()) {
        header("Location: category_index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Add New Category</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="cat" class="form-control" required>
                </div>

                <button type="submit" name="submit" class="btn btn-success">
                    Save Category
                </button>

                <a href="category_index.php" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>