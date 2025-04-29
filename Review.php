<?php
include 'database/db.php';

if (!isset($_GET['id_book'])) {
    echo "Buku tidak ditemukan.";
    exit;
}

$id_book = $_GET['id_book'];

$queryBook = "SELECT * FROM crud_041_book WHERE id_book = ?";
$stmt = $conn->prepare($queryBook);
$stmt->bind_param("s", $id_book);
$stmt->execute();
$resultBook = $stmt->get_result();

if ($resultBook->num_rows === 0) {
    echo "Buku tidak ditemukan.";
    exit;
}

$book = $resultBook->fetch_assoc();

// Ambil review dari buku
$queryReview = "SELECT id, name, review, rating, date FROM crud_041_book_reviews WHERE book_id = ? ORDER BY date DESC";
$stmtReview = $conn->prepare($queryReview);
$stmtReview->bind_param("s", $id_book);
$stmtReview->execute();
$resultReview = $stmtReview->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Buku - <?= htmlspecialchars($book['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(115, 0, 35);
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgb(86, 6, 6);
        }

        .card-body {
            padding: 20px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #831717;
            padding-bottom: 5px;
        }

        .review-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        .review-date {
            font-size: 14px;
            color: #cf3030;
        }

        .review-text {
            font-size: 16px;
            margin-top: 10px;
            color: #7a0a0a;
        }

        .review-rating {
            font-size: 18px;
            color: #f39c12;
        }

        #bookTitle {
            font-size: 36px;
            font-weight: bold;
            text-transform: uppercase;
            color: transparent;
            background: linear-gradient(45deg, #ceacacf7, #ffffff); 
            -webkit-background-clip: text;
            text-align: center;
            padding: 10px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        .btn-back {
            text-align: center;
            margin-top: 40px;
        }

        .btn-back a {
            color: #fff;
        }

        .btn-back p {
            font-size: 18px;
            color: #fafcff;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container">
        <p style="color: #ffffff; text-align: center;">Temukan berbagai ulasan dan pengalaman dari pembaca lain yang telah menyelesaikan buku ini. Mari kita lihat apa yang mereka pikirkan!</p>

        <h3 id="bookTitle"><?= htmlspecialchars($book['title']) ?></h3>

        <div class="mt-4">
            <?php if ($resultReview->num_rows > 0): ?>
                <?php while ($review = $resultReview->fetch_assoc()): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="review-header">
                                <div class="review-name"><?= htmlspecialchars($review['name']) ?></div>
                                <div class="review-date"><?= date('d M Y', strtotime($review['date'])) ?></div>
                            </div>
                            <p class="review-text"><strong>Review:</strong> <?= nl2br(htmlspecialchars($review['review'])) ?></p>
                            <p class="review-rating"><?= str_repeat("★", $review['rating']) . str_repeat("☆", 5 - $review['rating']) ?></p>

                            <div class="review-actions">
                                <a href="form.php?id=<?= urlencode($review['id']) ?>&id_book=<?= urlencode($id_book) ?>" class="btn btn-warning btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-white text-center">Belum ada review untuk buku ini.</p>
            <?php endif; ?>
        </div>

        <div class="btn-back">
            <p>Ingin memberi review?</p>
            <a href="form.php?id_book=<?= urlencode($id_book) ?>" class="btn btn-secondary">Tulis Review</a>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
