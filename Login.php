<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
       body {
            font-family: 'Playfair Display', serif;
    color: #5d4037;
    text-align: center;
    margin: 0;
    min-height: 100vh;
    background: url('nyam.PNG') center center fixed,
    linear-gradient(to right, #ffcc80, #fff3e0, #ffe0b2);
    background-size: cover; 
    background-repeat: no-repeat; 
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    position: relative;
        }

        .container {
            width: 400px;
            background: #fff8f0;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(214, 130, 0, 0.2);
        }

        h2 {
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            color: #e65100;
            margin-bottom: 20px;
        }

        input, button {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        button {
            background-color: #ff7043;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #e64a19;
        }

        .message {
            margin: 15px 0;
            font-weight: bold;
            color: #e65100;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <div id="message" class="message"></div>

    <form id="loginForm" method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); 

        $('#message').removeClass('error success').text('Loading...');

        var formData = $(this).serialize();

        $.ajax({
            url: 'ActionLogin.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#message').removeClass('error').addClass('success').text(response.message);
                    
                    setTimeout(function() {
                        window.location.href = 'Dashboard.php';
                    }, 1000);
                } else {
                    $('#message').removeClass('success').addClass('error').text(response.message);
                }
            },
            error: function() {
                $('#message').removeClass('success').addClass('error').text('Terjadi kesalahan pada server.');
            }
        });
    });
});
</script>

</body>
</html>