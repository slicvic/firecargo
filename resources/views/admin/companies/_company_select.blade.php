<select class="form-control" name="{{ $name }}" required>
    <option value="">- Choose -</option>
    @foreach (\App\Models\Company::all() as $company)
        <option value="{{ $company->id }}"{{ ($company->id == $default) ? ' selected' : '' }}>{{ $company->name }}</option>
    @endforeach
</select>
