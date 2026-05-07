@props(['lang', 'icon'])

<form action="{{ route('locale.switch', ['lang' => $lang]) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" aria-label="Switch language {{ $lang }}" title="{{ strtoupper($lang) }}">
        <x-dynamic-component :component="'flag-country-' . $icon" class="rounded border" width="24" height="24" />
    </button>
</form>
