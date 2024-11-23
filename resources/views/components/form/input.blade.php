@props([
    'type'=>'text',
    'id'=>'',
    'name',
    'value'=>'',
    'label'=>false,
])

@if($label)
<label for="{{ $id }}">{{$label}}</label>
@endif

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    @class(['form-control', 'is-invalid' => $errors->has($name)])
    value="{{ old($name, $value) }}" 
    {{-- {{ $attributes }} print any parameter that pass to the component but not defined in @props
      and if not define @props $attribute will print all parameter
      $attribute->class() --}}
>

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
