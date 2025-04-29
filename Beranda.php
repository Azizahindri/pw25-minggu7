<?php
include 'database/db.php'; 


$query = "
    SELECT 
        b.id_book,
        b.title, 
        b.author, 
        ROUND(AVG(br.rating), 1) AS average_rating
    FROM 
        crud_041_book b
    LEFT JOIN 
        crud_041_book_reviews br ON b.id_book = br.book_id
    GROUP BY 
        b.id_book
    ORDER BY 
        average_rating DESC;
";

$result = mysqli_query($conn, $query);

$queryAllBook = "SELECT * FROM crud_041_book";
$resultAllBook = mysqli_query($conn, $queryAllBook);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: rgb(116, 31, 31);
        }
        .book-item {
            border: 1px solid #d3bbbbc6;
            padding: 15px;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            display: block;
        }
        .book-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .book-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        footer {
            background-color: #00000000;
            color: rgb(255, 0, 0);
            padding: 15px;
            text-align: center;
            margin-top: 30px;
        }
        .image {
            width: 100px;
            height: auto;
            position: absolute; 
            top: 100; 
            left: 90%; 
            transform: translateX(-50%); 
            border-radius: 10px;
        }
        * {
            color: whitesmoke;
        }
        .navbar {
            background-color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: rgb(255, 0, 0) !important; 
        }
        .navbar-nav .nav-link:hover {
            color: rgb(0, 0, 0) !important; 
        }
        .navbar-nav .nav-link.active {
            color: rgb(187, 9, 9) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: crimson;">BookView</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="Beranda.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Genre
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#" onclick="clearFilter()"> All </a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('fiksi')">Fiksi</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('non-fiksi')">Non-Fiksi</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('romansa')">Romansa</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('fantasi')">Fantasi</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('misteri')">Misteri</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterGenre('sejarah')">Sejarah</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <div class="container mt-5">
        <h1 align="center" style="color: brown; font-family: Poppins"><b>  bookview </b> </h1>
        <p> Temukan Buku yang Tepat untukmu, Berdasarkan Ulasan dan Rating Pembaca Lain! </p>
        <hr>

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari buku berdasarkan judul " onkeyup="searchBooks()">
        </div>
        <p align="center"> <b> Buku Terbaik Menurut Rating: Pilihan Teratas dari Pembaca!</b></p>

        <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Rating</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // Menampilkan data buku
                    $title = $row['title'];
                    $author = $row['author'];
                    $average_rating = $row['average_rating'];

                    // Menampilkan bintang berdasarkan rating
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $average_rating) {
                            $stars .= '★';
                        } else {
                            $stars .= '☆';
                        }
                    }
                    
                    echo "
                    <tr>
                        <td>$title</td>
                        <td>$author</td>
                        <td>$stars</td>
                        <td><a href='review.php?id_book=" . urlencode($row['id_book']) . "' class='btn btn-primary btn-sm'>Review</a></td>
                    </tr>
                ";
                
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada buku yang ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>

        <p align="center"> Sudah membaca buku ini? Bagikan pendapatmu dengan kami dan bantu pembaca lainnya memilih buku terbaik! </p>
        <h2 class="text-center" style="color:floralwhite 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif "> <b>Daftar Buku</b></h2>
        <div class="book-list" id="bookList">
        <?php while($row = mysqli_fetch_assoc($resultAllBook)): ?>
            <div class="book-item <?= htmlspecialchars($row['genre']) ?> col-md-3">
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                <hr>
                <h5><?= htmlspecialchars($row['title']) ?></h5>
                <p>Penulis: <?= htmlspecialchars($row['author']) ?></p>
                <a href="form.php"><p>Isi Review</p></a>
                <details>
                    <summary>Deskripsi buku:</summary>
                    <p align="justify"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                </details>
                <a href="Review.php?id_book=<?= urlencode($row['id_book']) ?>" class='btn btn-primary btn-sm'>Review</a>
            </div>
        <?php endwhile; ?>
        </div>
        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchBooks() {
            var input, filter, books, bookItem, title, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            books = document.getElementById("bookList");
            bookItem = books.getElementsByClassName('book-item');

            for (i = 0; i < bookItem.length; i++) {
                title = bookItem[i].getElementsByTagName("h5")[0];
                txtValue = title.textContent || title.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    bookItem[i].style.display = "";
                } else {
                    bookItem[i].style.display = "none";
                }
            }
        }
        function filterGenre(genre) {
                var bookItems = document.querySelectorAll('.book-item');
                bookItems.forEach(function(book) {
                    if (book.classList.contains(genre)) {
                        book.style.display = 'block';  
                    } else {
                        book.style.display = 'none';  
                    }
                });
            }
            function clearFilter() {
            var bookItems = document.querySelectorAll('.book-item');
            bookItems.forEach(function(book) {
                book.style.display = 'block';  // Show all books
            });
        }

    </script>

    <footer>
        <p>&copy; 2025 Semua Hak Dilindungi</p>
    </footer>
</body>
</html>
