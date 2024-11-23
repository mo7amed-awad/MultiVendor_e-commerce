@props([
    'name','options','checked'=>false
])

@foreach ($options as $value => $text)
    <div class="form-check">
        <input type="radio" name="{{ $name }}" value="{{ $value }}"
            @checked(old($name, $checked) == $value)
            {{ $attributes->class([
                'form-check-input',
                'is-invalid'=>$errors->has($name)
            ])}}>
        <label for="{{ $name }}" class="form-check-label">{{ $text }}</label>
    </div>
@endforeach


{{-- <div class="form-check">
    <input type="radio" class="form-check-input" name="status" value="archived" @checked(old('status',$category->status)=='archived')>
    <label for="status" class="form-check-label">Archived</label>
</div> --}}