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

  @if(isset($groupLeft) OR isset($groupRight))
    <div class="input-group">
    {!! $groupLeft or '' !!}
  @endif

  <select
    class="form-control select2"
    name="{{ $name }}"
    id="{{ $id }}"
    {{ $required? 'required' : '' }}>
    @if($empty_option)
    <option value="">{{ $empty_option }}</option>
    @endif
    @foreach($options as $option)
      @if(isset($option['options']))
        <optgroup label="{{ $option['label'] }}" {!! isset($option['attributes'])? html_attributes($option['attributes']) : "" !!}>
          @foreach($option['options'] as $opt)
          <option value="{{ $opt['value'] }}" {{ $value == $opt['value']? 'selected' : '' }} {!! isset($opt['attributes'])? html_attributes($opt['attributes']) : "" !!}>{{ $opt['label'] }}</option>
          @endforeach
        </optgroup>
      @else
        <option value="{{ $option['value'] }}" {{ $value == $option['value']? 'selected' : '' }} {!! isset($option['attributes'])? html_attributes($option['attributes']) : "" !!}>{{ $option['label'] }}</option>
      @endif
    @endforeach
  </select>

  @if(isset($groupLeft) OR isset($groupRight))
    {!! $groupRight or '' !!}
    </div>
  @endif

@endcomponent

@css('vendor/admin-lte/plugins/select2/select2.min.css')
@js('vendor/admin-lte/plugins/select2/select2.min.js')
@script('init-select2')
<script>
  $('select.select2').select2({})
</script>
@endscript
