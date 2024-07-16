@foreach ($data as $row)
    @if ($row->pdf != null)
        @php
            $pdfs = json_decode($row->pdf);
        @endphp

        @foreach ($pdfs as $pdf)
            <a href="{{ asset('storage/' . $pdf) }}" target="_blank">{{ basename($pdf) }}</a><br>
        @endforeach
    @else
        pdf not found
    @endif
@endforeach
