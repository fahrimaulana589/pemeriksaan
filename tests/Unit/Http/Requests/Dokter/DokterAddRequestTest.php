<?php

namespace Http\Requests\Dokter;

use App\Http\Requests\Dokter\DokterAddRequest;
use App\Http\Requests\Pasien\PasienAddRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DokterAddRequestTest extends TestCase
{

    function test_validasi_harus_sukses()
    {
        $file = UploadedFile::fake()->create('avatar.jpg', 4000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah',

        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_gambar_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The file field is required');

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gambar_bukan_image_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The file field must be an image');

        $file = UploadedFile::fake()->create('avatar.pdf', 4000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gambar_lebih_dari_5mb_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The file field must not be greater than 5000 kilobytes');

        $file = UploadedFile::fake()->create('avatar.jpg', 6000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_nama_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The nama field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_nama_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The nama field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => '',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_nama_menggunakan_selain_huruf_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The nama field format is invalid');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'akhmad fahri maulana 9',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gender_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The gender field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gender_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The gender field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => '',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gender_selain_pria_atau_wanita_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected gender is invalid.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'bencong',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_harlah_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The harlah field is required');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_harlah_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The harlah field is required');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_harlah_bukan_tanggal_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The harlah field is required');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_harlah_dengan_tanggal_masa_depan_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The harlah field must be a date before or equal to now.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '4000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_desa_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The desa field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_desa_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The desa field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => '',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_desa_menggunakan_selain_huruf_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The desa field format is invalid.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu 2',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_kecamatan_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The kecamatan field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_kecamatan_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The kecamatan field is required');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => '',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_kecamatan_menggunakan_selain_huruf_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The kecamatan field format is invalid.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu timur',
            'kecamatan' => 'Tarub 2',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_kabupaten_atau_kota_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The kabupaten kota field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_kabupaten_atau_kota_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The kabupaten kota field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => '',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_kabupaten_atau_kota_menggunakan_selain_huruf_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The kabupaten kota field format is invalid.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal 2',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_pendidikan_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pendidikan field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_pendidikan_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pendidikan field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'tegal',
            'pendidikan' => "",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_pendidikan_menggunakan_selain_huruf_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pendidikan field format is invalid.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "D 2,. -",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_keahlian_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The keahlian field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_keahlian_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The keahlian field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'tegal',
            'pendidikan' => "SMA",
            'keahlian' => ''
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_keahlian_menggunakan_selain_huruf_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The keahlian field format is invalid.');

        $file = UploadedFile::fake()->create('avatar.jpg', 3000);

        $data = [
            'nama' => 'akhmad fahri maulana',
            'gender' => 'pria',
            'harlah' => '2000-06-01',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah 2'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new DokterAddRequest();

        $request->validate($validasi->rules());
    }

}
