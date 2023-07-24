<div>
    <div class="bg-white rounded shadow-sm mb-3 px-3 py-3">
        {{$title}}
        <p class="small text-muted mb-0 content-read">
            {{$description}}
        </p>
        <div class="pt-3">
            @foreach($obats as $obat)
                <div class="pb-3">
                    <div class="d-flex justify-content-start">
                        <img src='{{url($obat['images'])}}' style='width:70px;height:70px;border-radius: 50%;object-fit: cover'>
                        <div class="ps-3 d-flex flex-fill justify-content-between">
                            <div>
                                {{$obat['nama']}}
                                <p class="small text-muted mb-0 content-read">
                                    {{$obat['deskripsi']}}
                                </p>
                            </div>
                            <div class="ps-3">
                                <div class="text-center rounded-circle bg-info" style="height: 20px;width: 20px;font-size: 12px">
                                    {{$obat['stok']}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
