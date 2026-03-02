<?php
include 'config.php';

$id = $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM booktable WHERE book_id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$book   = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE booktable SET
            book_title = ?,
            book_author = ?,
            pub_date = ?,
            book_pub = ?,
            book_pages = ?,
            book_cat = ?
         WHERE book_id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssiii",
        $_POST['book_title'],
        $_POST['book_author'],
        $_POST['pub_date'],
        $_POST['book_pub'],
        $_POST['book_pages'],
        $_POST['book_cat'],
        $id
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
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Edit Book</h2>

<form method="POST">

    <input type="text"
           name="book_title"
           class="form-control mb-3"
           value="<?= $book['book_title']; ?>"
           required>

    <input type="text"
           name="book_author"
           class="form-control mb-3"
           value="<?= $book['book_author']; ?>"
           required>

    <input type="date"
           name="pub_date"
           class="form-control mb-3"
           value="<?= $book['pub_date']; ?>"
           required>

    <input type="text"
           name="book_pub"
           class="form-control mb-3"
           value="<?= $book['book_pub']; ?>"
           required>

    <input type="number"
           name="book_pages"
           class="form-control mb-3"
           value="<?= $book['book_pages']; ?>"
           required>

    <select name="book_cat"
            class="form-select mb-3"
            required>

        <?php
        $cat = mysqli_query($conn, "SELECT * FROM category");

        while ($c = mysqli_fetch_assoc($cat)) {

            $selected = ($c['cat_id'] == $book['book_cat'])
                        ? "selected"
                        : "";
        ?>
            <option value="<?= $c['cat_id']; ?>" <?= $selected; ?>>
                <?= $c['cat']; ?>
            </option>
        <?php } ?>

    </select>

    <button type="submit" name="update" class="btn btn-primary">
        Update
    </button>

    <a href="index.php" class="btn btn-secondary">
        Back
    </a>

</form>

</body>
</html>