<?php
$file = '..\data\books.txt';

function getBooks($file) {
    if (!file_exists($file) || !is_readable($file)) {
        return [];
    }
    $books = [];
    $fileContents = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($fileContents as $line) {
        list($id, $title, $author) = explode('|', $line);
        $books[] = ['id' => $id, 'title' => $title, 'author' => $author];
    }
    return $books;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $books = getBooks($file);
    foreach ($books as $book) {
        if ($book['id'] == $id) {
            echo "ID: " . $book['id'] ."<br>". " Judul: " . $book['title'] ."<br>". " Penulis: " . $book['author'] ."<br>". "
";
            break;
        }
    }
} else {
    $books = getBooks($file);
    foreach ($books as $book) {
        echo "ID: " . $book['id'] ."<br>". " Judul: " . $book['title'] ."<br>". " Penulis: " . $book['author'] ."<br>". "
";
    }
}