<?php

namespace Wilmer\Bibliotech\Persistence;

use Wilmer\Bibliotech\Interfaces\PersistenceInterface;

// JsonPersistence is a class responsible for managing data stored in a JSON file.
class JsonPersistence implements PersistenceInterface {
    private $filePath; // Path to the JSON file

    // Constructor: Initializes the class with the file path.
    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    // Reads data from the JSON file and returns it as an array.
    public function read(): array {
        if (!file_exists($this->filePath)) { // Check if the file exists
            return []; // Return an empty array if the file does not exist
        }
        $data = file_get_contents($this->filePath); // Read the file content
        return json_decode($data, true) ?? []; // Decode JSON into an array, return empty array if decoding fails
    }

    // Writes an array of data to the JSON file.
    public function write(array $data): void {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT)); 
        // Converts the array to JSON format and writes it to the file.
    }
}
