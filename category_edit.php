<?php
include 'config.php';

/* GET CATEGORY DATA */
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM category WHERE cat_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
}

/* UPDATE PROCESS */
if (isset($_POST['update'])) {

    $id  = $_POST['id'];
    $cat = $_POST['cat'];

    $stmt = $conn->prepare("UPDATE category SET cat = ? WHERE cat_id = ?");
    $stmt->bind_param("si", $cat, $id);

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
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">
            <h4 class="mb-0">Edit Category</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <input type="hidden" name="id" value="<?= $category['cat_id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text"
                           name="cat"
                           class="form-control"
                           value="<?= htmlspecialchars($category['cat']); ?>"
                           required>
                </div>

                <button type="submit" name="update" class="btn btn-warning">
                    Update Category
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