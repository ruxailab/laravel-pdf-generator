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
