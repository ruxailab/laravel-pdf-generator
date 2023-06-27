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
    position:absolute;
    bottom:1cm;
    right:1cm;
}

h1 {
    color: #FFA600;
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #FFA600;
}

/* Chart settings */    

.bar {
  position: relative;
  width: 100%;
  height: 20px;
  margin: 10px;
  padding: 5px;
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
  margin-top: auto; /* Align the value to the vertical middle */
  margin-bottom: auto;
  margin-right:4px;
}

.value-name {
  font-size: 20px;
  float: left;
  margin-top: auto; /* Align the text to the vertical middle */
  margin-bottom: auto;
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
            foreach ($optionsArray as $option) {
                if ($option['value'] === $answer) {
                    $text = $option['text'];
                    break;
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


<div class="heuristic">
    @foreach($data['heuristics'] as $key => $item)
        <div class="question">
            <h1 class="question-title">Heuristic {{ $key + 1 }}: {{ $item['title'] }}</h1>
        </div>

        <div class="chart">

    <?php
    $heuristicQuestions = $data['heuristics'][$key]['questions'];

    foreach ($heuristicQuestions as $question) {
        $questionId = $question['id'];
        $total = array_sum($elementCount[$key][$questionId]);

        $colors = ['#EE303A', '#F53D3B', '#FD533A', '#FE5B38', '#FF6937', '#FF7B2F', '#FF8D23']; // Orange tones
        echo '<h2>' . $question['title'] . '</h2>';
        echo '<p>' . $question['descriptions'] . '</p>';
        echo '<div style="background-color: #F0F0F0; padding: 10px; border-radius: 20px;">';
      
        // Loop through the optionsArray instead of using array_reverse
        foreach ($optionsArray as $option) {
            $text = $option['text'];
            if (isset($elementCount[$key][$questionId][$text])) {
                $value = $elementCount[$key][$questionId][$text];
        
                $percentage = ($value / $total) * 100;
                $width = round($percentage, 2);
        
                $colorIndex = round(($value / $total) * (count($colors) - 1));
                $color = $colors[$colorIndex];
        
                echo '<div class="bar" style="width: ' . $width . '%; background-color: ' . $color . ';">';
                echo '<div class="bar-value">' . $value . '</div>';
                echo '<div class="value-name">' . $text . '</div>';
                echo '</div>';
            }
        }
        
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
                
                echo '<div class="page-break"></div>';
            }
            ?>
        </div>
    @endforeach
</div>
</body>
</html>
