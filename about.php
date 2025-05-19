<?php
include 'database/db.php';

$query = "SELECT * FROM crud_041_book";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - BookView</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(28, 79, 45);
            font-family: 'Arial', sans-serif;
            color: #fafcff;
        }
        .book-item {
            border: 1px solid #d3bbbbc6;
            padding: 15px;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            display: none;
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

        .navbar {
            margin-bottom: 20px;
        }

        .container {
            margin-top: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 20px;
        }

        .about-text {
            font-size: 1.2rem;
            color: #fafcff;
            line-height: 1.8;
            text-align: center;
            text-align: justify;
        }

        .about-image {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .about-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .team-member {
            margin-bottom: 30px;
            text-align: center;
        }

        .team-member img {
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 120px;
            height: 120px;
        }

        .team-member h5 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fafcff;
            margin-top: 10px;
        }

        .team-member p {
            font-size: 1rem;
            color: #ddd;
        }

        .footer {
            background-color:rgb(255, 255, 255);
            color: green;
            padding: 20px 0;
            text-align: center;
        }

        .footer a {
            color:rgb(28, 80, 23);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
        .navbar {
            background-color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: rgb(33, 80, 40) !important; 
        }
        .navbar-nav .nav-link:hover {
            color: rgb(0, 0, 0) !important; 
        }
        .navbar-nav .nav-link.active {
            color: rgb(28, 97, 37) !important;
        }

        /* Ensure the dropdown is clickable */
        .dropdown-menu {
            z-index: 1050; /* Make sure it's on top */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: green;">Freshure</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Beranda.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Jenis </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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
        <?php while($row = mysqli_fetch_assoc($result)): ?>
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
    
    <div class="container">
        <div class="about-header">
            <h2 class="section-title"> Freshure </h2>
        </div>

        <section>
                <div class="col-md-6">
                    <p class="about-text">
                        Selamat datang di Freshure, tempat di mana tanaman hidroponik berkualitas tinggi bertemu dengan para pecinta pertanian modern!
                    </p>
                    <p class="about-text">
                        Kami menghadirkan beragam pilihan sayur segar, buah lezat, dan bunga indah, semuanya ditanam dengan metode hidroponik yang ramah lingkungan dan efisien. Hidroponik memungkinkan tanaman tumbuh lebih sehat, bebas dari pestisida berbahaya, serta menghasilkan panen berkualitas tanpa bergantung pada tanah.
                    </p>
                    <p class="about-text">
                        Dengan komitmen untuk menyediakan produk terbaik, kami bekerja sama dengan petani hidroponik berpengalaman serta menerapkan standar ketat dalam setiap tahap pertumbuhan tanaman. Kami percaya bahwa makanan sehat dan lingkungan yang lebih hijau adalah masa depan, dan kami ingin menjadi bagian dari perjalanan Anda menuju gaya hidup yang lebih sehat dan berkelanjutan.                    </p>
                    <p class="about-text">
                        Temukan keindahan dan manfaat tanaman hidroponik bersama kami, dan rasakan perbedaannya! 🌿
                    </p>
                </div>
            </div>
        </section>

        <section>
            <h3 class="section-title text-center">Tim Kami</h3>
            <div class="row">
                <div class="col-md-4 team-member">
                    <img src="images/mh.jpg" alt="Xu Minghao">
                    <h5>Xu Minghao</h5>
                    <p>CEO & Founder</p>
                </div>
                <div class="col-md-4 team-member">
                    <img src="images/dk.jpg" alt="Lee Dokyeom">
                    <h5>Lee Dokyeom</h5>
                    <p>Creative Director</p>
                </div>
                <div class="col-md-4 team-member">
                    <img src="images/sc.jpg" alt="Choi Seungcheol">
                    <h5>Choi Seungcheol</h5>
                    <p>Lead Developer</p>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2025 BookView. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
        </p>
    </footer>

    <!-- Perbaiki urutan script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        window.onload = function() {
            var bookItems = document.querySelectorAll('.book-item');
            bookItems.forEach(function(book) {
                book.style.display = 'none';
            });
        };
    </script>
</body>
</html>
