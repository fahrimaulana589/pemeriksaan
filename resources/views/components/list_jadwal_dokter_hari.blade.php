<div>
    <div class="" style="font-size: 12px">
        <div>
            {{Carbon\Carbon::now()->startOfWeek()->addDay($count)->translatedFormat("D d M Y")}}
        </div>
        <div class="pt-2">
            @foreach($dokter['jadwal'][$hari] as $jadwal)
                <div class="d-flex justify-content-start">
                    <div class="mt-1 text-center rounded-circle @if(Carbon\Carbon::now()->startOfWeek()->addDay($count)->toDateString() == Carbon\Carbon::now()->toDateString()) bg-info @else bg-success @endif" style="height: 20px;width: 20px;font-size: 12px">
                        {{$jadwal['dokter']['id']}}
                    </div>
                    <div class="ps-2 mt-1 flex-fill">
                        {{$jadwal['dokter']['nama']}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
