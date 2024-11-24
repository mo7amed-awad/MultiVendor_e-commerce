@props([
    'name'=>'',
    'id'=>'',
    'value'=>'',
    'label'=>false,
])

@if($label)
<label for="{{ $id }}">{{$label}}</label>
@endif

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    @class(['form-control', 'is-invalid' => $errors->has($name)])
    {{-- {{ $attributes }} print any parameter that pass to the component but not defined in @props
      and if not define @props $attribute will print all parameter
      $attribute->class() --}}
> {{ old($name, $value) }} </textarea>

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
