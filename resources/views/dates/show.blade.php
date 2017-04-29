<h1>{{ $date->getStatusLabel() }}: {{ __('Option') }} {{ $date->formatted_from_date }} - {{ $date->formatted_to_date }}</h1>

<p>{{ __('From') }}: {{ $date->formatted_start_time }}</p>
<p>{{ __('To') }}: {{ $date->formatted_end_time }}</p>
<em>{{ __('Price') }}: {{ $date->formatted_price }}</em>
<em>{{ __('Total options') }}: {{ $date->totalOptions() }}</em>