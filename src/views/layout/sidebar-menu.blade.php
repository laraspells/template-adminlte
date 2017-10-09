<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  @foreach(config('{? config_key ?}.menu') as $menu)
    @if(isset($menu['child']) AND is_array($menu['child']))
    <li class="treeview">
      <a href="#">
        <i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['label'] }}</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @foreach($menu['child'] as $childmenu)
        <li class="{{ Request::route()->getName() == $childmenu['route']? 'active' : '' }}">
          <a href="{{ route($childmenu['route']) }}">
            <i class="fa {{ $childmenu['icon'] }}"></i>
            <span>{{ $childmenu['label'] }}</span>
          </a>
        </li>
        @endforeach
      </ul>
    </li>
    @else
    <li class="{{ Request::route()->getName() == $menu['route']? 'active' : '' }}">
      <a href="{{ route($menu['route']) }}">
        <i class="fa {{ $menu['icon'] }}"></i>
        <span>{{ $menu['label'] }}</span>
      </a>
    </li>
    @endif
  @endforeach
</ul>

