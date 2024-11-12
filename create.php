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

function isBookExists($books, $title, $author){
    foreach ($books as $book) {
        if ($book['title'] === $title && $book['author'] === $author){
            return $book; 
        }
    }
    return false;
}

if (isset($_GET['title']) && isset($_GET['author'])) {
    $titles = (array) $_GET['title'];
    $authors = (array) $_GET['author'];

    // jumlah author sama judul gaboleh lebih 3 yahh,udah dibatesinn XD
    if (count($titles) == count($authors) && count($titles) <= 3) {
        $books = getBooks($file);
        $lastId = count($books) > 0 ? $books[count($books) - 1]['id'] : 0;
        $duplicateBooks = [];
        $addedbooks = [];

        foreach ($titles as $index => $title) {
            $author = $authors[$index];
            if (!empty($title) && !empty($author)) {
                $existingBook = isBookExists($books, $title, $author);
                if ($existingBook) {
                    $duplicateBooks[] = "Buku berjudul '$title' yang ditulis oleh '$author' sudah ada";
                } else {
                    $lastId++;
                    $books[] = ['id' => $lastId, 'title' => $title, 'author' => $author];
                    $addedbooks[] = "Title: $title | Author: $author";
                }
            }
        }

        if (count($addedbooks) > 0) {
            echo count($addedbooks) . " Buku berhasil ditambahkan<br>";
            foreach ($addedbooks as $addedBook) {
                echo "$addedBook<br>";
            
            }
        }

        if (count($duplicateBooks) > 0) {
            echo count($duplicateBooks) . " buku gagal ditambahkan:<br>";
            foreach ($duplicateBooks as $duplicateBook) {
                echo "$duplicateBook<br>";
            }
        }

        saveBooks($file, $books);
    } else {
        echo "Maksimal 3 buku secara bersamaan!";
    }
} else {
    echo "Tidak ada data yang diterima.";
}
?>
