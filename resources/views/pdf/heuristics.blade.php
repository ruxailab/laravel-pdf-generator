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
$example = '[
    {
        "total": 6,
        "lastUpdate": null,
        "progress": "100.0",
        "submitted": true,
        "userDocId": "FYRP8ZTFYYdqY1zkNUOu9kPxGKb2",
        "heuristicQuestions": [
            {
                "heuristicTotal": 5,
                "heuristicId": 1,
                "heuristicTitle": "Visibilidad y estado del sistema ",
                "heuristicQuestions": [
                    {
                        "heuristicAnswer": 1,
                        "heuristicComment": "",
                        "heuristicId": "1"
                    },
                    {
                        "heuristicId": "2",
                        "heuristicAnswer": 1,
                        "heuristicComment": ""
                    },
                    {
                        "heuristicAnswer": 1,
                        "heuristicId": "3",
                        "heuristicComment": ""
                    },
                    {
                        "heuristicAnswer": 1,
                        "heuristicId": "4",
                        "heuristicComment": ""
                    },
                    {
                        "heuristicAnswer": 0,
                        "heuristicId": "5",
                        "heuristicComment": ""
                    }
                ]
            },
            {
                "heuristicId": 2,
                "heuristicTitle": "bla",
                "heuristicQuestions": [
                    {
                        "heuristicId": "1",
                        "heuristicAnswer": 0.5,
                        "heuristicComment": ""
                    }
                ],
                "heuristicTotal": 1
            }
        ]
    },
    {
        "progress": "100.0",
        "userDocId": "VCbA9EMKkpOhVZlXFfrOu812CPq2",
        "lastUpdate": null,
        "heuristicQuestions": [
            {
                "heuristicId": 1,
                "heuristicQuestions": [
                    {
                        "heuristicAnswer": 1,
                        "heuristicComment": "Yes, the Google website includes visible titles for its pages,.",
                        "heuristicId": "1"
                    },
                    {
                        "heuristicComment": " sections of the website as needed.",
                        "heuristicAnswer": 0,
                        "heuristicId": "2"
                    },
                    {
                        "heuristicAnswer": 0.5,
                        "heuristicComment": "Yes, it is essential for a system or application to provide clear feedback and indications to users about what actions or processes are taking place. Users should have a clear understanding of what the system is doing at any given moment.\n\nTo ensure users know what the system or application is doing, consider the following practices:\n\nProvide visual cues: Use loading indicators, progress bars, or status messages to indicate ongoing processes or actions. This helps users understand that the system is working on their request.",
                        "heuristicId": "3"
                    },
                    {
                        "heuristicComment": "When the links are not clearly defined, it means that there is a lack of clarity or specificity in how the links are presented or labeled on a website or application. This can have a negative impact on the user experience and make it difficult for users to understand the purpose or destination of the links.",
                        "heuristicId": "4",
                        "heuristicAnswer": 0
                    },
                    {
                        "heuristicAnswer": 1,
                        "heuristicComment": "\nIn general, it is ideal for all actions within a system or application to be directly visible to users without requiring additional actions. This approach improves usability and ensures a smooth user experience. When actions are directly visible, users can easily identify and access the available options, reducing cognitive load and saving time.",
                        "heuristicId": "5"
                    }
                ],
                "heuristicTotal": 5,
                "heuristicTitle": "Visibilidad y estado del sistema "
            },
            {
                "heuristicTotal": 1,
                "heuristicQuestions": [
                    {
                        "heuristicId": "1",
                        "heuristicAnswer": 0,
                        "heuristicComment": "não entendi a questão"
                    }
                ],
                "heuristicId": 2,
                "heuristicTitle": "bla"
            }
        ],
        "submitted": true,
        "total": 6
    }
]';$options = '[
    {
        "description": "you agree",
        "value": 1,
        "text": "Si"
    },
    {
        "description": "you dont totally agree",
        "text": "no si/ no no",
        "value": 0.5
    },
    {
        "description": "you disagree",
        "text": "no",
        "value": 0
    },
    {
        "text": "no se aplica",
        "description": "a questão não se aplica",
        "value": null
    }
]';

// Decode the JSON data
$exampleArray = $data['testAnswers'];
$optionsArray = $data['testOptions'];


// Counter array to store the element count
$elementCount = array();

// Iterate through each item in the example data
foreach ($exampleArray as $item) {
    // Iterate through each heuristic in the item
    foreach ($item['heuristicQuestions'] as $index => $heuristic) {
        // Iterate through each question in the heuristic
        foreach ($heuristic['heuristicQuestions'] as $question) {
            // Get the question ID and answer
            $questionId = $question['heuristicId'];
            $answer = $question['heuristicAnswer'];
            
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
        <h1>Reasearch Heuristics</h1>
        @foreach($data['heuristics'] as $key => $item)
            <div class="question">
                <h3 class="question-title">Heuristic question {{ $key + 1 }}: {{ $item['title'] }}</h3>
                <p>Heuristic extensive description for human eyes.</p>
            </div>
            <div class="chart">
                <?php

                    foreach ($data['testOptions'] as $option) {
                        if (isset($option['text'])) {
                            $variableName = $option['text'];
                            $auxOptions[$variableName] = 0; // Initialize variable with value 0
                        }
                        if (isset($option['value'])) {
                            $auxOptionsValue[] = $option['value'];
                        }
                    }

                    foreach ($data['testAnswers'] as $index => $answer) {
                        foreach ($answer['heuristicQuestions'] as $heuristics) {
                            
                            foreach ($heuristics['heuristicQuestions'] as $questions) {
                                $heuristicAnswer = $questions['heuristicAnswer'];
                                foreach ($data['testOptions'] as $option) {
                                    if (isset($option['value']) && $option['value'] == $heuristicAnswer) {
                                        $variableName = $option['text'];
                                        if (isset($auxOptions[$variableName])) {
                                            $auxOptions[$variableName]++; // Increment the respective variable
                                        }
                                    }
                                }
                            }
                        }
                    }
    

                    $total = array_sum($auxOptions);

                    $colors = ['#EE303A', '#F53D3B', '#FD533A','#FE5B38', '#FF6937', '#FF7B2F', '#FF8D23']; // Orange tones
        
                    foreach ($auxOptions as $index => $value) {
                        $percentage = ($value / $total) * 100;
                        $width = round($percentage, 2);

                        $colorIndex = round(($value / $total) * (count($colors) - 1));
                        $color = $colors[$colorIndex];

                        echo '<div class="bar" style="width: ' . $width . '%; background-color: ' . $color . ';">';
                        echo '<div class="bar-value">' . $value . '</div>';
                        echo '</div>'; //end of the chart section
                    }

            ?>
                    @foreach ($item['questions'] as $question)
                        <li class="answers">
                            <h4>{{ $question['title'] }}</h4>
                            <p>{{ $question['descriptions'] }}</p>
                            <ul>
                              
                            </ul>
                            
                        </li>
                        <div class="page-break"></div>
                    @endforeach

           
        @endforeach
    </div>
</body>
</html>
