@php
$id = "input-{$name}";
$label = isset($label)? $label : ucwords(snake_case(camel_case($name), ' '));
$required = isset($required)? (bool) $required : false;
@endphp

@component('{? view_namespace ?}partials.fields.wrapper', [
  'name' => $name, 
  'label' => $label,
  'required' => $required
])

  <textarea class="form-control textarea-ckeditor" name="{{ $name }}" id="{{ $id }}" {{ $required? 'required' : '' }}>{{ $value }}</textarea>

@endcomponent

@js('vendor/admin-lte/plugins/ckeditor/ckeditor.js')
@script('ckeditor-init')
<script>
  $(function() {
    $('.textarea-ckeditor').each(function() {
      CKEDITOR.replace(this);
    });
  });
</script>
@endscript
