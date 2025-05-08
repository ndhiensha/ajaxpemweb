<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}
include 'ConnectDatabase.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (isset($_POST['hapus'])) {
        $sql = "DELETE FROM guestbook";
        $conn->query($sql);
    }
    
    elseif (isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['pesan'])) {
        $username = $_POST['nama'];
        $email = $_POST['email'];
        $comment = $_POST['pesan'];

        $sql = "INSERT INTO guestbook (username, email, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $comment);
        $stmt->execute();
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rating Resto Rasaku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #4e342e;
            background: url('nyam.PNG') center center fixed, 
                      linear-gradient(to right, #ffe5b4, #fff7e6);
            background-size: cover;
            position: relative;
        }

        .container {
            width: 750px;
            background: #fff8f0;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: left;
            margin: 20px;
        }

        h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 3rem;
            color: #d84315;
            text-align: center;
            margin-bottom: 10px;
        }

        p, h3 {
            text-align: center;
            color: #6d4c41;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        button {
            background-color: #ff7043;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #e64a19;
        }

        .delete-button {
            background-color: #e53935;
            margin-top: 10px;
            width: 100%;
        }

        .delete-button:hover {
            background-color: #c62828;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .comment {
            background: #fff3e0;
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(222, 125, 44, 0.2);
        }

        a {
            display: block;
            margin-top: 10px;
            color: #bf360c;
            text-decoration: none;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="animate_animated animate_fadeInDown">
        <h1>Rating Resto Rasaku</h1>
    </div>
    <p>Selamat datang, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>!</p>
    <a href="Logout.php">Logout</a>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="pesan" placeholder="Tulis ulasan makanan..." required></textarea>
        <button type="submit">Kirim</button>
    </form>

    <form method="POST">
        <button type="submit" name="hapus" value="1" class="delete-button">Hapus Semua Ulasan</button>
    </form>

    <h3>Ulasan Pengunjung:</h3>
    <?php
    $sql = "SELECT username, email, comment, created_at FROM guestbook ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="comment">';
            echo '<strong>' . htmlspecialchars($row['username']) . '</strong> &lt;' . htmlspecialchars($row['email']) . '&gt; (' . $row['created_at'] . ')<br>';
            echo nl2br(htmlspecialchars($row['comment']));
            echo '</div>';
        }
    } else {
        echo "<div class='comment'>Belum ada ulasan</div>";
    }
    ?>
</div>

</body>
</html>