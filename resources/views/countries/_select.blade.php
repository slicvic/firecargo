<select name="{{ $name }}" class="form-control">
    @foreach (\App\Models\Country::all() as $country)
        <option value="{{ $country->id }}"{{ ($country->id == $selectedOption) ? ' selected' : '' }}>{{ $country->name }}</option>
    @endforeach
</select>
