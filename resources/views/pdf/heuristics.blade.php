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
    max-width:90% !important;
    height: 20px;
    margin: 10px;
    padding: 10px;
    border-radius: 0 5px 5px 0;
    background-color: #2196F3;
    transition: width 0.8s ease-in-out;
    display: flex;
    align-items: center;
    box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.2); /* Add the box shadow with negative horizontal offset */
}

.bar::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 1px; /* Adjust the width of the line as needed */
    background-color: #000; /* Adjust the color of the line as needed */
    box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.2); /* Add the box shadow with negative horizontal offset */
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
            background-color: transparent;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
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
        .comment-item {
        border:1px solid #838383;
        border-radius: 20px;

        padding: 10px;

        display: flex; /* Use flexbox to arrange the comment and image in a column */
        align-items: center; /* Center items vertically inside the flex container */
        page-break-inside: avoid;
    }

    .comment-text {
        background-color: #E3E3E3;
        padding: 10px;
        flex: 1; /* Allow the comment to take up available space in the flex container */
        border-radius: 5px;
        text-align: justify; /* Add this line to justify the text */
        text-justify: inter-word; /* Add this line for better word spacing */
    }

    .comment-image {
        text-align: center; /* Center the image horizontally */
        margin-top: 10px; /* Add some space between the comment and image */
    }

    .center-image {
        max-width: 100%;
        max-height: 80%;
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
                $commentImageUrl = $question['answerImageUrl'];
                // Store the comment in the comments array
                if (!isset($commentsArray[$index][$questionId])) {
                    $commentsArray[$index][$questionId] = array();
                }
                 $commentsArray[$index][$questionId][] = $comment;
                if (!isset($urlsArray[$index][$questionId])) {
                    $urlsArray[$index][$questionId] = array();
                }
                 $urlsArray[$index][$questionId][] = $commentImageUrl;
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
        @if (isset($item) && isset($item['id']) && in_array($item['id'], $data['selectedHeuristics']))
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


                        $imageUrlsByHeuristic = [];

                        // Display the corresponding comments for the current chart
                        
                        
                        if ($data['testComments'] === true && isset($commentsArray[$key][$questionId])) {
                            $nonEmptyComments = array_filter($commentsArray[$key][$questionId]); // Filter out empty comments
                            if (!empty($nonEmptyComments)) {
                                $commentCount = count($nonEmptyComments);
                                echo '<div class="comment-title">';
                                echo ($commentCount > 1) ? '<h3>Comments</h3>' : '<h3>Comment</h3>';
                                echo '</div>';
                                echo '<ul class="comment-list">';
                                foreach ($nonEmptyComments as $index => $comment) {
                                    echo '<li class="comment-item">';
                                    echo '<div class="comment-text">' . $comment . '</div>';
                                    // Get the image file path
                                    if ($urlsArray[$key][$questionId][$index]) {
                                        $imagePath = $urlsArray[$key][$questionId][$index];
                
                                        // Read the image file
                                        $imageData = file_get_contents($imagePath);
                
                                        // Convert the image data to base64 format
                                        $base64Image = base64_encode($imageData);
                
                                        // Echo the image tag with base64 data
                                        echo '<div class="comment-image">';
                                        echo '<img class="center-image" src="data:image/jpeg;base64,' . $base64Image . '" alt="Image">';
                                        echo '</div>';
                                    
                                    }
                                    echo '</li>';
                                    echo'<div class="page-break"></div>';
                                }
                                echo '</ul>';
                            }
                        }

                    }
                    ?>
                    <div class="page-break"></div>
                </div>
            @endif
        @endforeach
       
    </div>


</body>
</html>
