<select name="{{ $name }}" class="form-control">
    @foreach (\App\Models\Country::all() as $country)
        <option{{ ($country->id == $selectedOption) ? ' selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
    @endforeach
</select>
