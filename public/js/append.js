let uraianFix = [];
for (i = 0; i < uraian.length; i++) {
     uraianFix = uraianFix + `<option class="option-kegiatan border-bottom d-none">` + uraian[i] + `</option>`;
}
let satuanFix = [];
for (i = 0; i < satuan.length; i++) {
     satuanFix = satuanFix + `<option value="` + satuan[i] + `">` + satuan[i] + `</option>`;
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
          $(modal).append(
               `
        <div class="row mt-4 rounded position-relative pt-2 kegiatan-baru">
                    <span id="hapus-baris" type="button" class="delete-kegiatan"><i class="fas fa-times"></i></span>
                    <div class="col-xl-1 baris-kegiatan">
                        <div class="row"><strong>NO</strong></div>
                        <div class="row">` +
                    noBaris +
                    `</div>
                    </div>
                    <div class="col-xl-4 baris-kegiatan">
                        <div class="row"><strong>Uraian Kegiatan</strong></div>
                        <div class="row px-1 w-100">
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
                        <div class="row px-1 w-100">
                            <div class="form-group w-100">
                                <input type="number" min="1" value="1" class="form-control w-100" name="field_jumlah[]" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 baris-kegiatan">
                        <div class="row"><strong>Satuan</strong></div>
                        <div class="row px-1 w-100">
                            <div class="input-group w-100">
                            <select class=" form-control w-100" name="field_satuan[]" required>
                                    ` +
                    satuanFix +
                    `
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 baris-kegiatan">
                        <div class="row"><strong>Hasil Kegiatan</strong></div>
                        <div class="row px-1 w-100">
                              <div class="form-group  w-100 position-relative">
                              <textarea class="form-control  w-100" name="field_hasil[]" rows="3" placeholder="Masukkan Hasil Kegiatan ..." required></textarea>
                            
                                </div>
                        </div>
                    </div>
                    <div class="col-xl-2 baris-kegiatan mb-2">
                        <div class="row"><strong>Bukti Dukung</strong></div>
                        <div class="row w-100">
                            <div class="input-group w-100">
                                <div class="custom-file w-100">
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
