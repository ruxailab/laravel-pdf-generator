<div class="page-section" style="text-align: center; margin-top: 15rem;">
    <h1 style="font-size: 24pt; font-weight: bold; margin-bottom: 1rem;">
        {{ $data['title'] }}
    </h1>

    <div style="font-size: 16pt; font-weight: bold; margin-bottom: 20px;">
        <?php
            $timestamp = $data['creationDate'];
            $dateTime = new DateTime('@' . floor($timestamp / 1000));
            echo $dateTime->format('F j, Y');
        ?>
    </div>

    <div style="font-style: italic;">
        <div style="font-weight: bold; font-size: 18px;">
            {{ $data['creatorEmail'] }}
        </div>

        @php
            $cooperators = is_array($data['cooperatorsEmail']) ? $data['cooperatorsEmail'] : [$data['cooperatorsEmail']];
        @endphp

        @foreach($cooperators as $email)
            <div style="margin-top: 5px; font-size: 15px;">
                {{ $email }}
            </div>
        @endforeach
    </div>
</div>
