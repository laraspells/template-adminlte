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
    type="email"
    class="form-control"
    value="{{ $value or '' }}"
    name="{{ $name }}"
    id="{{ $id }}"
    {{ $required? 'required' : '' }}
  />

  @if(isset($groupLeft) OR isset($groupRight))
    {!! $groupRight or '' !!}
    </div>
  @endif

@endcomponent
