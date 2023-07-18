<!DOCTYPE html>
<html>
<head>
    <title>My Project Title</title>
    <style>
        /* Page settings */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .foreword-container {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 2cm;
            width: 100vw;
            height: 842px;
        }
        .tax-title {
            font-size: 24pt;
            font-weight: bold;
            margin-top:20rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        /* Title settings */
        .tax-h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Email settings */
        .tax-p {
            margin-bottom: 10px;
            text-align: center;
            font-style: italic;
        }

        /* Add any additional styles for different HTML elements here */
    </style>
</head>
<body>
    <div class="foreword-container">
        <div class="tax-title">
            <?php echo $data['title']; ?>
        </div>
        <div class="tax-h1">
            <?php
            $timestamp = $data['creationDate']; // Replace with your timestamp value
            $dateTime = new DateTime('@' . floor($timestamp / 1000));
            $date = $dateTime->format('F j, Y'); // Format the date as "July 17, 2023"

            echo $date;
            ?>
        </div>
        <div class="tax-p">
            <?php echo $data['creatorEmail']; ?>
        </div>
    </div>
</body>
</html>
