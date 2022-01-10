<li class="nav-item active">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
        aria-controls="collapsePages">
        <i class="{{$icon}}"></i>
        <span>{{$title}}</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            @foreach($children as $child)
                <a class="collapse-item" href="{{ $child['route'] }}">{{$child['title']}}</a>
            @endforeach
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">