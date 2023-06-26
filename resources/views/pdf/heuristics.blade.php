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

h1{
    color: #FFA600;
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #FFA600;
}

    /* Chart settings */    
    .chart {
      width: 50vw;
    }
    
    .bar {
      position: relative;
      width: 100%;
      height: 20px;
      margin-bottom: 10px;
      background-color: #2196F3;
      transition: width 0.8s ease-in-out;
    }
    
    .bar-value {
      position: absolute;
      top: 0;
      right: 5px;
      height: 100%;
      line-height: 20px;
      color: white;
    }

    /* General heuristics settings*/
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


foreach ($commentsArray as $index => $heuristics) {
    echo "<h2>Heuristic " . ($index + 1) . "</h2>";
    foreach ($heuristics as $questionId => $comments) {
        echo "<h3>Question ID: " . $questionId . "</h3>";
        foreach ($comments as $comment) {
            echo "<p>" . $comment . "</p>";
        }
    }
}
?>

<?php foreach ($elementCount as $index => $questions) : ?>
        <h2>Heuristic <?php echo $index + 1; ?></h2>
        <table>
            <tr>
                <th>Question ID</th>
                <th>Answer</th>
                <th>Count</th>
            </tr>
            <?php foreach ($questions as $questionId => $answers) : ?>
                <?php foreach ($answers as $text => $count) : ?>
                    <tr>
                        <td><?php echo $questionId; ?></td>
                        <td><?php echo $text; ?></td>
                        <td><?php echo $count; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

    <div class="heuristic">
    <h1>Research Heuristics</h1>
@foreach($data['heuristics'] as $key => $item)
    <div class="question">
        <h3 class="question-title">Heuristic question {{ $key + 1 }}: {{ $item['title'] }}</h3>
        <p>Heuristic extensive description for human eyes.</p>
    </div>

    <div class="chart">
        <?php
        $heuristicQuestions = $data['heuristics'][$key]['questions'];

        foreach ($heuristicQuestions as $question) {
            $questionId = $question['id'];
            $total = array_sum($elementCount[$key][$questionId]);

            $colors = ['#EE303A', '#F53D3B', '#FD533A', '#FE5B38', '#FF6937', '#FF7B2F', '#FF8D23']; // Orange tones
            echo '<h4>'. $question['title']. '</h4>';
            echo '<p>'. $question['descriptions']. '</p>';
            foreach ($elementCount[$key][$questionId] as $text => $value) {
                $percentage = ($value / $total) * 100;
                $width = round($percentage, 2);

                $colorIndex = round(($value / $total) * (count($colors) - 1));
                $color = $colors[$colorIndex];

                echo '<div class="bar" style="width: ' . $width . '%; background-color: ' . $color . ';">';
                echo '<div class="bar-value">' . $value . '</div>';
                echo '</div>'; //end of the bar section
            }
            
            // Display the corresponding comments for the current chart
            if (isset($commentsArray[$key][$questionId])) {
                echo '<ul>';
                foreach ($commentsArray[$key][$questionId] as $comment) {
                    echo '<li>' . $comment . '</li>';
                }
                echo '</ul>';
            }
        }
        ?>
        <div class="page-break"></div>
    </div>
@endforeach
    </div>
</body>
</html>
