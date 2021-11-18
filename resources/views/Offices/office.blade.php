

<div class="">
    <table>
        <thead>
            <th>office monthly_discount</th>
            <th>office description</th>
            <th>office approval_status</th>
            <th>office Price</th>
            <th>office Monthly Discount</th>
        </thead>
        <tbody>
            @foreach($offices as $office)
                <tr>
                    {{ $office->title }}
                    {{ $office->description }}
                    {{ $office->approval_status }}
                    {{ $office->price_per_day }}
                    {{ $office->monthly_discount }}
                </tr>
           @endforeach
        </tbody>
    </table>
</div>