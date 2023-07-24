<div>
    <div class="bg-white rounded shadow-sm mb-3 px-3 py-3">
        Jadwal Dokter Minggu Ini
        <p class="small text-muted mb-0 content-read">
            Jadwal dokter dalam rentang satu minggu ini
        </p>
        <div class="row">
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'senin','count'=>0])
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'selasa','count'=>1])
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'rabu','count'=>2])
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'kamis','count'=>3])
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'jumat','count'=>4])
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'sabtu','count'=>5])
            @include('components.list_jadwal_dokter_hari',['dokter' => $dokter,'hari' => 'minggu','count'=>6])
        </div>
    </div>
</div>
