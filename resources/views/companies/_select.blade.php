<select required class="form-control" name="{{ $name }}">
    <option value="">- Choose -</option>
    @foreach (\App\Models\Company::all() as $company)
        <option{{ ($company->id == $selectedOption) ? ' selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
    @endforeach
</select>
