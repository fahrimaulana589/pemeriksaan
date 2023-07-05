<div>
    <div class="bg-white rounded shadow-sm mb-3 px-3 py-3">
        Daftar Dokter
        <p class="small text-muted mb-0 content-read">
            Daftar Dokter Bertugas
        </p>
        <div class="pt-3">
            @foreach($dokters['jadwal_hari_ini'] as $dokter)
                <div class="pb-3">
                    <div class="d-flex justify-content-start">
                        <img src='{{url($dokter['dokter']['icon'])}}' style='width:70px;height:70px;border-radius: 50%;object-fit: cover'>
                        <div class="ps-3 d-flex flex-fill justify-content-between">
                            <div>
                                {{$dokter['dokter']['nama']}}
                                <p class="small text-muted mb-0 content-read">
                                    {{$dokter['dokter']['pendidikan']}}
                                </p>

                                <p class="text-muted mb-0 content-read pt-2" style="font-size: 11px">
                                    {{$dokter['dokter']['keahlian']}}
                                </p>
                            </div>
                            <div class="ps-3">
                                <div class="text-center rounded-circle bg-info" style="height: 20px;width: 20px;font-size: 12px">
                                    {{$dokter['dokter']['id']}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                {{$dokter->nama}}--}}
            @endforeach
        </div>
    </div>
</div>
