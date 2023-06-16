<!DOCTYPE html>
<html>
<head>
    <title>Article Abstract</title>
    <style>
        @media print {
            body {
                padding: 20mm;
            }

            .abstract {
                display: block;
                width: 100%;
                height: 100%;
                box-sizing: border-box;
            }

            .abstract-content {
                max-width: 170mm;
                margin: 0 auto;
                padding: 0;
                background-color: #FFFFFF;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
            color: #333333;
        }

        .abstract {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .abstract-content {
            max-width: 800px;
            padding: 20px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .abstract h1 {
            color: #FFA500;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #FFA500;
        }

        .abstract p {
            text-align: justify;
            text-indent: 1.5em;
            line-height: 1.5;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="abstract">
        <div class="abstract-content">
            <h1>Article Abstract</h1>

            <p>{{{ $data['actualdate'] }}}</p>

            <p>Maecenas ultricies lorem non ultricies fermentum. Nullam eu diam vitae neque vestibulum volutpat. Donec bibendum felis sed mauris pharetra dignissim. Nam consectetur leo a facilisis suscipit. Aenean placerat luctus dapibus. Mauris venenatis pellentesque mauris, vitae pretium metus rhoncus a. Duis interdum massa at est dignissim, ut malesuada enim rutrum. Vestibulum id nunc non ante egestas tincidunt.</p>

            <p>Sed fermentum orci sit amet urna consequat viverra. Phasellus nec erat convallis, aliquam ex ut, faucibus nisi. Ut laoreet, velit sit amet sagittis finibus, velit ipsum placerat enim, eget commodo risus ante vel tortor. Nullam egestas metus vitae dignissim iaculis. Pellentesque eget consectetur nisi. Nulla a nulla id est tincidunt mollis. Mauris tristique odio risus, sit amet rutrum felis posuere ut.</p>
        </div>
    </div>
</body>
</html>

