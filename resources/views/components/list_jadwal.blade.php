<div class="d-inline-flex p-2 bd-highlight gap-2">
    <div>
        <div class="btn btn-bg @if($jadwal->senin == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->senin == 'on') {{$jadwal->start_senin}} / {{$jadwal->end_senin}} @endif
        </div>
    </div>
    <div>
        <div class="btn btn-bg @if($jadwal->selasa == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->addDay(1)->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->selasa == 'on') {{$jadwal->start_selasa}} / {{$jadwal->end_selasa}} @endif
        </div>
    </div>

    <div>
        <div class="btn btn-bg @if($jadwal->rabu == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->addDay(2)->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->rabu == 'on') {{$jadwal->start_rabu}} / {{$jadwal->end_rabu}} @endif
        </div>
    </div>

    <div>
        <div class="btn btn-bg @if($jadwal->kamis == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->addDay(3)->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->kamis == 'on') {{$jadwal->start_kamis}} / {{$jadwal->end_kamis}} @endif
        </div>
    </div>

    <div>
        <div class="btn btn-bg @if($jadwal->jumat == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->addDay(4)->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->jumat == 'on') {{$jadwal->start_jumat}} / {{$jadwal->end_jumat}} @endif
        </div>
    </div>

    <div>
        <div class="btn btn-bg @if($jadwal->sabtu == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->addDay(5)->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->sabtu == 'on') {{$jadwal->start_sabtu}} / {{$jadwal->end_sabtu}} @endif
        </div>
    </div>

    <div>
        <div class="btn btn-bg @if($jadwal->minggu == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
            {{Carbon\Carbon::now()->startOfWeek()->addDay(6)->translatedFormat("D d M Y")}}
        </div>
        <div>
            @if($jadwal->minggu == 'on') {{$jadwal->start_minggu}} / {{$jadwal->end_minggu}} @endif
        </div>
    </div>
</div>
