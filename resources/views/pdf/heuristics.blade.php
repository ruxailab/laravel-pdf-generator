<!DOCTYPE html>
<html>
<head>
    <title>Heuristic Questions</title>
    <style>
        body {
            background-color: transparent;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
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

        .variable-div {
            height: 1vh;
            background-color: #FFA500;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="heuristic">
        <?php 
        $array = [
            [
                'question' => 'Question example 1',
                'answers' => ['Answer 1.1', 'Answer 1.2', 'Answer 1.3']
            ],
            [
                'question' => 'Question example 2',
                'answers' => ['Answer 2.1', 'Answer 2.2', 'Answer 2.3']
            ],
            // Add more items as needed
        ]; ?>

        @foreach($array as $key => $item)
            <div class="question">
                <h3 class="question-title">Heuristic question {{ $key + 1 }}: {{ $item['question'] }}</h3>
                <p>Heuristic extensive description for human eyes.</p>
            </div>
            <div class="container">
            <div class="chart">
            <?php
                $data = [30, 20, 15, 35, 100]; // Example data array

                $total = array_sum($data);

                $colors = ['#FF8D23', '#FF7B2F', '#FF6937','#FE5B38', '#FD533A', '#F53D3B', '#EE303A']; // Orange tones
      
                 foreach ($data as $index => $value) {
                     $percentage = ($value / $total) * 100;
                     $width = round($percentage, 2);

                     $colorIndex = round(($value / $total) * (count($colors) - 1));
                     $color = $colors[$colorIndex];

                     echo '<div class="bar" style="width: ' . $width . '%; background-color: ' . $color . ';">';
                     echo '<div class="bar-value">' . $value . '</div>';
                     echo '</div>';
                  }
            ?>
  </div>
    </div>
            <ul class="answer">
                @foreach($item['answers'] as $answer)
                    <li>{{ $answer }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
</body>
</html>
