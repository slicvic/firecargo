<select name="{{ $name }}" class="form-control"{{ $required ? ' required' : '' }}>
    <option value="">- Choose -</option>
    @foreach (\App\Models\Country::all() as $country)
        <option value="{{ $country->id }}"{{ ($country->id == $default) ? ' selected' : '' }}>{{ $country->name }}</option>
    @endforeach
</select>
