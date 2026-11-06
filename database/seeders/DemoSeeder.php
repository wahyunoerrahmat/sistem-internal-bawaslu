<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\BarangKendaraan;
use App\Models\PeminjamanBarang;
use App\Models\Tamu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Data contoh untuk keperluan demo (sidang PPM).
 *
 * Jalankan dengan:
 *   php artisan migrate:fresh --seed --seeder=DemoSeeder
 *
 * Semua akun memakai password: bawaslu123
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('bawaslu123');

        $akun = [
            ['Ketua Bawaslu Kab. Bogor', 'pimpinan@bawaslu.test',      'pimpinan'],
            ['Admin Absensi',            'admin.absensi@bawaslu.test', 'admin_absensi'],
            ['Admin Barang',             'admin.barang@bawaslu.test',  'admin_barang'],
            ['Resepsionis',              'resepsionis@bawaslu.test',   'resepsionis'],
            ['Budi Santoso',             'pegawai@bawaslu.test',       'pegawai'],
            ['Siti Rahmawati',           'pegawai2@bawaslu.test',      'pegawai'],
            ['Wahyu Noer Rahmat',        'magang@bawaslu.test',        'magang'],
            ['Muhammad Ihya Ulumudin',   'magang2@bawaslu.test',       'magang'],
            ['Fahzriel',                 'magang3@bawaslu.test',       'magang'],
        ];

        $users = [];
        foreach ($akun as [$name, $email, $role]) {
            $users[$email] = User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => $password, 'role' => $role, 'email_verified_at' => now()]
            );
        }

        /* ---------------- ABSENSI (4 minggu terakhir, tanpa hari ini) ---------------- */
        $pesertaAbsen = ['magang@bawaslu.test', 'magang2@bawaslu.test', 'magang3@bawaslu.test',
                         'pegawai@bawaslu.test', 'pegawai2@bawaslu.test'];

        mt_srand(2026);
        $hari = Carbon::today()->subDays(28);
        while ($hari->lt(Carbon::today())) {
            if ($hari->isWeekday()) {
                foreach ($pesertaAbsen as $email) {
                    $acak = mt_rand(1, 100);
                    if ($acak <= 7) {
                        continue; // tidak hadir
                    }
                    $terlambat = $acak > 80;
                    $masuk = $terlambat
                        ? sprintf('08:%02d:%02d', mt_rand(5, 45), mt_rand(0, 59))
                        : sprintf('07:%02d:%02d', mt_rand(30, 59), mt_rand(0, 59));
                    $pulang = $hari->isFriday()
                        ? sprintf('16:%02d:%02d', mt_rand(30, 50), mt_rand(0, 59))
                        : sprintf('16:%02d:%02d', mt_rand(0, 30), mt_rand(0, 59));

                    Absensi::updateOrCreate(
                        ['user_id' => $users[$email]->id, 'tanggal' => $hari->toDateString()],
                        [
                            'jam_masuk'  => $masuk,
                            'jam_pulang' => $pulang,
                            'status'     => $terlambat ? 'terlambat' : 'pulang',
                        ]
                    );
                }
            }
            $hari->addDay();
        }

        /* ---------------- BARANG & KENDARAAN ---------------- */
        $barang = [
            ['Laptop',              'Lenovo',    'ThinkPad E14'],
            ['Laptop',              'ASUS',      'VivoBook 14'],
            ['Laptop',              'HP',        'ProBook 440 G8'],
            ['Proyektor',           'Epson',     'EB-X500'],
            ['Proyektor',           'BenQ',      'MX560'],
            ['Kamera',              'Canon',     'EOS 1500D'],
            ['Printer',             'Epson',     'L3210'],
            ['Printer',             'Canon',     'PIXMA G2010'],
            ['Speaker Portable',    'JBL',       'PartyBox 110'],
            ['Mobil Dinas',         'Toyota',    'Innova Reborn'],
            ['Mobil Dinas',         'Mitsubishi','Xpander'],
            ['Sepeda Motor Dinas',  'Honda',     'Vario 125'],
            ['Sepeda Motor Dinas',  'Yamaha',    'NMAX'],
            ['Tablet',              'Samsung',   'Galaxy Tab A8'],
            ['Wireless Microphone', 'Shure',     'BLX24'],
        ];

        $daftarBarang = [];
        foreach ($barang as $i => [$jenis, $merk, $tipe]) {
            $daftarBarang[] = BarangKendaraan::updateOrCreate(
                ['nup' => sprintf('NUP-%04d', $i + 1)],
                [
                    'no_urut'      => $i + 1,
                    'jenis_barang' => $jenis,
                    'merk'         => $merk,
                    'tipe'         => $tipe,
                    'kondisi'      => $i === 7 ? 'Rusak Ringan' : 'Baik',
                    'status'       => 'tersedia',
                ]
            );
        }

        /* ---------------- PEMINJAMAN ---------------- */
        $peminjam = [$users['pegawai@bawaslu.test'], $users['pegawai2@bawaslu.test']];

        // Riwayat yang sudah dikembalikan
        foreach ([[0, 20], [3, 17], [9, 14], [5, 10], [1, 8], [11, 6], [13, 4]] as $n => [$idx, $hariLalu]) {
            $pinjam = Carbon::now()->subDays($hariLalu)->setTime(9, 0);
            PeminjamanBarang::create([
                'barang_id'               => $daftarBarang[$idx]->id,
                'user_id'                 => $peminjam[$n % 2]->id,
                'tanggal_pinjam'          => $pinjam,
                'tanggal_kembali_rencana' => $pinjam->copy()->addDays(2),
                'tanggal_kembali_real'    => $pinjam->copy()->addDays(2)->setTime(15, 0),
                'status'                  => 'dikembalikan',
                'jumlah'                  => 1,
                'created_at'              => $pinjam,
                'updated_at'              => $pinjam->copy()->addDays(2),
            ]);
        }

        // Yang masih dipinjam
        foreach ([[2, 1], [9, 0], [4, 2]] as $n => [$idx, $hariLalu]) {
            $pinjam = Carbon::now()->subDays($hariLalu)->setTime(8, 30);
            PeminjamanBarang::create([
                'barang_id'               => $daftarBarang[$idx]->id,
                'user_id'                 => $peminjam[$n % 2]->id,
                'tanggal_pinjam'          => $pinjam,
                'tanggal_kembali_rencana' => $pinjam->copy()->addDays(3),
                'status'                  => 'dipinjam',
                'jumlah'                  => 1,
                'created_at'              => $pinjam,
                'updated_at'              => $pinjam,
            ]);
            $daftarBarang[$idx]->update(['status' => 'dipinjam']);
        }

        /* ---------------- BUKU TAMU ---------------- */
        $tamu = [
            ['Andi Pratama',      'Cibinong, Kab. Bogor',   '081234567801', 'Konsultasi pendaftaran pengawas pemilu',  'Divisi SDM',                 'Rina'],
            ['Dewi Lestari',      'Cileungsi, Kab. Bogor',  '081234567802', 'Penyerahan laporan dugaan pelanggaran',   'Divisi Penanganan Pelanggaran', 'Agus'],
            ['Rudi Hartono',      'Sentul, Kab. Bogor',     '081234567803', 'Koordinasi kegiatan sosialisasi',         'Divisi Pencegahan',          'Fajar'],
            ['Lina Marlina',      'Bojonggede, Kab. Bogor', '081234567804', 'Permohonan informasi publik (PPID)',      'PPID',                       'Yuni'],
            ['Hendra Wijaya',     'Kota Bogor',             '081234567805', 'Audiensi organisasi kemahasiswaan',       'Ketua',                      'Sekretariat'],
            ['Sri Wahyuni',       'Ciawi, Kab. Bogor',      '081234567806', 'Pengantaran surat undangan',              'Sekretariat',                'Dedi'],
            ['Taufik Hidayat',    'Gunung Putri, Kab. Bogor','081234567807', 'Rapat koordinasi dengan KPU',            'Divisi Hukum',               'Rina'],
            ['Maya Sari',         'Parung, Kab. Bogor',     '081234567808', 'Wawancara penelitian skripsi',            'Divisi Humas',               'Fajar'],
            ['Agus Salim',        'Jonggol, Kab. Bogor',    '081234567809', 'Pengambilan dokumen',                     'Sekretariat',                'Dedi'],
            ['Nur Aisyah',        'Cibinong, Kab. Bogor',   '081234567810', 'Konsultasi hasil pengawasan',             'Divisi Pencegahan',          'Yuni'],
            ['Bambang Sutrisno',  'Leuwiliang, Kab. Bogor', '081234567811', 'Koordinasi Panwascam',                    'Divisi SDM',                 'Agus'],
            ['Fitri Handayani',   'Kota Depok',             '081234567812', 'Kunjungan studi banding',                 'Ketua',                      'Sekretariat'],
        ];

        foreach ($tamu as $i => [$nama, $alamat, $kontak, $keperluan, $tujuan, $penerima]) {
            $datang = Carbon::now()->subDays(18 - intdiv($i * 3, 2))->setTime(mt_rand(8, 14), mt_rand(0, 59));
            Tamu::create([
                'nama_lengkap'  => $nama,
                'alamat'        => $alamat,
                'kontak'        => $kontak,
                'keperluan'     => $keperluan,
                'pihak_dituju'  => $tujuan,
                'nama_penerima' => $penerima,
                'waktu_datang'  => $datang,
                'created_at'    => $datang,
                'updated_at'    => $datang,
            ]);
        }
    }
}
