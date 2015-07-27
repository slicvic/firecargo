<select required class="form-control" name="{{ $name }}">
    <option value="">- Choose -</option>
    @foreach (\App\Models\Company::all() as $company)
        <option value="{{ $company->id }}"{{ ($company->id == $selectedOption) ? ' selected' : '' }}>{{ $company->name }}</option>
    @endforeach
</select>
