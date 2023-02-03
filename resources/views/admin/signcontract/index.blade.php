@extends('layout-admin.base',[
	'pages'=>'signature',
	'subpages'=>'signature',
])
@section('content')
@inject('carbon', 'Carbon\Carbon')
  <div class="row justify-content-center mb-3">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body p-5">
          <div class="text-center">
            <h1 class="font-weight-bold m-0">{{$employee->organization->name}}</h1>
            <div style="border: 1px solid black" class="my-3"></div>
            <h5 class="m-0"><u>PERJANJIAN KERJA WAKTU TERTENTU PERCOBAAN (PKWTP)</u></h5>
            <p>Nomor: 001/HRD-WDev/PKWTP/XII/2022</p>
          </div>
          <p>Yang bertanda tangan di bawah ini:</p>
          <div class="d-flex mb-3">
            <div class="col-auto me-2">I.</div>
            <div class="col-2">
              <p class="m-0">Nama</p>
              <p class="m-0">Jabatan</p>
              <p class="m-0">Instansi</p>
              <p class="m-0">Alamat</p>
            </div>
            <div class="col">
              <p class="m-0">: Hendra</p>
              <p class="m-0">: Direktur</p>
              <p class="m-0">: Domain Twosides</p>
              <p class="m-0">: Golf Lake Residence Venice B No. 27, Jl Lkr. Luar Barat No. B-55,Cengkareng Timur, Cengkareng, Jakarta Barat, 11730</p>
            </div>
          </div>
          <p>Dalam hal ini bertindak untuk dan atas nama <b>Domain Twosides,</b> yang selanjutnya disebut sebagai <b>PIHAK PERTAMA.</b></p>
          <div class="d-flex mb-3">
            <div class="col-auto me-2">I.</div>
            <div class="col-2">
              <p class="m-0">Nama Lengkap</p>
              <p class="m-0">No. KTP/ SIM</p>
              <p class="m-0">Tempat, Tgl. Lahir</p>
              <p class="m-0">Alamat</p>
              <p class="m-0">Telepon/HP</p>
              <p class="m-0">Email</p>
            </div>
            <div class="col">
              <p class="m-0">: {{$employee->full_name}} {{$employee->last_name}}</p>
              <p class="m-0">: {{$employee->identity_number}}</p>
              <p class="m-0">: {{$employee->place_of_birth}}, {{ $carbon::parse($employee->date_of_birth)->formatLocalized('%d %B %Y') }}</p>
              <p class="m-0">: {{$employee->residential_address}}</p>
              <p class="m-0">: {{$employee->phone}}</p>
              <p class="m-0">: {{$employee->email}}</p>
            </div>
          </div>
          <p>Dalam hal ini bertindak untuk dan atas nama pribadi, yang untuk selanjutnya disebut <b>PIHAK KEDUA.</b></p>
          <p>Pada hari ini, tanggal Empat Belas, bulan Sebelas, tahun Dua Ribu Dua Puluh Dua <b>({{ $carbon::parse($employee->join_date)->format('d F Y') }})</b> Kedua belah pihak secara sadar mengadakan perjanjian kontrak kerja, dengan isi sebagai berikut:</p>
    
          <!-- Pasal 1 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 1</p>
            <p class="text-center font-weight-bold">KETENTUAN UMUM</p>
            <ol>
              <li>Dengan ditandatanganinya Perjanjian Kerja ini berarti <b>PIHAK KEDUA</b> telah mengetahui dan patuh terhadap Peraturan Perusahaan atau peraturan-peraturan lain yang berlaku di <b>PIHAK PERTAMA.</b></li>
              <li>Demi kepentingan <b>PIHAK PERTAMA</b> dalam hal pengaturan kerja lembur maka <b>PIHAK KEDUA</b> menyatakan kesediaannya untuk memenuhi peraturan tersebut sesuai ketentuan yang berlaku.</li>
            </ol>
          </div>
    
          <!-- Pasal 2 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 2</p>
            <p class="text-center font-weight-bold">PENUNJUKAN SEBAGAI KARYAWAN</p>
            <ol>
              <li><b>PIHAK PERTAMA</b> memberi pekerjaan kepada <b>PIHAK KEDUA</b>, dan <b>PIHAK KEDUA</b> mengakui menerima pekerjaan dari <b>PIHAK PERTAMA</b>.</li>
              <li>
                Dalam perjanjian kontrak kerja ini, <b>PIHAK KEDUA</b> melaksanakan pekerjaan sebagai <b>Web Developer</b> di lokasi <b>PIHAK PERTAMA</b> yang berlokasi di Golf Lake Residence Venice B No. 27, Jl Lkr. Luar Barat No. B-55,
                Cengkareng Timur, Cengkareng,Jakarta Barat, 11730.
              </li>
              <li>
                Pekerjaan sebagaimana disebut pada ayat 2 (dua) pasal ini dilaksanakan oleh <b>PIHAK KEDUA</b> selama 3 (Tiga) bulan, terhitung mulai tanggal Empat Belas, bulan Sebelas, tahun Dua Ribu Dua Puluh Dua
                <b>({{ $employeeJoinDate}})</b> sampai dengan tanggal Tiga Belas, bulan Dua, tahun Dua Ribu Dua Puluh Tiga <b>({{$threeMonthsProbation}}).</b>
              </li>
              <li>
                Apabila masa kontrak telah selesai sesuai tanggal berakhirnya kontrak maka hubungan kerja berakhir tanpa ada kewajiban <b>PIHAK PERTAMA</b> memberikan uang pesangon, uang jasa ataupun uang ganti kerugian lainnya kepada PIHAK
                KEDUA. Apabila diperlukan, kontrak dapat diperpanjang sesuai dengan tingkat kebutuhan dan ditentukan kemudian.
              </li>
              <li>
                Selama masa berjalannya kontrak, <b>PIHAK KEDUA</b> dapat sewaktu-waktu mengundurkan diri dengan pemberitahuan lebih dahulu 1 (satu) bulan kepada <b>PIHAK PERTAMA</b>; sedangkan <b>PIHAK PERTAMA</b> dapat sewaktu-waktu
                memutuskan Perjanjian ini secara sepihak dan memberhentikan <b>PIHAK KEDUA.</b>
              </li>
              <li>Dalam waktu selambat-lambatnya 7 (tujuh) hari kerja menjelang berakhirnya masa percobaan, <b>PIHAK PERTAMA</b> wajib melakukan penilaian kinerja terhadap <b>PIHAK KEDUA.</b></li>
            </ol>
          </div>
    
          <!-- Pasal 3 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 3</p>
            <p class="text-center font-weight-bold">HAK DAN KEWAJIBAN</p>
            <ol>
              <li><b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> secara bersama-sama berkewajiban membina hubungan kerja yang harmonis agar tercipta ketenangan kerja dan ketenangan usaha.</li>
              <li><b>PIHAK KEDUA</b> berhak:</li>
              <p class="m-0">2.1. Menerima gaji dari PIHAK PERTAMA sebagaimana diatur Surat Perjanjian Kerja (PKWTP) dengan rincian:</p>
              <p class="m-0">Gaji Pokok : Rp.  @currency($takeHomePay)/ bulan</p>
              <li><b>PIHAK KEDUA</b> berkewajiban:</li>
              <p class="m-0">3.1. Mentaati segala peraturan yang diberikan <b>PIHAK PERTAMA.</b></p>
              <p class="m-0">3.2. Setuju untuk diberangkatkan/ ditempatkan di luar negeri atau lokasi lainnya yang ditunjuk oleh <b>PIHAK PERTAMA</b>, setelah dinyatakan lulus masa percobaan 3 (tiga) bulan.</p>
              <p class="m-0">3.3. Setuju untuk tidak hamil selama periode kontrak kerja</p>
              <p class="m-0">3.4. Setuju untuk memenuhi target yang diberikan sebagaimana yang ditentukan pihak Pertama.</p>
              <p class="m-0">3.5. Setuju untuk mematuhi semua ketentuan yang diatur oleh Pihak Pertama, termasuk adanya perubahan dan penyempurnaan peraturan yang dikeluarkan oleh Pihak Pertama.</p>
              <p class="m-0">3.6.  Setuju untuk memenuhi Target Minimal sebagaimana yang telah ditetapkan Pihak Pertama</p>
              <p class="m-0">3.7. Membuat laporan program kerja yang meliputi Planning, Sistem Kinerja dan atau hasil pencapaian target dsb.</p>
              <p class="m-0">
                3.8 Merahasiakan semua informasi mengenai <b>PIHAK PERTAMA</b> yang diterima atau diketahui olehnya – baik karena jabatannya, atau karena sebab lain – baik selama ia bekerja pada Pihak Pertama maupun setelah Perjanjian Kerja
                ini berakhir.
              </p>
              <p class="m-0">
                3.9 Menyerahkan semua informasi mengenai <b>PIHAK PERTAMA</b> yang diterima atau diketahui olehnya – baik karena jabatannya, atau karena sebab lain termasuk semua informasi maupun data dalam bentuk hard copy, email, CD, USB
                maupun dalam bentuk media lainnya; kepada atasannya.
              </p>
            </ol>
          </div>
    
          <!-- Pasal 4 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 4</p>
            <p class="text-center font-weight-bold">Denda dan Sanksi</p>
            <ol>
              <li class="mb-2"><b>Denda Keterlambatan</b></li>
              <ol type="a">
                <li>Apabila <b>PIHAK KEDUA</b> datang terlambat sebanyak 3 (tiga) kali dalam seminggu maka akan diterbitkan Surat Peringatan 1 (SP 1).</li>
                <li>Apabila <b>PIHAK KEDUA</b> datang terlambat karena keadaan force majeure (bencana alam) wajib melampirkan dokumentasi yang jelas dan dapat dibuktikan seperti : Foto, video dan bukti lainnya kepada atasan maun HRD</li>
                <li>
                  Apabila <b>PIHAK KEDUA</b> terlambat datang ke kantor sesuai dengan ketentuan yang telah ditetapkan maka akan dikenakan denda Rp. 10.000/ hari (dibawah 30 menit), Rp. 50.000/ hari (dibawah 60 menit) dan Rp. 100.000/hari
                  (diatas 60 menit) serta potong gaji setengah hari (diatas 120 menit)
                </li>
                <p class="mb-0 mt-3">Keterlambatan juga akan mempengaruhi kemungkinan perpanjangan kontrak untuk kontrak berikutnya.</p>
              </ol>
              <li class="my-2"><b>Denda Ketidakhadiran</b></li>
              <p class="m-0">Apabila PIHAK KEDUA tidak hadir maka akan dikenakan sanksi sebagai berikut :</p>
              <ol type="a">
                <li>
                  Sakit/ Izin <br />
                  Wajib memberitahukan kepada atasan ataupun HRD maksimal 2 jam sebelum jam masuk kantor, yaitu pukul 07.00 WIB dan melampirkan surat keterangan dokter beserta bukti pendukung lainnya (Foto obat, cedera tubuh dan lainnya).
                  Apabila tidak memberikan informasi dan bukti sesuai ketentuan diatas maka akan dikenakan pemotongan gaji
                </li>
                <li>
                  Alpa <br />
                  Apabila tidak memberikan informasi atau keterangan kepada atasan ataupun HRD akan diberhentikan/ PHK.
                </li>
              </ol>
              <li class="my-2"><b>Denda Kerusakan Barang</b></li>
              <p class="m-0">
                Apabila PIHAK KEDUA ditemukan bertanggung jawab atas kerusakan peralatan kerja, sarana tempat tinggal, dan area bekerja maka akan dikenakan denda oleh PIHAK KEDUA. Nominal akan ditentukan berdasarkan jumlah kerusakan.
              </p>
              <li class="my-2"><b>Sanksi Pelanggaran Ringan dan Surat Peringatan</b></li>
              <ol type="a">
                <li>Apabila <b>PIHAK KEDUA</b> melanggar aturan tata tertib kantor maka akan diberikan <b>Surat Peringatan</b> atau SP. Surat Peringatan tersebut berlaku sepanjang masa periode kontrak.</li>
                <li>
                  <b>PIHAK KEDUA</b> bisa diberikan SP kedua bila melakukan pelanggaran dalam kurun waktu berlaku SP pertama. Dengan akumulasi <b>SP kedua</b> maka <b>PIHAK KEDUA</b> akan diputuskan hubungan kerja dengan
                  <b>PIHAK PERTAMA.</b> SP juga bisa diberikan untuk kasus keterlambatan, ketidakhadiran, dan kerusakkan barang.
                </li>
                <li>Adapun ketentuan atau sanksi yang berlaku jika <b>PIHAK PERTAMA</b> mendapatkan SP yaitu sebagai berikut :</li>
                <p class="m-0">- SP 1 akan memotong 10% dari gaji pokok</p>
                <p class="m-0">- SP 2 akan memotong 25% dari gaji pokok</p>
              </ol>
            </ol>
          </div>
    
          <!-- Pasal 5 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 5</p>
            <p class="text-center font-weight-bold">WAKTU DAN TEMPAT KERJA</p>
            <p class="m-0"><b>PIHAK KEDUA</b> wajib mentaati waktu kerja sebagai berikut:</p>
            <div class="p-3">
              <table width="100%">
                <tr>
                  <td>Senin – Jum’at</td>
                  <td>: Jam 09.00 – 18.00 WIB</td>
                </tr>
                <tr>
                  <td>Istirahat</td>
                  <td>: Jam 13.00 – 14.00 WIB</td>
                </tr>
                <tr>
                  <td>Libur</td>
                  <td>: Sabtu, Minggu dan Libur Nasional/Tanggal Merah</td>
                </tr>
              </table>
            </div>
            <p>
              Ketentuan: <br />
              - Waktu dan hari kerja bisa berubah sesuai dengan ketentuan yang ditetapkan Perusahaan
            </p>
          </div>
    
          <!-- Pasal 6 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 6</p>
            <p class="text-center font-weight-bold">PENYELESAIAN PERSELISIHAN</p>
            <ol>
              <li>Bila terjadi perselisihan antara kedua belah pihak dalam melaksanakan perjanjian kerja ini, kedua belah pihak akan menyelesaikannya secara musyawarah.</li>
              <li>Apabila penyelesaian pada ayat satu di atas tidak berhasil, maka perselisihan akan diselesaikan sesuai jalur hukum yang berlaku.</li>
            </ol>
          </div>
    
          <!-- Pasal 7 -->
          <div>
            <p class="text-center font-weight-bold m-0">Pasal 7</p>
            <p class="text-center font-weight-bold">LAIN-LAIN</p>
            <ol>
              <li>Hal-hal yang belum tercantum di dalam Perjanjian ini, akan diatur kemudian.</li>
              <li>Segala perubahan terhadap sebagian atau seluruh pasal-pasal dalam Perjanjian Kerja Waktu Tertentu ini hanya dapat dilakukan dengan persetujuan kedua belah pihak.</li>
            </ol>
            <p>Demikianlah Perjanjian Kerja Waktu Tertentu ini dibuat oleh kedua belah pihak dalam keadaan sehat jasmani dan rohani tanpa adanya paksaan ataupun tekanan dari pihak manapun.</p>
          </div>
    
          <div class="p-3">
            <table width="100%">
              <tr class="text-center font-weight-bold">
                <td>PIHAK PERTAMA</td>
                <td>PIHAK KEDUA</td>
              </tr>
              <tr class="text-center">
                <td>&nbsp;</td>
                <td>
                  @if(@Storage::disk('public')->exists('/upload/'.$employee->employee_id.".png"))
                      <img src="{{asset('storage/upload/'.$employee->employee_id.'.png')}}" class="w-25 m-auto"/>
                  @else
                  <div class="pt-10">
                    <button class="btn btn-success" data-toggle="modal" id="signaturePad" data-target="#signatureModal"
                        data-attr="{{ route('signaturepad.index')}}" title="show">Signature
                    </button>
                    @endif
                  </div>
                </td>
              </tr>
              <tr class="text-center">
                <td>Hendra</td>
                <td>{{$employee->full_name}} {{$employee->last_name}}</td>
              </tr>
              <tr class="text-center font-weight-bold">
                <td class="p-0">
                  <hr class="my-0 w-50 m-auto" />
                  Direktur
                </td>
                <td class="p-0">
                  <hr class="my-0 w-50 m-auto" />
                  Karyawan
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-7 text-right">
      <button type="button" class="btn btn-outline-brand px-5"><i class="fa flaticon2-print"></i> Print</button>
    </div>
  </div>
  @push('scriptjs')
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/js/jquery.signature.js"></script>
  <script>

    // display a modal (medium modal)
    $(document).on('click', '#signaturePad', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        console.log(href);
        $.ajax({
            url: href,
            beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                console.log(result)
                $('#mediumModal').modal("show");
                $('#mediumBody').html(result).show();
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        })
    });

</script>
@endpush
  @endsection
  <div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mediumBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>
