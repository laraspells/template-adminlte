@php
$id = "input-{$name}";
$label = isset($label)? $label : ucwords(snake_case(camel_case($name), ' '));
$required = isset($required)? (bool) $required : false;
$empty_option = isset($empty_option)? $empty_option : 'Pick '.$label;
$value = isset($value)? $value : '';
@endphp

@component('{? view_namespace ?}partials.fields.wrapper', [
  'name' => $name, 
  'label' => $label,
  'required' => $required
])

  @foreach($options as $option)
    <div class="input-checkbox">
      <input id="cb-{{ $id }}-{{ $option['value'] }}" name="{{ $name }}" type='checkbox' value="{{ $option['value'] }}" {{ $value == $option['value']? 'checked' : '' }}>
      <span>{{ $option['label'] }}</span>
    </div>
  @endforeach
  
@endcomponent