<?php
include 'config.php';

if (isset($_POST['submit'])) {

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO booktable
        (book_title, book_author, pub_date, book_pub, book_pages, book_cat)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssii",
        $_POST['book_title'],
        $_POST['book_author'],
        $_POST['pub_date'],
        $_POST['book_pub'],
        $_POST['book_pages'],
        $_POST['book_cat']
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Add Book</h2>

<form method="POST">

    <input type="text"
           name="book_title"
           class="form-control mb-3"
           placeholder="Title"
           required>

    <input type="text"
           name="book_author"
           class="form-control mb-3"
           placeholder="Author"
           required>

    <input type="date"
           name="pub_date"
           class="form-control mb-3"
           required>

    <input type="text"
           name="book_pub"
           class="form-control mb-3"
           placeholder="Publisher"
           required>

    <input type="number"
           name="book_pages"
           class="form-control mb-3"
           placeholder="Pages"
           required>

    <select name="book_cat"
            class="form-select mb-3"
            required>

        <option value="">Select Category</option>

        <?php
        $cat = mysqli_query($conn, "SELECT * FROM category");

        while ($c = mysqli_fetch_assoc($cat)) {
        ?>
            <option value="<?= $c['cat_id']; ?>">
                <?= $c['cat']; ?>
            </option>
        <?php } ?>

    </select>

    <button type="submit" name="submit" class="btn btn-primary">
        Save
    </button>

    <a href="index.php" class="btn btn-secondary">
        Back
    </a>

</form>

</body>
</html>