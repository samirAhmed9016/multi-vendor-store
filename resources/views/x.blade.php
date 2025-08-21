<form method="POST" action="{{ route('currency.store') }}">
    @csrf
    <select name="currency_code" onchange="this.form.submit()">
        @foreach ($currencies as $code => $details)
            <option value="{{ $code }}" @selected($code === session('currency_code', config('app.currency')))>
                {{ $details['symbol_native'] ?? $code }} ({{ $code }})
            </option>
        @endforeach
    </select>
</form>
