@props(['messages'])

@if ($messages)
    <div class="alert alert-danger">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
