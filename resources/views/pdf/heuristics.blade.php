<!DOCTYPE html>
<html>
<head>
    <title>Heuristic Questions</title>
    <style>
        /* Page settings */
        body {
            background-color: transparent;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .page-break {
            page-break-before: always;
            page-break-inside: avoid;
            position: absolute;
            bottom: 1cm;
            right: 1cm;
        }

        .heuristic h1 {
            
            margin-top: 3rem;
        
            color: #FFA600;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #FFA600;
        }
        .question{
            
            margin-top: 2rem !important;
        
        }
        h2{
            margin-top: 3rem !important;
        }
        /* Chart settings */    

        .bar {
            position: relative;
            width: 100%;
            height: 20px;
            margin: 10px;
            padding: 10px;
            border-radius: 0 5px 5px 0;
            background-color: #2196F3;
            transition: width 0.8s ease-in-out;
            display: flex;
            align-items: center;
        }

        .bar::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 1px; /* Adjust the width of the line as needed */
            background-color: #000; /* Adjust the color of the line as needed */
        }

        .bar-value {
            font-size: 20px;
            float: right;
            margin-right: 4px;
            margin-bottom: 100px;
            color: black;
        }

        .value-name {
            font-size: 20px;
            float: left;
            position: absolute;
            white-space: nowrap;
            color: black;
            margin-bottom: 5px;
        }

        .value-name-inside {
            margin-right: 4px;
        }

        .value-name-outside {
            margin-left: 4px;
            color: black;
        }

        /* General heuristics settings */
        .heuristic {
     
        }

        .heuristic h3.question-title {
            color: #FFA500;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .heuristic .question {
            color: #333333;
            margin-bottom: 15px;
        }

        .heuristic .question p {
            margin: 0;
            line-height: 1.4;
        }

        .heuristic .answer {
            margin-left: 20px;
            list-style-type: disc;
        }

        .heuristic .answer li {
            margin-bottom: 5px;
        }

        .heuristic .answer li:last-child {
            margin-bottom: 0;
        }

        /* Comment formatting */
        .comment-list {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
        }

        .comment-item {
            margin-bottom: 10px;
        }

        .comment-text {
            background-color: #f5f5f5;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Decode the JSON data
    $Answers = $data['testAnswers'];
    $optionsArray = $data['testOptions'];

    // Counter array to store the element count
    $elementCount = array();
    // Comments array to store the answer comments
    $commentsArray = array();

    // Iterate through each item in the example data
    foreach ($Answers as $item) {
        // Iterate through each heuristic in the item
        foreach ($item['heuristicQuestions'] as $index => $heuristic) {
            // Iterate through each question in the heuristic
            foreach ($heuristic['heuristicQuestions'] as $question) {
                // Get the question ID and answer
                $questionId = $question['heuristicId'];
                $answer = $question['heuristicAnswer'];

                $comment = $question['heuristicComment'];

                // Store the comment in the comments array
                if (!isset($commentsArray[$index][$questionId])) {
                    $commentsArray[$index][$questionId] = array();
                }
                $commentsArray[$index][$questionId][] = $comment;
                // Find the corresponding text in the options array
                $text = null;
                if ($optionsArray && is_array($optionsArray)) {
                    foreach ($optionsArray as $option) {
                        if ($option['value'] === $answer) {
                            $text = $option['text'];
                            break;
                        }
                    }
                }

                // Increment the counter for the question ID and answer text
                if (!isset($elementCount[$index][$questionId][$text])) {
                    $elementCount[$index][$questionId][$text] = 1;
                } else {
                    $elementCount[$index][$questionId][$text]++;
                }

            }
        }
    }
    ?>

    <!-- Start of HTML markup -->
    <div class="heuristic">
        @foreach($data['heuristics'] as $key => $item)
        <div class="question">
            <h1 class="question-title">Heuristic {{ $key + 1 }}: {{ $item['title'] }}</h1>
        </div>

        <div class="chart">
            <?php
            $heuristicQuestions = $data['heuristics'][$key]['questions'];

            foreach ($heuristicQuestions as $index => $question) {
                $questionId = $question['id'];
                $total = array_sum($elementCount[$key][$questionId]);

                $colors = ['#EE303A', '#F53D3B', '#FD533A', '#FE5B38', '#FF6937', '#FF7B2F', '#FF8D23']; // Orange tones

                // Output the question title and description
                echo '<h2>' . ($index + 1) . " - " . $question['title'] . '</h2>';
                echo '<p>' . $question['descriptions'] . '</p>';

                // Start of the chart container
                echo '<div style="background-color: #F0F0F0; padding: 10px; border-radius: 20px;">';

                // Loop through the optionsArray if it is not null
                if ($optionsArray && is_array($optionsArray)) {
                    foreach ($optionsArray as $option) {
                        $text = $option['text'];
                        if (isset($elementCount[$key][$questionId][$text])) {
                            $value = $elementCount[$key][$questionId][$text];

                            $percentage = ($value / $total) * 100;
                            $width = round($percentage, 2);

                            $colorIndex = round(($value / $total) * (count($colors) - 1));
                            $color = $colors[$colorIndex];

                            // Determine the CSS class for value-name based on percentage
                            $valueNameClass = ($percentage >= 50) ? 'value-name value-name-inside' : 'value-name value-name-outside';

                            // Set the left value for value-name-outside based on percentage
                            $leftValue = ($percentage < 30) ? 5 * $percentage . '%' : '0px';

                            // Output the bar with value and text
                            echo '<div class="bar" style="width: ' . $width . '%; background-color: ' . $color . ';">';
                            echo '<div class="bar-value">' . $value . '</div>';

                            // Output the value-name with the appropriate CSS class and left value
                            echo '<div class="' . $valueNameClass . '" style="margin-left: ' . $leftValue . ';">' . $text . '</div>';

                            echo '</div>';
                        }
                    }
                }

                // End of the chart container
                echo '</div>';

                // Display the corresponding comments for the current chart
                if (isset($commentsArray[$key][$questionId])) {
                    $nonEmptyComments = array_filter($commentsArray[$key][$questionId]); // Filter out empty comments
                    if (!empty($nonEmptyComments)) {
                        $commentCount = count($nonEmptyComments);
                        echo '<div class="comment-title">';
                        echo ($commentCount > 1) ? '<h3>Comments</h3>' : '<h3>Comment</h3>';
                        echo '</div>';
                        echo '<ul class="comment-list">';
                        foreach ($nonEmptyComments as $comment) {
                            echo '<li class="comment-item"><div class="comment-text">' . $comment . '</div></li>';
                        }
                        echo '</ul>';
                    }
                }

                // Add a page break after each chart
                echo '<div class="page-break"></div>';
            }
            ?>
        </div>
        @endforeach
    </div>
</body>
</html>
