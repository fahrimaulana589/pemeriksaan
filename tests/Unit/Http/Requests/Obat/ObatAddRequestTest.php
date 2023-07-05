<?php

namespace Http\Requests\Obat;

use App\Http\Requests\Obat\ObatAddRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ObatAddRequestTest extends TestCase
{
    function test_validasi_harus_sukses()
    {
        $file = UploadedFile::fake()->create('avatar.jpg', 4000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_gambar_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The file field is required');

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gambar_bukan_image_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The file field must be an image');

        $file = UploadedFile::fake()->create('avatar.pdf', 4000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_gambar_lebih_dari_5mb_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The file field must not be greater than 5000 kilobytes');

        $file = UploadedFile::fake()->create('avatar.jpg', 6000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_nama_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The nama field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_nama_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The nama field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => '',
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_nama_menggunakan_selain_huruf_angka_koma_titik_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The nama field format is invalid');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12))',
            'deskripsi' => 'asas',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_deskripsi_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The deskripsi field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_deskripsi_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The deskripsi field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => '',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_deskripsi_menggunakan_selain_huruf_angka_koma_titik_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The deskripsi field format is invalid');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas 12 ., (',
            'stok' => 12,
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_stok_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The stok field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas 12 .,',
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_stok_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The stok field is required.');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas 12 .,',
            'stok' => '',
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_stok_menggunakan_selain_angka_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The stok field must be an integer');

        $file = UploadedFile::fake()->create('avatar.jpg', 000);

        $data = [
            'nama' => 'gasp 12',
            'deskripsi' => 'asas 12 .,',
            'stok' => '121p2',
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        $validasi = new ObatAddRequest();

        $request->validate($validasi->rules());
    }

}
