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

function saveBooks($file, $books) {
    if (!is_writable($file)) {
        echo "Gagal menyimpan data.";
        return;
    }
    $data = '';
    foreach ($books as $book) {
        $data .= "{$book['id']}|{$book['title']}|{$book['author']}\n";
    }
    file_put_contents($file, $data);
}

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['title']) && isset($_GET['author']) && !empty($_GET['title']) && !empty($_GET['author'])) {
    $id = $_GET['id'];
    $title = trim($_GET['title']);
    $author = trim($_GET['author']);
    $books = getBooks($file);
    foreach ($books as &$book) {
        if ($book['id'] == $id) {
            $book['title'] = $title;
            $book['author'] = $author;
            break;
        }
    }
    saveBooks($file, $books);{
        echo "Buku Berhasil Update.";
    }
}