<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  @foreach(config('{? config_key ?}.menu') as $menu)
  <li class="{{ Request::route()->getName() == $menu['route']? 'active' : '' }}">
    <a href="{{ route($menu['route']) }}">
      <i class="fa {{ $menu['icon'] }}"></i>
      <span>{{ $menu['label'] }}</span>
    </a>
  </li>
  @endforeach
</ul>