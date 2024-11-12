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
        $data .= "{$book['id']}|{$book['title']}|{$book['author']}
";
    }
    file_put_contents($file, $data);
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idsdelete = explode(',', $_GET['id']); //buat miisahin yaw
    $idsdelete = array_filter($idsdelete, 'is_numeric');
    $books = getBooks($file);
    $updatedBooks = [];

    foreach ($books as $book) {
        if (!in_array($book['id'], $idsdelete)) {
            $updatedBooks[] = $book;
        }
    }

    if (count($updatedBooks) < count($books)) {
        saveBooks($file, $updatedBooks);
        echo "Buku berhasil dihapus!";
    } else {
        echo "Buku tidak ditemukan.";
    }
} else {
    echo "ID buku tidak valid.";
}
//sesudah