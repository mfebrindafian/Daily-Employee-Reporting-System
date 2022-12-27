let uraianFix = [];
for (i = 0; i < uraian.length; i++) {
     uraianFix = uraianFix + `<option class="option-kegiatan border-bottom d-none">` + uraian[i] + `</option>`;
}
let satuanFix = [];
for (i = 0; i < satuan.length; i++) {
     satuanFix = satuanFix + `<option value="` + satuan[i] + `">` + satuan[i] + `</option>`;
}
let rencanaFix = [];
for (i = 0; i < rencana.length; i++) {
     rencanaFix = rencanaFix + `<option value="` + rencana[i]['id'] + `">` + rencana[i]['rincian'] + `</option>`;
}

$(document).ready(function () {
     $('#modal-edit').modal('show');
     $('#modal-detail').modal('show');

     $(document).on('click', '#hapus-baris', function () {
          if ($(this).parent().parent().attr('id') == 'baru') {
               $(this).parent().remove();
               $('#baru').children().find('#hapus-baris').addClass('d-none');
               $('#baru').children().last().find('#hapus-baris').removeClass('d-none');
          }
          if ($(this).parent().parent().attr('id') == 'baru2') {
               $(this).parent().remove();
               $('#baru2').children().find('#hapus-baris').addClass('d-none');
               $('#baru2').children().last().find('#hapus-baris').removeClass('d-none');
          }
     });

     function appendBaris(modal, noBaris) {
          let jamAkhir = document.querySelectorAll('.jam_akhir');
          let jamTerbesar = jamAkhir[jamAkhir.length - 1].value;
          $(modal).append(
               `
               <div class="row rounded position-relative pt-2 kegiatan-baru mt-4">
               <span id="hapus-baris" type="button" class="delete-kegiatan"><i class="fas fa-times"></i></span>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-1 baris-kegiatan">
                                    <div class="row"><strong>NO</strong></div>
                                    <div class="row">` +
                    noBaris +
                    `</div>
                                </div>
                                <div class="col-xl-11 baris-kegiatan">
                                    <div class="row"><strong>Tipe Kegiatan</strong></div>
                                    <div class="row w-100">
                                        <div class="input-group w-100">
                                            <select class="form-control w-100 tipe-kegiatan" name="field_tipe[]" required>
                                                <option value=""> - Pilih Tipe -</option>
                                                <option value="1">Berdasarkan sasaran kegiatan</option>
                                                <option value="2">Umum</option>
                                                <option value="3">Lembur</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 baris-kegiatan pilih-kegiatan d-none">
                                    <div class="row"><strong>Pilih Kegiatan</strong></div>
                                    <div class="row w-100">
                                        <div class="input-group w-100">
                                            <select class="form-control w-100 pilih-rencana" name="field_rencana[]" required>
                                                <option class="nilai-nol" value="0">- Pilih Kegiatan -</option>

                                                ` +
                    rencanaFix +
                    `
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-xl-1 baris-kegiatan">
                                </div>
                                <div class="col-xl-4 baris-kegiatan">
                                    <div class="row"><strong>Uraian Kegiatan</strong></div>
                                    <div class="row px-1  w-100">
                            
                                        <div class="form-group w-100 position-relative">
                                            <textarea id="kegiatan-input" class="form-control  w-100" name="field_uraian[]" rows="3" placeholder="Masukkan Uraian Kegiatan ..." required></textarea>
                                            <div class="option-kegiatan-wrapper w-100 mt-2 bg-white py-2 rounded shadow-lg position-absolute d-none">
                                            ` +
                    uraianFix +
                    `
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-1 baris-kegiatan">
                                    <div class="row"><strong>Jumlah</strong></div>
                                    <div class="row px-1  w-100">
                                        <div class="form-group  w-100">
                                            <input type="number" class="form-control  w-100" name="field_jumlah[]" min="1" value="1" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 baris-kegiatan">
                                    <div class="row"><strong>Satuan</strong></div>
                                    <div class="row px-1  w-100">
                                        <div class="input-group  w-100">
                                            <select class=" form-control  w-100" name="field_satuan[]" required>
                                            ` +
                    satuanFix +
                    `
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 baris-kegiatan">
                                    <div class="row"><strong>Hasil Kegiatan</strong></div>

                                    <div class="row px-1  w-100">
                                        <div class="form-group  w-100 position-relative">
                                            <textarea class="form-control  w-100" name="field_hasil[]" rows="3" placeholder="Masukkan Hasil Kegiatan ..." required></textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 baris-kegiatan">
                                <div class="row"><strong>Durasi Kegiatan</strong></div>

                                <div class="input-group">
                                    <input class="form-control jam_mulai" required type="time"  name="field_jam_mulai[]" min="07:30" value="` +
                    jamTerbesar +
                    `">
                                </div>
                                <div class="input-group">
                                    <input class="form-control jam_akhir" required type="time"  name="field_jam_selesai[]" value="` +
                    jamTerbesar +
                    `">
                                </div>
                            </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-1"></div>
                                <div class="col-xl-11 baris-kegiatan mb-2">
                                    <div class="row"><strong>Bukti Dukung</strong></div>
                                    <div class="row w-100">
                                        <div class="input-group w-100">
                                            <div class="custom-file w-100 position-relative">
                                                <input type="file" class="custom-file-input w-100" name="field_bukti` +
                    noBaris +
                    `[]" id="formFileMultiple" accept=".png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip, .csv" required multiple />
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                <p class="file-tip d-none">
                                                    <strong class="mt-2 d-flex align-items-center">
                                                        <i class="fas fa-exclamation-circle fa-2x text-yellow mr-2"></i>
                                                        Jenis file :
                                                    </strong> <br>
                                                    .png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip <br><br>
                                                    <strong>
                                                        Ukuran File Maks : 200kb
                                                    </strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
    `
          );
     }

     $('[id^="tambah-baris"]').click(function () {
          let noBaris = $('#lama').children().length + $('#baru').children().length + 1;
          appendBaris('#baru', noBaris);
          bsCustomFileInput.init();
          $('#baru').children().find('#hapus-baris').addClass('d-none');
          $('#baru').children().last().find('#hapus-baris').removeClass('d-none');
     });

     $('[id^="tambah-baris2"]').click(function () {
          let noBaris2 = $('#lama2').children().length + $('#baru2').children().length + 1;
          appendBaris('#baru2', noBaris2);
          bsCustomFileInput.init();
          $('#baru2').children().find('#hapus-baris').addClass('d-none');
          $('#baru2').children().last().find('#hapus-baris').removeClass('d-none');
     });
});

