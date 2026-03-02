<?php
include 'config.php';


$error = "";

/* DELETE PROCESS */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // 1️⃣ Check if category is used by any books
    $checkStmt = mysqli_prepare(
        $conn,
        "SELECT COUNT(*) as total FROM booktable WHERE book_cat = ?"
    );

    mysqli_stmt_bind_param($checkStmt, "i", $id);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] > 0) {

        // Category is being used
        $error = "Cannot delete category. It is used by existing books.";

    } else {

        // Safe to delete
        $deleteStmt = mysqli_prepare(
            $conn,
            "DELETE FROM category WHERE cat_id = ?"
        );

        mysqli_stmt_bind_param($deleteStmt, "i", $id);
        mysqli_stmt_execute($deleteStmt);
        mysqli_stmt_close($deleteStmt);
        
        header("Location: category_index.php?deleted=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <?php if (!empty($error)) : ?>
    <div class="alert alert-danger">
        <?= $error; ?>
    </div>
    <?php endif; ?>

    <h2 class="mb-4">Categories</h2>
    <div class="mb-3">
    <a href="category_create.php" class="btn btn-success">
        + Add Category
    </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">
                Category deleted successfully!
            </div>
            <?php endif; ?>
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="10%">ID</th>
                        <th>Category Name</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $result = $conn->query("SELECT * FROM category ORDER BY cat_id ASC");

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $row['cat_id']; ?></td>
                        <td><?= htmlspecialchars($row['cat']); ?></td>
                        <td>
                            <a href="category_edit.php?id=<?= $row['cat_id']; ?>"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <a href="category_index.php?delete=<?= $row['cat_id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this category?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>