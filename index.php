<?php
require 'config.php';
/* DELETE HANDLER */
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {

    $deleteId = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM booktable WHERE book_id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();

    header("Location: index.php?deleted=1");
    exit();
}

$catFilter  = $_GET['cat'] ?? '';
$search     = $_GET['search'] ?? '';
$dateFilter = $_GET['pub_date'] ?? '';
$sql = "
    SELECT b.*, c.cat AS category_name
    FROM booktable b
    JOIN category c ON b.book_cat = c.cat_id
";

$conditions = [];
$params = [];
$types = "";

/* Filter by Category */
if (!empty($catFilter)) {
    $conditions[] = "b.book_cat = ?";
    $params[] = $catFilter;
    $types .= "i";
}

/* Filter by Search Text */
if (!empty($search)) {
    $conditions[] = "(b.book_title LIKE ? 
                  OR b.book_author LIKE ? 
                  OR b.book_pub LIKE ?
                  OR c.cat LIKE ?)";
    $searchParam = "%$search%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "ssss";
}

/* Filter by Publication Date */
if (!empty($dateFilter)) {

    if (preg_match('/^\d{4}$/', $dateFilter)) {
        // YEAR only
        $conditions[] = "YEAR(b.pub_date) = ?";
        $params[] = $dateFilter;
        $types .= "i";

    } elseif (preg_match('/^\d{4}-\d{2}$/', $dateFilter)) {
        // YEAR-MONTH
        $conditions[] = "DATE_FORMAT(b.pub_date, '%Y-%m') = ?";
        $params[] = $dateFilter;
        $types .= "s";

    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFilter)) {
        // FULL DATE
        $conditions[] = "b.pub_date = ?";
        $params[] = $dateFilter;
        $types .= "s";
    }
}

/* Apply WHERE */
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY b.book_id ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>
<div class="container mt-4">

    <h2 class="mb-4">Book List</h2>
    <div class="mb-3">
    <a href="create.php" class="btn btn-success">
        + Add Book
    </a>
    </div>
    <!-- FILTER FORM -->
    <form method="GET" class="row g-3 mb-4">

        <!-- Category Filter -->
        <div class="col-md-3">
            <select name="cat" class="form-select">
                <option value="">All Categories</option>
                <?php
                $catQuery = $conn->query("SELECT * FROM category");
                while ($catRow = $catQuery->fetch_assoc()) {
                    $selected = ($catFilter == $catRow['cat_id']) ? 'selected' : '';
                    echo "<option value='{$catRow['cat_id']}' $selected>
                            {$catRow['cat']}
                          </option>";
                }
                ?>
            </select>
        </div>

        <!-- Search -->
        <div class="col-md-3">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search title, author, publisher"
                   value="<?= htmlspecialchars($search); ?>">
        </div>

        <!-- Publication Date -->
        <div class="col-md-3">
            <input type="text"
             name="pub_date"
            class="form-control"
            placeholder="YYYY or YYYY-MM or YYYY-MM-DD"
            value="<?= htmlspecialchars($dateFilter); ?>">
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        </div>

    </form>
    <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">
        Book deleted successfully!
    </div>
    <?php endif; ?>
    <!-- BOOK TABLE -->
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Published Date</th>
                <th>Pages</th>
                <th>Category</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['book_id']; ?></td>
                <td><?= htmlspecialchars($row['book_title']); ?></td>
                <td><?= htmlspecialchars($row['book_author']); ?></td>
                <td><?= htmlspecialchars($row['book_pub']); ?></td>
                <td><?= date("d F Y", strtotime($row['pub_date'])); ?></td>
                <td><?= $row['book_pages']; ?></td>
                <td><?= htmlspecialchars($row['category_name']); ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['book_id']; ?>" 
                       class="btn btn-sm btn-warning">Edit</a>

                    <a href="index.php?delete=<?= $row['book_id']; ?>" 
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this book?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>

        </tbody>
    </table>

</div>

</body>
</html>