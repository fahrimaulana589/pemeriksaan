<?php

namespace App\Http\Requests\Pemeriksaan;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PemeriksaanAddRequest extends FormRequest
{
    public function rules(): array
    {
        if($this->request->get('hari') != null && $this->request->get('dokter_id') != null){
            $hari = $this->parseday(Carbon::make($this->request->get('hari'))->dayOfWeek);
            $dokter = Dokter::where('id','=',$this->request->get('dokter_id'))->first();

            $jaga = $dokter->jadwals->first()->$hari;
            $this->fail($jaga != 'on','Dokter Tidak Jaga');

            $pemeriksaans = Pemeriksaan::whereBetween('hari',[Carbon::make($this->request->get('hari'))->subDay(),Carbon::make($this->request->get('hari'))->addDay()])
                ->where('dokter_id','=',$this->request->get('dokter_id'))
                ->whereIn('status',['antrian','proses','selesai'])->get();

            $this->fail($pemeriksaans->count()+1 > $dokter->jumlah,'Dokter Sudah Penuh');
        }

        return [
            'pasien_id' => [
                'int',
                'exists:pasien,id',
                'required'
            ],
            'dokter_id' => [
                'int',
                'exists:dokter,id',
                'required'
            ],
            'keluhan' => [
                'required',
                'string'
            ],
            'hari' => [
                'required',
                'date',
                'after_or_equal:'.Carbon::now()->toDateString(),
            ],
            'status' => [
                'required',
                'alpha',
                Rule::in(['antrian', 'proses', 'selesai', 'batal'])
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function fail($condition,$message){
        $validator = Validator::make($this->request->all(), [
            'faxila' => [
                Rule::when($condition, ['required'])
            ]
        ], [
            'required' => $message
        ]);
        $validator->validate();
    }

    public function parseday($hari)
    {
        switch ($hari){
            case 1 :
                return 'senin';
            case 2 :
                return 'selasa';
            case 3 :
                return 'rabu';
            case 4 :
                return 'kamis';
            case 5 :
                return 'jumat';
            case 6 :
                return 'sabtu';
            case 7 :
                return 'minggu';
        }
    }
}
