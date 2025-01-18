<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown to Tết Nguyên Đán</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #000; /* Nền đen */
            color: #fff; /* Màu chữ mặc định */
            text-align: center;
        }

        .container {
            padding: 50px;
        }

        .title {
            font-size: 40px;
            color: #f39c12; /* Màu vàng cam */
            margin-bottom: 20px;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 60px;
            margin-bottom: 20px;
        }

        .countdown div {
            text-align: center;
        }

        .countdown div span {
            display: block;
            font-size: 18px;
            margin-top: 10px;
            color: #f39c12; /* Màu vàng cam */
        }

        .countdown div div {
            color: #f39c12; /* Màu vàng cam cho số */
        }

        .description {
            font-size: 18px;
            line-height: 1.5;
            max-width: 800px;
            margin: 0 auto;
            color: #fff; /* Màu trắng cho đoạn mô tả */
        }

        .container {
            padding: 50px;
        }

        .title {
            font-size: 40px;
            color: #f39c12;
            margin-bottom: 20px;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 60px;
            margin-bottom: 20px;
        }

        .countdown div {
            text-align: center;
        }

        .countdown div span {
            display: block;
            font-size: 18px;
            margin-top: 10px;
            color: #f39c12;
        }

        .description {
            font-size: 18px;
            line-height: 1.5;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Countdown to the Year of the Dragon</h1>
        <div class="countdown" id="countdown">
            <div>
                <div id="days">00</div>
                <span>Days</span>
            </div>
            <div>
                <div id="hours">00</div>
                <span>Hours</span>
            </div>
            <div>
                <div id="minutes">00</div>
                <span>Minutes</span>
            </div>
            <div>
                <div id="seconds">00</div>
                <span>Seconds</span>
            </div>
        </div>
        <p class="description">
            Tết Nguyên Đán is a time of joy, reflection, and hope for the future, as families come together to celebrate traditions passed down through generations. Let's welcome the arrival of a new year filled with possibilities.
        </p>
    </div>

    <script>
        function updateCountdown() {
            const tetDate = new Date("2025-01-29T00:00:00");
            const now = new Date();
            const timeDiff = tetDate - now;

            if (timeDiff > 0) {
                const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                document.getElementById("days").textContent = String(days).padStart(2, "0");
                document.getElementById("hours").textContent = String(hours).padStart(2, "0");
                document.getElementById("minutes").textContent = String(minutes).padStart(2, "0");
                document.getElementById("seconds").textContent = String(seconds).padStart(2, "0");
            } else {
                document.getElementById("countdown").textContent = "Happy Lunar New Year!";
            }
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>
</html>
