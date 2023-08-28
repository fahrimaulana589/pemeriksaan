@isset($title)
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ __($title) }}</span>
    </li>
@endisset

@if (!empty($name) && empty($list))
    <li class="menu-item {{ active($active) }}">
        <a href="{{$attributes['href']}}" class="menu-link">
            @isset($icon)
                <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
            @endisset
            <div data-i18n="Analytics">{{ $name ?? '' }}</div>
            @isset($badge)
                <b class="badge rounded-pill bg-{{$badge['class']}} col-auto ms-auto">{{$badge['data']()}}</b>
            @endisset
        </a>
    </li>
@endif

@if(!empty($list))
    <!-- Layouts -->
    <li x-data="{ open: {{active($active, 'open') == 'open' ? 'true' : 'false'}} }" :class="{ 'open': open }" class="menu-item {{active($active, 'active')}}">
        <a @click="open = !open" class="menu-link menu-toggle ">
            @isset($icon)
                <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
            @endisset
            <div data-i18n="Layouts">{{ $name ?? '' }}</div>
        </a>

        <ul class="menu-sub">
            @foreach($list as $item)
                {!!  $item->build($source) !!}
            @endforeach
        </ul>
    </li>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif

