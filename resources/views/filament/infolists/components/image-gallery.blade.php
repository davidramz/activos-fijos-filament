@php
$imagenes = $getRecord()->imagenes ?? [];
if (empty($imagenes)) {
return;
}
@endphp

<div class="flex flex-wrap gap-4">
    @foreach($imagenes as $image)
    <a href="{{ asset('storage/' . $image) }}" target="_blank" rel="noopener noreferrer">
        <img
            src="{{ asset('storage/' . $image) }}"
            alt="Imagen"
            width="120px"
            height="150px"
            class="p-2"
            loading="lazy" />
    </a>
    @endforeach
</div>