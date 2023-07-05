<div class="d-inline-flex p-2 bd-highlight gap-2">
    <div class="btn btn-bg @if($jadwal->senin == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->translatedFormat("D d M Y")}}
    </div>
    <div class="btn btn-bg @if($jadwal->selasa == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->addDay(1)->translatedFormat("D d M Y")}}
    </div>
    <div class="btn btn-bg @if($jadwal->rabu == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->addDay(2)->translatedFormat("D d M Y")}}
    </div>
    <div class="btn btn-bg @if($jadwal->kamis == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->addDay(3)->translatedFormat("D d M Y")}}
    </div>
    <div class="btn btn-bg @if($jadwal->jumat == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->addDay(4)->translatedFormat("D d M Y")}}
    </div>
    <div class="btn btn-bg @if($jadwal->sabtu == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->addDay(5)->translatedFormat("D d M Y")}}
    </div>
    <div class="btn btn-bg @if($jadwal->minggu == 'on') bg-success text-bg-success @else bg-danger text-bg-danger @endif">
        {{Carbon\Carbon::now()->startOfWeek()->addDay(6)->translatedFormat("D d M Y")}}
    </div>
</div>
