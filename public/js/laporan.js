$(function () {
     bsCustomFileInput.init();
});

function ubahTanggal() {
     let tglTabel = document.querySelectorAll('#tgl-kegiatan-tabel');
     for (i = 0; i <= tglTabel.length; i++) {
          tglTabel[i].innerHTML = ubahFormatTanggal2(tglTabel[i].textContent);
     }
}

$(document).ready(function () {
     ubahTanggal();
});

// --------
$(document).ready(function () {
     $(document).on('keyup', '#kegiatan-input', function () {
          $(this).next().removeClass('d-none');
          for (i = 0; i <= $(this).next().children().length; i++) {
               if ($(this).next().children().eq(i).text().toLowerCase().match($(this).val().toLowerCase()) !== null) {
                    $(this).next().children().eq(i).removeClass('d-none');
               } else {
                    $(this).next().children().eq(i).addClass('d-none');
               }
          }
     });

     $(document).on('blur', '#kegiatan-input', function () {
          let textarea = $(this);
          setTimeout(function () {
               textarea.next().addClass('d-none');
          }, 400);
     });

     $(document).on('click', '.option-kegiatan', function () {
          $(this).parent().prev().val($(this).text());
          $(this).parent().addClass('d-none');
     });
});

// ----------
var Toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 3000,
});
$(document).on('input', '#formFileMultiple', function () {
     if (this.files[0].size > 500000) {
          // ini untuk ukuran 500 Kb
          Toast.fire({
               icon: 'warning',
               title: 'Ukuran File Melebihi 500Kb!',
          });
          this.value = '';
          return false;
     }
     var pathFile = this.value;
     var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.pdf|\.xlsx|\.docx|\.ppt|\.txt|\.rar|\.zip|\.csv)$/i;
     if (!ekstensiOk.exec(pathFile)) {
          Toast.fire({
               icon: 'warning',
               title: 'Silakan upload file yang dengan ekstensi .png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip, .csv',
          });
          this.value = '';
          return false;
     }
});

// -------
var date = new Date();
document.getElementById('hari-ini').value = currentDate;
$('#tanggal-tambah').html(ubahFormatTanggal(currentDate));
$('#tanggal-edit').html(ubahFormatTanggal($('#tanggal-kegiatan').val()));
$('#tanggal-detail').html(ubahFormatTanggal($('#tanggal-kegiatan-detail').val()));

// ---------
$(document).on('mouseover', '.custom-file-input', function () {
     $(this).next().next().removeClass('d-none');
});
$(document).on('mouseout', '.custom-file-input', function () {
     $(this).next().next().addClass('d-none');
});
$(document).on('mouseover', '.file-list', function () {
     $(this).next('.file-tip2').removeClass('d-none');
});
$(document).on('mouseout', '.file-list', function () {
     $(this).next('.file-tip2').addClass('d-none');
});

// -------
// Mengambil Data edit dengan menggunakan Jquery
$(document).on('click', '#btn-edit-hapus', function () {
     $('#id_laporan_tertentu').val($(this).data('id_laporan_tertentu'));
     $('#posisi_array').val($(this).data('posisi_array'));
     $('#posisi_dalam_array').val($(this).data('posisi_dalam_array'));
     $('#tanggal_hapus').val($(this).data('tanggal_hapus'));
     $('#nama_bukti_dukung').text($(this).data('nama_bukti_dukung'));
});

//  ---------
$('#btn-modal-tambah').click(function () {
     $('#modal-tambah').modal('show');
});

$('#btn-close-modal-tambah').click(function () {
     $('#modal-tambah').modal('hide');
});

$('#btn-close-modal-tambah2').click(function () {
     $('#modal-tambah').modal('hide');
});

// --------
$(document).ready(function () {
     $('#tabelData').DataTable({
          paging: true,
          lengthChange: false,
          searching: true,
          responsive: true,
          ordering: true,
          info: true,
          autoWidth: false,
          pageLength: 10,
     });

     function filterData() {
          $('#tabelData')
               .DataTable()
               .search($('.tahun').val() + '-' + $('.bulan').val())
               .draw();
     }
     $('.tahun').on('change', function () {
          filterData();
     });

     $('.bulan').on('change', function () {
          filterData();
     });

     function filterData2() {
          $('#tabelData').DataTable().search($('.auto_search').val()).draw();
     }
     $('#btn-search').on('click', function () {
          filterData2();
     });

     $(document).ready(function () {
          $('#tabelData').DataTable().search($('.auto_search').val()).draw();
     });
     $('.tahun').change(function () {
          if ($(this).val() != '') {
               $('.bulan').removeClass('opacity-0');
          } else {
               $('.bulan').addClass('opacity-0');
               $('.bulan').prop('selectedIndex', 0);
          }
          filterData();
     });

     $('#tabelData_wrapper').children().first().addClass('d-none');
     $('.dataTables_paginate').addClass('Pager2').addClass('float-right');
     $('.dataTables_info').addClass('text-sm text-gray py-2');
     $('.dataTables_paginate').parent().parent().addClass('card-footer clearfix');

     $(document).on('keyup', '#pencarian', function () {
          $('#tabelData').DataTable().search($('.auto_search').val()).draw();
     });
});
// -----
(function () {
     $('.form-tambah').on('submit', function () {
          $('#tombol-simpan').attr('disabled', 'true');
     });
})();
(function () {
     $('.form-edit').on('submit', function () {
          $('#tombol-edit').attr('disabled', 'true');
     });
})();
