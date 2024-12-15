<?php

require_once 'vendor/autoload.php';

use Wilmer\Bibliotech\Persistence\JsonPersistence;
use Wilmer\Bibliotech\Services\LibraryService;
use Wilmer\Bibliotech\ResourceFactory;

// Initialize the system with JSON persistence
$persistence = new JsonPersistence('data/books.json');
$library = new LibraryService($persistence);

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addBook'])) {
        // Add a new book
        $book = ResourceFactory::createBook(uniqid(), $_POST['title'], $_POST['author'], $_POST['category']);
        $library->add($book);
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['editBook'])) {
        // Edit an existing book
        $id = $_POST['id'];
        $updatedData = [
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'category' => $_POST['category']
        ];
        $library->update($id, $updatedData);
        header('Location: index.php');
        exit;
    }
}

// Delete a book
if (isset($_GET['delete'])) {
    $library->delete($_GET['delete']);
    header('Location: index.php');
    exit;
}

// Search for books
$books = [];
if (isset($_GET['search'])) {
    $query = $_GET['search'];
    $books = $library->search($query);
} else {
    $books = $library->getAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotech</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="./public/main.css">
</head>
<body>
    <h1>Bibliotech: Book Management</h1>

    <!-- Search form for books -->
    <form method="GET" action="index.php">
        <input type="text" name="search" placeholder="Search books by title" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Form to add a new book -->
    <form method="POST" action="index.php">
        <h2>Add Book</h2>
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="text" name="category" placeholder="Category" required>
        <button type="submit" name="addBook">Add</button>
    </form>

    <!-- Table displaying the list of books -->
    <h2>Book List</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['category']) ?></td>
                    <td>
                        <!-- Form to edit a book -->
                        <form method="POST" action="index.php" class="inline-form">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                            <input type="text" name="category" value="<?= htmlspecialchars($book['category']) ?>" required>
                            <button type="submit" name="editBook">Edit</button>
                        </form>
                        <!-- Link to delete a book -->
                        <a href="index.php?delete=<?= $book['id'] ?>" onclick="return confirm('Are you sure you want to delete this book?')" class="delete-link">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
