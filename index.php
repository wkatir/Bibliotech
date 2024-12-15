<?php

require_once 'vendor/autoload.php';

use Wilmer\Bibliotech\Persistence\JsonPersistence;
use Wilmer\Bibliotech\Services\LibraryService;
use Wilmer\Bibliotech\Services\LoanService;
use Wilmer\Bibliotech\ResourceFactory;

// Initialize services
$persistence = new JsonPersistence('data/books.json');
$loanPersistence = new JsonPersistence('data/loans.json');
$library = new LibraryService($persistence);
$loanService = new LoanService($loanPersistence);

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addBook'])) {
        // Add a new book
        $book = ResourceFactory::createBook(
            uniqid(), // Unique ID
            $_POST['title'], // Title
            $_POST['author'], // Author
            $_POST['category'], // Category
            $_POST['image'] // Image URL
        );
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
            'category' => $_POST['category'],
            'image' => $_POST['image'],
        ];
        $library->update($id, $updatedData);
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['loanBook'])) {
        // Loan a book
        try {
            $loanService->loan($_POST['id'], $_POST['borrower']);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if (isset($_POST['returnBook'])) {
        // Return a loaned book
        try {
            $loanService->return($_POST['id']);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $library->delete($_GET['delete']);
    header('Location: index.php');
    exit;
}

// Handle search
$books = [];
if (isset($_GET['search'])) {
    $query = $_GET['search'];
    $books = $library->search($query);
} else {
    $books = $library->getAll();
}

// Fetch loans
$loans = $loanService->getLoans();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotech</title>
    <link rel="stylesheet" href="./public/main.css">
</head>
<body>
    <h1>Bibliotech: Book Management</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <!-- Search form -->
    <form method="GET" action="index.php">
        <input type="text" name="search" placeholder="Search books by title" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Add Book Form -->
    <form method="POST" action="index.php">
        <h2>Add Book</h2>
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="url" name="image" placeholder="Image URL"> <!-- Image URL -->
        <button type="submit" name="addBook">Add</button>
    </form>

    <!-- Book List -->
    <h2>Book List</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Image</th>
                <th>Borrower</th>
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
                        <?php if ($book['image']): ?>
                            <img src="<?= htmlspecialchars($book['image']) ?>" alt="Book Image" width="50">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($loans[$book['id']])): ?>
                            Borrowed by: <?= htmlspecialchars($loans[$book['id']]['borrower']) ?>
                        <?php else: ?>
                            Available
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Edit Form -->
                        <form method="POST" action="index.php" class="inline-form">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                            <input type="text" name="category" value="<?= htmlspecialchars($book['category']) ?>" required>
                            <input type="url" name="image" value="<?= htmlspecialchars($book['image']) ?>">
                            <button type="submit" name="editBook">Edit</button>
                        </form>

                        <!-- Delete Link -->
                        <a href="index.php?delete=<?= $book['id'] ?>" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>

                        <!-- Loan and Return Actions -->
                        <form method="POST" action="index.php" class="inline-form">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <?php if (!isset($loans[$book['id']])): ?>
                                <input type="text" name="borrower" placeholder="Borrower Name" required>
                                <button type="submit" name="loanBook">Loan</button>
                            <?php else: ?>
                                <button type="submit" name="returnBook">Return</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
