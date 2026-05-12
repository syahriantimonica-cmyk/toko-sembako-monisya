@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-red-600 space-y-1']) }}>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif