-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jan 2024 pada 04.37
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jewepe`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `name`) VALUES
(1, 'admin', 'admin', 'aqsha');

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `artikel` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `tgl_buat` datetime NOT NULL,
  `tgl_publish` datetime NOT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `deskripsi`, `artikel`, `gambar`, `status`, `tgl_buat`, `tgl_publish`, `id_admin`) VALUES
(23, 'Anies Kritik Omnibus Law Cuma Buat Pengusaha Besar: Nelayan Masih Susah Urus Perizinan', 'Calon presiden nomor urut 1 Anies Baswedan mengkritik omnibus law Undang-Undang Cipta Kerja hanya memberikan kemudahan bagi pengusaha-pengusaha besar. Hal tersebut disampaikan Anies di depan para tokoh Tuban dan Bojonegoro di Pondok Pesantren Bahrul Huda, Tuban, Jawa Timur, Jumat, 29 Desember 2023.', 'Mantan Gubernur DKI Jakarta itu bercerita, para nelayan yang dia temui menceritakan sulitnya mengurus perizinan. \"Saya ini membatin, lha wong dibikinin omnibus law, dibikin kemudahan perizinan, itu buat siapa coba?\" ucapnya, seperti dipantau dari kanal YouTube Anies Baswedan.\r\n\r\nCalon presiden nomor urut 1 Anies Baswedan mengkritik omnibus law Undang-Undang Cipta Kerja hanya memberikan kemudahan bagi pengusaha-pengusaha besar. Hal tersebut disampaikan Anies di depan para tokoh Tuban dan Bojonegoro di Pondok Pesantren Bahrul Huda, Tuban, Jawa Timur, Jumat, 29 Desember 2023.\r\n\r\nMantan Gubernur DKI Jakarta itu bercerita, para nelayan yang dia temui menceritakan sulitnya mengurus perizinan. \"Saya ini membatin, lha wong dibikinin omnibus law, dibikin kemudahan perizinan, itu buat siapa coba?\" ucapnya, seperti dipantau dari kanal YouTube Anies Baswedan.\r\n\r\nMenurut dia, kemudahan perizinan dalam omnibus law dibuat hanya untuk para pengusaha kelas kakap. Sementara itu, tata niaga mereka yang kecil tidak tersentuh oleh kemudahan itu. \"Ini mau diteruskan atau tidak?\" tanyanya kepada para hadirin, yang dijawab \"tidak\".', 'uploads/1.jpg', 0, '2023-12-30 14:13:35', '2024-01-03 00:00:00', 1),
(24, 'Anies Janjikan Program Bansos Plus, Bantuan Disertai Pembekalan Rintis Usaha Mandiri', 'Capres nomor urut 1 Anies Baswedan berorasi saat kampanye di Pasar Flamboyan, Pontianak, Kalimantan Barat, 26 Desember 2023. Setiba di sana, Anies berinteraksi dan mendengar keluhan para pedagang dan pembeli khususnya dari para penjual ayam, cabe dan beras yang menginginkan perubahan. Foto: Timnas AMIN', 'Calon presiden nomor urut 1, Anies Baswedan mengatakan, dia akan mengubah program bantuan sosial atau bansos menjadi bansos plus. Hal tersebut disampaikan Anies di depan para tokoh Tuban dan Bojonegoro di Pondok Pesantren Bahrul Huda, Tuban, Jawa Timur, Jumat, 29 Desember 2023.\r\n\r\nMantan Gubernur DKI Jakarta itu mengatakan, beredar kabar bansos akan berubah jika dia menjadi presiden. Dia tak menampik kabar itu.', 'uploads/2.jpg', 1, '2023-12-30 15:00:03', '2023-12-31 00:00:00', 1),
(30, 'Anies Baswedan Gencar Kampanye di Tiktok, Ganjar Pranowo Pilih Tak Bocorkan Strategi', 'Calon presiden nomor urut 01, Anies Baswedan makin gencar kampanye di media sosial. Setelah program Desak Anies sukses menggaet perhatian kalangan milenial, kali ini strategi', 'Calon presiden nomor urut 01, Anies Baswedan makin gencar kampanye di media sosial. Setelah program Desak Anies sukses menggaet perhatian kalangan milenial, kali ini strategi beralih ke Tiktok.\r\n\r\nAnies memulai siaran langsung lewat aplikasi TikTok pada Kamis malam (28/12) dengan judul \"Temani Saya di Jalan\" dan mendapatkan sekitar 300 ribu penonton. Berikutnya, dia berhasil menggaet sekitar 420.000 penonton dalam siaran langsung kedua pada Sabtu (30/12).\r\n\r\nMelihat Anies Baswedan yang makin gencar berkampanye, Ganjar Pranowo memberikan komentar.\r\n\r\n\"Ya biar saja ya pakai strategi sendiri-sendiri. Kami juga ada strateginya,\" kata Ganjar usai mengunjungi Pondok Pesantren Al Iman Bulus, Kabupaten Purworejo, Jawa Tengah, dikutip dari Antara, Senin 1 Januari 2024.\r\n\r\nNamun, Ganjar enggan membocorkan strateginya maupun calon wakil presiden Mahfud Md mulai tahun baru 2024.\r\n\r\n\"Ya masa dibocorkan, bagaimana? Ada yang kita kerjakan tetapi semua sudah mulai bergerak antara partai, relawan, teknologi, maka kemarin ketika ada satu survei, kami juga punya triangulasi survei, pakai AI (artificial intelligence atau kecerdasan buatan), dan insyaallah lebih detail,\" ujar dia.Baca juga: Nelayan di Lamongan, Jawa Timur dukung AMIN dalam Pilpres 2024', 'uploads/Screenshot 2024-01-01 143047.jpg', 1, '2024-01-01 14:31:08', '2024-01-01 00:00:00', 1),
(31, 'Ikuti Jejak Anies Baswedan, Mahfud MD Live TikTok Bicara Resolusi 2024', 'Tak cuma nasihat bijak, Mahfud MD turut mengungkap tiga refleksi akhir tahun tentang Indonesia.', 'Setelah belakangan Anies Baswedan ramai diperbincangkan karena live TikTok, Mahfud MD rupanya turut terjun ke platform tersebut.\r\n\r\nCalon wakil presiden (cawapres) nomor urut 3 itu menyapa netizen melalui live TikTok di malam pergantian tahun, Sabtu (31/12/2023).\r\n\r\nSerupa dengan Anies Baswedan, Mahfud MD juga tak membahas perihal politik. Ia berbicara mengenai resolusi 2024 dan memberi petuah-petuah bijak layaknya seorang ayah.\r\n\r\nSalah satu yang ia sampaikan adalah sebuah hadits yang mengingatkan bahwa siapa yang hari ini lebih baik dari kemarin, maka dia orang beruntung. \r\n\r\n\"Dan barang siapa yang hari ini sama saja dengan hari kemarin, maka orang itu orang merugi,\" kata Mahfud, dikutip, Senin (1/1/2024).\r\n\r\n\"Harus dan harus, tahun 2024 harus menjadi lebih baik dari tahun 2023,\" imbuhnya.', 'uploads/Screenshot 2024-01-01 143134.jpg', 1, '2024-01-01 14:32:12', '2024-01-01 00:00:00', 1),
(32, 'Ganjar Pranowo Balas Gaya Kampanye Baru Anies Main TikTok: Kami Pakai AI', 'Capres RI Ganjar Pranowo (kedua kiri) saat memberikan keterangan usai mengunjungi Pondok Pesantren An-Nawawi Berjan Gebang Purworejo, Kabupaten Purworejo, Jawa Tengah, Minggu (31/12/2023). ANTARA/Rio Feisal', 'Calon presiden nomor urut 3, Ganjar Pranowo menanggapi gaya kampanye calon presiden nomor urut 1, Anies Baswedan yang merambah aplikasi media sosial TikTok.\r\n\r\n\"Ya biar saja ya pakai strategi sendiri-sendiri. Kami juga ada strateginya,\" kata Ganjar usai mengunjungi Pondok Pesantren Al Iman Bulus, Kabupaten Purworejo, Jawa Tengah, Minggu (31/12/2023).\r\n\r\nWalaupun demikian, dia masih belum mau mengungkapkan strategi kampanye terbaru yang akan dilakukan dirinya maupun calon wakil presiden Mahfud Md mulai tahun baru 2024.\r\n\r\n\"Ya masa dibocorkan, bagaimana? Ada yang kita kerjakan tetapi semua sudah mulai bergerak antara partai, relawan, teknologi. Maka kemarin ketika ada satu survei, kami juga punya triangulasi survei, pakai AI (artificial intelligence atau kecerdasan buatan), dan insyaallah lebih detail,\" ujar dia.\r\n\r\nSebelumnya, Anies memulai siaran langsung lewat aplikasi TikTok pada Kamis malam (28/12) dengan judul \"Temani Saya di Jalan\" dan mendapatkan sekitar 300 ribu penonton. Berikutnya, dia berhasil menggaet sekitar 420.000 penonton dalam siaran langsung kedua pada Sabtu (30/12).\r\n\r\nKomisi Pemilihan Umum pada Senin, 13 November 2023, menetapkan tiga bakal pasangan calon presiden dan wakil presiden menjadi peserta Pemilu presiden dan wakil presiden 2024.\r\n\r\nBerdasarkan hasil pengundian dan penetapan nomor urut peserta Pilpres 2024 pada Selasa, 14 November 2023, pasangan Anies Baswedan-Muhaimin Iskandar mendapat nomor urut 1, Prabowo Subianto-Gibran Rakabuming Raka nomor urut 2, dan Ganjar Pranowo-Mahfud Md. nomor urut 3.\r\n\r\nKPU juga telah menetapkan masa kampanye mulai 28 November 2023 hingga 10 Februari 2024, kemudian jadwal pemungutan suara pada 14 Februari 2024. (Antara)', 'uploads/Screenshot 2024-01-01 143251.jpg', 1, '2024-01-01 14:33:39', '2024-01-01 00:00:00', 1),
(33, 'Ganjar soal Jokowi Kumpulkan Kepala Desa: Mudah-mudahan Tak Menyalahgunakan Kekuasaan', 'Ganjar soal Jokowi Kumpulkan Kepala Desa: Mudah-mudahan Tak Menyalahgunakan Kekuasaan. (Biro Pers Sekretariat Presiden)', 'Calon Presiden nomor urut tiga, Ganjar Pranowo mengaku tidak mempermasalahkan soal pertemuan Presiden RI Joko Widodo dengan Perkumpulan Aparatur Pemerintahan Desa Seluruh Indonesia (Papdesi) pada Jumat (29/12) lalu. Meski demikian, Ganjar mengaku tidak fair jika dalam pertemuan itu ada pesanan-pesanan atau permintaan dukungan politik.\r\n\r\nPernyataan itu disampaikan Ganjar seusai mengunjungi Pondok Pesantren An-Nawawi Berjan Gebang Purworejo, Kabupaten Purworejo, Jawa Tengah, Minggu (31/12/2023).\r\n\r\n\"Yang penting pengarahan pemerintahan kami tidak masalah. Akan tetapi, kalau pengarahan politik, dukung-mendukung, saya kira mulai tidak fair (adil),\" kata Ganjar dikutip dari Antara, Minggu.\r\n\r\nWalau tidak tahu persis dengan isi pertemuan antara Jokowi dan kepala desa, Ganjar berharap Jokowi hanya berbicara soal masalah pemerintahan, bukan yang lain.\r\n\r\n\"Saya belum tahu kemarin konten pembicaraannya apa begitu. Mudah-mudahan dalam konteks pemerintahan dan tidak ada yang menyalahgunakan kekuasaan pemerintahan,\" ujar Ganjar.', 'uploads/Screenshot 2024-01-01 143447.jpg', 1, '2024-01-01 14:35:37', '2024-01-01 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
