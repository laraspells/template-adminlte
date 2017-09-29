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

  @if(isset($groupLeft) OR isset($groupRight))
    <div class="input-group">
    {!! $groupLeft or '' !!}
  @endif

  <input
    type="text"
    class="form-control date"
    value="{{ $value or '' }}"
    name="{{ $name }}"
    id="{{ $id }}"
    data-format="{{ $format or 'yyyy-mm-dd' }}"
    {{ $required? 'required' : '' }}
  />

  @if(isset($groupLeft) OR isset($groupRight))
    {!! $groupRight or '' !!}
    </div>
  @endif

@endcomponent

@css('vendor/admin-lte/plugins/datepicker/datepicker3.css')
@js('vendor/admin-lte/plugins/datepicker/bootstrap-datepicker.js')
@script('init-datepicker')
<script>
$('input.date').each(function() {
  var format = $(this).attr('data-format');
  $(this).datepicker({format: format});
});
</script>
@endscript
