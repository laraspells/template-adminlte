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
    <label class="input-checkbox">
      <input id="cb-{{ $id }}-{{ $option['value'] }}" name="{{ $name }}" type='checkbox' value="{{ $option['value'] }}" {{ $value == $option['value']? 'checked' : '' }}>
      <span>{{ $option['label'] }}</span>
    </label>
    <br>
  @endforeach
  
@endcomponent

@css('vendor/admin-lte/plugins/iCheck/all.css')
@js('vendor/admin-lte/plugins/iCheck/icheck.min.js')
@script('init-icheck-checkbox')
<script>
  $(function() {
    $('.form-icheck-checkbox input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_minimal-blue'
    });
  });
</script>
@endscript
