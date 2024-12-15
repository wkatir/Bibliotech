# Bibliotech: Library Management System

## Overview
**Bibliotech** is a simple PHP-based library management system that enables users to manage books in a library. This project provides a basic CRUD (Create, Read, Update, Delete) interface and features like book search, all without requiring a database. Data is stored in a JSON file for simplicity and portability.

---

## Features
- **Add Books:** Users can add new books by providing a title, author, and category.
- **Edit Books:** Users can update the details of existing books directly in the interface.
- **Delete Books:** Users can remove books from the library.
- **Search Books:** Users can search for books by title.
- **JSON Storage:** All data is stored in a `books.json` file.

---

## Project Structure
```
.
├── composer.json         # Composer configuration file
├── vendor/               # Composer dependencies
├── src/                  # Source code
│   ├── Interfaces/       # Interfaces for abstraction
│   │   ├── Manageable.php
│   │   ├── Searchable.php
│   │   └── PersistenceInterface.php
│   ├── Persistence/      # Persistence layer
│   │   └── JsonPersistence.php
│   ├── Resources/        # Resource classes
│   │   ├── Resource.php
│   │   └── Book.php
│   ├── Services/         # Service layer
│   │   └── LibraryService.php
│   └── ResourceFactory.php
├── data/                 # Folder for JSON data
│   └── books.json
├── index.php             # Main entry point
```

---

## Installation

### Prerequisites
- PHP >= 7.4
- Composer
- A local server (e.g., XAMPP, WAMP, or similar)

### Steps
1. Clone this repository or download the ZIP file.
   ```bash
   git clone <repository-url>
   cd bibliotech
   ```

2. Install dependencies using Composer.
   ```bash
   composer install
   ```

3. Start a local PHP server:
   ```bash
   php -S localhost:8000
   ```

4. Open your browser and navigate to:
   ```
   http://localhost:8000
   ```

---

## Usage

### Adding a Book
1. Fill in the title, author, and category in the "Add Book" form.
2. Click the **Add** button to save the book.

### Editing a Book
1. Locate the book you want to edit in the table.
2. Modify the title, author, or category directly in the respective fields.
3. Click the **Edit** button to save changes.

### Deleting a Book
1. Locate the book you want to delete in the table.
2. Click the **Delete** link.
3. Confirm the action when prompted.

### Searching for a Book
1. Use the search bar at the top of the page.
2. Enter a keyword related to the book title.
3. Click the **Search** button to filter results.

---

## Key Concepts

### PHP Features Used
- Object-Oriented Programming (OOP)
- Interfaces and Abstraction
- File Handling (`file_get_contents`, `file_put_contents`)
- JSON Encoding and Decoding
- Dependency Injection

### Design Principles
- **SOLID Principles:**
  - Single Responsibility Principle (SRP): Each class has a single responsibility.
  - Open/Closed Principle (OCP): Classes are open to extension but closed to modification.
  - Dependency Inversion Principle (DIP): High-level modules depend on abstractions.
- **PSR-4 Autoloading:** Simplifies class loading using namespaces.
- **Repository Pattern:** Handles data persistence.

---

## File Details

### `composer.json`
Defines the project dependencies and autoloading configuration. Uses **PSR-4** autoloading to map the namespace `Wilmer\Bibliotech\` to the `src/` folder.

### `index.php`
The main entry point for the application. Handles user interactions and links the interface with the backend logic.

### `src/`
- **Interfaces:** Define contracts for manageability, searchability, and persistence.
- **Persistence:** Implements data storage using JSON files.
- **Resources:** Define the structure of library resources (e.g., books).
- **Services:** Manage business logic (e.g., CRUD operations).
- **ResourceFactory:** Creates resource objects (e.g., books).

### `data/books.json`
Stores all book data in a structured JSON format.

---

## Future Enhancements
- Add support for user authentication.
- Integrate with a database (e.g., MySQL) for larger datasets.
- Improve the user interface with a frontend framework (e.g., React or Vue).
- Add validations for inputs to improve data integrity.

---

## License
This project is open-source and available under the MIT License.

---

## Author
**Wilmer Salazar**