$(document).ready(function () {
     $(document).on('input', '.satuan-waktu', function () {
          var value = $(this).val();
          if (value !== '' && value.indexOf('.') === -1) {
               $(this).val(Math.max(Math.min(value, 60), 0));
          }
     });
});

$(document).ready(function () {
     $(document).on('change', '.jam_mulai', function () {
          const d = new Date($('input[name="tanggal"]').val());
          let day = d.getDay();
          let maxJam = '';
          if (day == 5) {
               maxJam = '16:30';
          } else {
               maxJam = '16:00';
          }
          let jamMulai = document.querySelectorAll('.jam_mulai');
          let jamAkhir = document.querySelectorAll('.jam_akhir');
          let index = $('.jam_mulai').index(this);
          // console.log(jamAkhir[index].value)
          if ($(this).val() > maxJam) {
               $(this).val(maxJam);
          }
          if (index > 0) {
               if ($(this).val() < jamAkhir[index - 1].value) {
                    $(this).val(jamAkhir[index - 1].value);
               }
          }
          if ($(this).val() < jamAkhir[index].value) {
               $(this).val(jamAkhir[index].value);
          }
     });

     $(document).on('change', '.jam_akhir', function () {
          const d = new Date($('input[name="tanggal"]').val());
          let day = d.getDay();
          let maxJam = '';
          if (day == 5) {
               maxJam = '16:30';
          } else {
               maxJam = '16:00';
          }
          let jamMulai = document.querySelectorAll('.jam_mulai');
          let jamAkhir = document.querySelectorAll('.jam_akhir');
          let index = $('.jam_akhir').index(this);
          console.log(jamMulai.length);

          if ($(this).val() > maxJam) {
               $(this).val(maxJam);
          }
          if ($(this).val() < jamMulai[index].value) {
               $(this).val(jamMulai[index].value);
          }
          if (jamAkhir.length > index + 1) {
               if ($(this).val() > jamMulai[index + 1].value) {
                    $(this).val(jamMulai[index + 1].value);
               }
          }
     });
});
