$('#tabelData4').DataTable({
     paging: true,
     lengthChange: false,
     searching: true,
     responsive: true,
     ordering: false,
     info: true,
     autoWidth: false,
     pageLength: 15,
});

$(document).ready(function () {
     $('#tabelData4').DataTable().search($('#pencarian4').val()).draw();
});

$('#tabelData4_wrapper').children().first().addClass('d-none');
$('.dataTables_paginate').addClass('Pager2').addClass('float-right');
$('.dataTables_info').addClass('text-sm text-gray py-2');
$('.dataTables_paginate').parent().parent().addClass('card-footer clearfix');

$(document).on('keyup', '#pencarian4', function () {
     $('#tabelData4').DataTable().search($('#pencarian4').val()).draw();
});

// ---------------
$(document).ready(function () {
     let tglTabel = document.querySelectorAll('#tgl-kegiatan-tabel');
     for (i = 0; i <= tglTabel.length; i++) {
          tglTabel[i].innerHTML = ubahFormatTanggal2(tglTabel[i].textContent);
     }
});
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

// ---------------
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
               title: 'Ukuran File Melebihi 200Kb!',
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

// ---------------
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

// ---------------
$(function () {
     var date = new Date();
     var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear();

     var Calendar = FullCalendar.Calendar;
     var calendarEl = document.getElementById('calendarWeek');
     var calendar = new Calendar(calendarEl, {
          displayEventTime: false,
          initialView: 'timeGridWeek',
          hiddenDays: [0, 6],
          headerToolbar: {
               left: 'prev,next today',
               right: 'title',
          },
          themeSystem: 'bootstrap',
          events: '',
          editable: false,
          droppable: false,
     });
     calendar.render();
});

$(function () {
     var date = new Date();
     var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear();

     var Calendar = FullCalendar.Calendar;
     var calendarEl = document.getElementById('calendar');

     var calendar = new Calendar(calendarEl, {
          headerToolbar: {
               left: 'prev,next today',
               right: 'title',
          },
          themeSystem: 'bootstrap',
          events: '',
          editable: false,
          droppable: false,
          locale: 'id',
     });
     calendar.render();
});
$('#btn-list-laporan').click(function () {
     $('#modal-list-laporan').modal('show');
});

const end = new Date();
let uncheck = [];
let j = 0;

let unnoted = [];

for (var loop = new Date(start); loop <= end; loop.setDate(loop.getDate() + 1)) {
     uncheck[j] = loop.toISOString().slice(0, 10);
     j++;
}

for (i = 0; i < check.length; i++) {
     for (j = 0; j < uncheck.length; j++) {
          if (check[i]['tgl'] == uncheck[j]) {
               uncheck[j] = '';
          }
     }
}

function appendIconKalender() {
     for (i = 0; i < check.length; i++) {
          $('.fc-daygrid-day').each(function () {
               if ($(this).data('date') == check[i]['tgl']) {
                    $(this).find('.fc-daygrid-day-events').addClass('d-flex justify-content-center');
                    $(this)
                         .find('.fc-daygrid-day-events')
                         .append(`<a href="` + check[i]['link'] + `" class="iconKalender sudah"><i class="fas fa-check-circle fa-2x text-green"></i></a>`);
               }
          });
     }
}

function appendIconKalenderUncheck() {
     for (i = 0; i < uncheck.length; i++) {
          $('.fc-daygrid-day').each(function () {
               if ($(this).data('date') == uncheck[i]) {
                    $(this).find('.fc-daygrid-day-events').addClass('d-flex justify-content-center');
                    $(this)
                         .find('.fc-daygrid-day-events')
                         .append(
                              `<a href="" id="btn-uncheck" data-toggle="modal" data-target="#modal-tambah" data-date_click="` +
                                   $(this).data('date') +
                                   `" class="iconKalender belum"><i class="fas fa-exclamation-circle fa-2x text-red"></i></a>`
                         );
               }
          });
     }
}
let lastDate = '';
let today = '';
function catatan() {
     j = 0;
     lastDate = '';
     today = '';
     today = new Date($('.fc-daygrid-day').first().data('date'));
     lastDate = new Date($('.fc-daygrid-day').last().data('date'));

     for (let loop = today; loop <= lastDate; loop.setDate(loop.getDate() + 1)) {
          unnoted[j] = loop.toISOString().slice(0, 10);
          j++;
     }

     for (i = 0; i < noted.length; i++) {
          for (j = 0; j < unnoted.length; j++) {
               if (noted[i]['tgl'] == unnoted[j]) {
                    unnoted[j] = '';
               }
          }
     }
     // NOTED
     for (i = 0; i < noted.length; i++) {
          $('.fc-daygrid-day').each(function () {
               if ($(this).data('date') == noted[i]['tgl'] && noted[i]['id_penerima'] == noted[i]['id_pengirim']) {
                    $(this).children().first().addClass('ada-note');
                    $(this).addClass('position-relative ada-note');
                    $(this).append(`<i data-catatan="` + noted[i]['catatan'] + `" data-id="` + noted[i]['id'] + `" class="fas fa-bookmark noteds open-note iconKalender"></i>`);
               }
          });
     }
     // UNNOTED
     for (i = 0; i < unnoted.length; i++) {
          $('.fc-day-future, .fc-day-today').each(function () {
               if ($(this).children().length < 2) {
                    $(this).addClass('position-relative');
                    $(this).append(`<i class="far fa-sticky-note unnoteds open-note iconKalender"></i>`);
               }
          });
     }
}

$(document).on('click', '.open-note', function () {
     $('.notesa').removeClass('d-none');
     $('.drop').removeClass('d-none');
     let tanggal = $(this).parent().data('date');
     let catatan = '';
     let tombol = 'Simpan';
     let action = '/tambahCatatan';
     let btnHapus = '';
     let formId = '';
     let formTgl = '<input type="hidden" name="tgl" value="' + $(this).parent().data('date') + '">';
     if ($(this).data('catatan') != undefined) {
          catatan = $(this).data('catatan');
          tombol = 'Update';
          action = '/updateCatatan';
          formId = '<input type="hidden" name="id" id="id_catatan" value="' + $(this).data('id') + '">';
          btnHapus = ' <span class="btn btn-sm btn-danger btn-hapus-catatan float-right mr-2 ">Hapus</span>';
     } else {
          catatan = '';
     }
     $('.notesa').append(
          `
     
       <form action="` +
               base_url +
               action +
               `" method="POST" class="position-absolute form-tambah-catatan card-catatan rounded shadow-lg px-4 py-3">
        ` +
               formId +
               formTgl +
               `
               <span class=" fa-2x close-catatan"><i class="fas fa-times"></i></span>
         <div class="row">
           <div class="col-6">
             <h6><strong>Catatan</strong></h6>
           </div>
           <div class="col-6 text-right">
             <p class="text-sm mb-3 font-italic text-gray" style="font-size: 8px;">` +
               ubahFormatTanggal(tanggal) +
               `</p>
           </div>
           <div class="col-12 mt-2">
           <div class="custom-control custom-radio">
             <input class="custom-control-input custom-control-input-primary custom-control-input-outline" type="radio" id="pribadi" name="radio" checked>
             <label for="pribadi" class="custom-control-label form-control-sm">Pribadi</label>
           </div>

         </div>
         <div class="col-12">
           <div class="custom-control custom-radio">
             <input class="custom-control-input custom-control-input-primary custom-control-input-outline" type="radio" id="untuk" name="radio">
             <label for="untuk" class="custom-control-label form-control-sm">Untuk</label>
           </div>
         </div>
               <div class="col-8">
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" id="cari-pegawai" placeholder="Cari pegawai..." disabled>
                    </div>
               </div>
               <div class="col-4">
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" id="nip-lama-view" placeholder="NIP Lama" disabled>
                    <input type="hidden" class="form-control form-control-sm" id="nip-lama" name="nip_lama">
                    </div>
               </div>
     

           <div class="col-12 form-group text-pribadi">
             <textarea name="catatan" id="catatan-editor-pribadi" class="form-control w-100 text-sm" rows="10" placeholder="Ketikkan Catatan ...">` +
               catatan +
               `</textarea>
           </div>

           <div class="col-12 form-group text-untuk d-none">
             <textarea name="catatan_dikirim" id="catatan-editor-untuk" class="form-control w-100 text-sm" rows="10" placeholder="Ketikkan catatan yang akan dikirim ..."></textarea>
           </div>
           
           <div class="col-12 tombol-tambah-update">
           <button type="submit" class="btn btn-sm btn-primary float-right">` +
               tombol +
               `</button>
           ` +
               btnHapus +
               `
            
           </div>
           <div class="col-12 tombol-kirim d-none">
           <button type="submit" class="btn btn-sm btn-primary float-right">Kirim</button>
           </div>
         </div>
       </form>
       `
     );

     $('#catatan-editor-pribadi').summernote({
          placeholder: 'Ketikkan catatan...',
          height: 110,
          toolbar: [['para', ['ul', 'ol']]],
     });
     $('#catatan-editor-untuk').summernote({
          placeholder: 'Ketikkan catatan yang akan dikirim ...',
          height: 110,
          toolbar: [['para', ['ul', 'ol']]],
     });
});

function tutup() {
     setTimeout(function () {
          $('.card-catatan').remove();
          $('.notesa').addClass('d-none');
          $('.drop').addClass('d-none');
     }, 600);
}

$(document).on('click', '.drop, .close-catatan', function () {
     $('.card-catatan').addClass('drop-tutup');
     tutup();
});
$(document).on('click', '.btn-hapus-catatan', function () {
     Swal.fire({
          title: 'Yakin ingin hapus catatan?',
          icon: 'question',
          showCancelButton: true,
          showConfirmButton: false,
          customClass: {
               confirmButton: 'submit-button-diswal',
          },
     });
     $('.swal2-actions').append('<a href="' + base_url + '/hapusCatatan/' + $('#id_catatan').val() + '" style="display: inline-block;" aria-label class="swal2-confirm submit-button-diswal swal2-styled" href="">Ya</a>');
});

$('.hari-ini').click(function () {
     $(this).addClass('shadow').addClass('btn-primary');
     $('.akan-datang').removeClass('shadow').removeClass('btn-primary');
     $('.sebelumnya').removeClass('shadow').removeClass('btn-primary');
     $('.catatan-container-hari-ini').removeClass('d-none').addClass('d-flex');
     $('.catatan-container-akan-datang').addClass('d-none').removeClass('d-flex');
     $('.catatan-container-sebelumnya').addClass('d-none').removeClass('d-flex');
});
$('.akan-datang').click(function () {
     $(this).addClass('shadow').addClass('btn-primary');
     $('.hari-ini').removeClass('shadow').removeClass('btn-primary');
     $('.sebelumnya').removeClass('shadow').removeClass('btn-primary');
     $('.catatan-container-akan-datang').removeClass('d-none').addClass('d-flex');
     $('.catatan-container-hari-ini').addClass('d-none').removeClass('d-flex');
     $('.catatan-container-sebelumnya').addClass('d-none').removeClass('d-flex');
});
$('.sebelumnya').click(function () {
     $(this).addClass('shadow').addClass('btn-primary');
     $('.akan-datang').removeClass('shadow').removeClass('btn-primary');
     $('.hari-ini').removeClass('shadow').removeClass('btn-primary');
     $('.catatan-container-sebelumnya').removeClass('d-none').addClass('d-flex');
     $('.catatan-container-akan-datang').addClass('d-none').removeClass('d-flex');
     $('.catatan-container-hari-ini').addClass('d-none').removeClass('d-flex');
});

$('.diterima').click(function () {
     $(this).addClass('shadow').addClass('btn-primary');
     $('.terkirim').removeClass('shadow').removeClass('btn-primary');
     $('.catatan-container-diterima').removeClass('d-none').addClass('d-flex');
     $('.catatan-container-terkirim').addClass('d-none').removeClass('d-flex');
});
$('.terkirim').click(function () {
     $(this).addClass('shadow').addClass('btn-primary');
     $('.diterima').removeClass('shadow').removeClass('btn-primary');
     $('.catatan-container-terkirim').removeClass('d-none').addClass('d-flex');
     $('.catatan-container-diterima').addClass('d-none').removeClass('d-flex');
});

$(document).ready(function () {
     const hariIni = $('.fc-day-today').data('date');
     for (i = 0; i < noted.length; i++) {
          if (noted[i]['id_penerima'] == noted[i]['id_pengirim']) {
               let hari = noted[i]['tgl'].split('-');
               let bulan = noted[i]['tgl'].split('-');
               let jenis = '';
               let container = '';

               if (hariIni < noted[i]['tgl']) {
                    jenis = 'upcoming';
                    container = '.catatan-container-akan-datang';
               } else if (hariIni == noted[i]['tgl']) {
                    jenis = 'now';
                    container = '.catatan-container-hari-ini';
               } else if (hariIni > noted[i]['tgl']) {
                    jenis = 'prev';
                    container = '.catatan-container-sebelumnya';
               }

               $(container).append(
                    `
                          <div class="rounded card-catatan-` +
                         jenis +
                         ` w-100 px-3 mb-2 py-2 bg-blue row d-flex align-items-center">
                              <div class="col-3">
                                <strong class="fa-2x">` +
                         hari[2] +
                         `</strong>/ ` +
                         bulan[1] +
                         `
                              </div>
                              <div class="col-9 text-sm text-wrap">
                                ` +
                         noted[i]['catatan'] +
                         `
                              </div>
                            </div>
            `
               );
          }
     }
});

$(document).ready(function () {
     if ($('.catatan-container-hari-ini').children().length == 0) {
          $('.catatan-container-hari-ini').append(`<small class="py-5 w-100 text-center"><em>Catatan Kosong</em></small>`);
     }
     if ($('.catatan-container-akan-datang').children().length == 0) {
          $('.catatan-container-akan-datang').append(`<small class="py-5 w-100 text-center"><em>Catatan Kosong</em></small>`);
     }
     if ($('.catatan-container-sebelumnya').children().length == 0) {
          $('.catatan-container-sebelumnya').append(`<small class="py-5 w-100 text-center"><em>Catatan Kosong</em></small>`);
     }
});

function hapusAppend() {
     $('.fc-daygrid-day').each(function () {
          $(this).find('.iconKalender').remove();
     });
}
function tips() {
     $('.fc-toolbar-chunk').first().append(`
     <i class="far fa-question-circle text-gray ml-4 tips-kalender" data-toggle="dropdown"></i>
     <div class="dropdown-menu dropdown-menu-md border-0 p-4" style="max-width: 420px; z-index: 10000;">
     <h5 class="mb-4"> <i class="far fa-question-circle text-yellow mr-1"></i> <strong>Tip</strong></h5>
               <p>Ikon <i class="fas fa-exclamation-circle text-red"></i> menandai jika di tanggal tersebut anda belum menginputkan kegiatan. Klik <i class="fas fa-exclamation-circle text-red"></i> untuk menambahkan.</p>

               <p>Ikon <i class="fas fa-check-circle text-green"></i> menandai jika pada tanggal tersebut anda telah menginputkan kegiatan. Klik <i class="fas fa-check-circle text-green"></i> untuk melihat detail kegiatan.</p>

               <p>Klik ikon <i class="far fa-sticky-note unnoteds"></i> untuk menambahkan catatan pada tanggal tersebut.</p>

               <p>Ikon <i class="fas fa-bookmark noteds"></i> menandai jika pada tanggal tersebut terdapat sebuah catatan. Klik <i class="fas fa-bookmark noteds"></i> untuk melihat atau mengedit.</p>
<button class="float-right btn btn-sm btn-primary">Oke</button>
     </div>
     `);
}

// ----------
$(document).on('click', '#btn-uncheck', function () {
     $('#hari-ini').val($(this).data('date_click'));

     $('#tanggal-tambah').html(ubahFormatTanggal($('#hari-ini').val()));
});
$('#tanggal-edit').html(ubahFormatTanggal($('#tanggal-kegiatan').val()));
$('#tanggal-detail').html(ubahFormatTanggal($('#tanggal-kegiatan-detail').val()));

// ----------
$(function () {
     'use strict';

     var ticksStyle = {
          fontColor: '#495057',
          fontStyle: 'bold',
     };

     var mode = 'index';
     var intersect = true;

     var $kegiatanChart = $('#kegiatan-chart');
     // eslint-disable-next-line no-unused-vars
     var kegiatanChart = new Chart($kegiatanChart, {
          type: 'bar',
          data: {
               labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'],
               datasets: [
                    {
                         backgroundColor: '#3c4b64',
                         borderColor: '#3c4b64',
                         data: dataBulan,
                    },
               ],
          },
          options: {
               maintainAspectRatio: false,
               tooltips: {
                    mode: mode,
                    intersect: intersect,
               },
               hover: {
                    mode: mode,
                    intersect: intersect,
               },
               legend: {
                    display: false,
               },
               scales: {
                    xAxes: [
                         {
                              range: 1,
                              gridLines: {
                                   display: true,
                              },
                              ticks: $.extend(
                                   {
                                        beginAtZero: true,

                                        callback: function (value) {
                                             return value;
                                        },
                                   },
                                   ticksStyle
                              ),
                         },
                    ],
                    yAxes: [
                         {
                              display: true,
                              gridLines: {
                                   display: false,
                              },
                              ticks: ticksStyle,
                         },
                    ],
               },
          },
     });
});

// ----------

(function () {
     $(document).on('submit', 'form', function () {
          $(this).find(':submit').attr('disabled', 'true');
     });
})();

// --------
$(function () {
     $(document).on('click', '.open-note', function () {
          $('#cari-pegawai').autocomplete({
               source: pegawai,
               focus: function (event, ui) {
                    $('#cari-pegawai').val(ui.item.label);
                    return false;
               },
               select: function (event, ui) {
                    $('#nip-lama').val(ui.item.label);
                    $('#nip-lama').val(ui.item.nip_lama);
                    $('#nip-lama-view').val(ui.item.nip_lama);
                    return false;
               },
               minLength: 2,
          });
     });
});

let actionFix = '';
$(document).on('click', '.noteds', function () {
     actionFix = $('.form-tambah-catatan').attr('action');
});
$(document).on('click', '.unnoteds', function () {
     actionFix = base_url + '/tambahCatatan';
});
$(document).on('change', '#pribadi', function () {
     if ($(this).prop('checked') == true) {
          $('.form-tambah-catatan').attr('action', actionFix);
          $('#cari-pegawai').prop('disabled', true).val('');
          $('#nip-lama').val('');
          $('#nip-lama-view').val('');
          $('.text-pribadi').removeClass('d-none');
          $('.text-untuk').addClass('d-none');
          $('.tombol-tambah-update').removeClass('d-none');
          $('.tombol-kirim').addClass('d-none');
     }
});
$(document).on('change', '#untuk', function () {
     if ($(this).prop('checked') == true) {
          $('.form-tambah-catatan').attr('action', base_url + '/tambahCatatan');
          $('#cari-pegawai').prop('disabled', false);
          $('.text-pribadi').addClass('d-none');
          $('.text-untuk').removeClass('d-none');
          $('.tombol-tambah-update').addClass('d-none');
          $('.tombol-kirim').removeClass('d-none');
     }
});

$(document).ready(function () {
     const hariIni = $('.fc-day-today').data('date');
     $.each(noted, function (index, value) {
          let hari = noted[index]['tgl'].split('-');
          let bulan = noted[index]['tgl'].split('-');
          let tahun = noted[index]['tgl'].split('-');
          let jenis = '';
          if (noted[index]['id_pengirim'] != myId && noted[index]['id_penerima'] == myId && noted[index]['tgl'] >= hariIni) {
               $('.catatan-container-diterima').append(
                    `
                 <div class="rounded card-catatan-upcoming w-100 px-3 mb-2 py-2 bg-blue row d-flex align-items-center">
                     <div class="col-3">
                       <strong class="fa-2x">` +
                         hari[2] +
                         `</strong>/  ` +
                         bulan[1] +
                         `
                     
                     </div>
                     <div class="col-9 text-sm text-wrap">
                     <h6>Dari <strong>   ` +
                         noted[index]['pengirim'] +
                         `</strong></h6>
        <em>Catatan: </em>      ` +
                         noted[index]['catatan'] +
                         `
                     </div>
                   </div>
   `
               );
          }
          if (noted[index]['id_pengirim'] == myId && noted[index]['id_penerima'] != myId && noted[index]['tgl'] >= hariIni) {
               $('.catatan-container-terkirim').append(
                    `
                 <div class="rounded card-catatan-sent w-100 px-3 mb-2 py-2 bg-blue row d-flex align-items-center">
                     <div class="col-3">
                     <input type="hidden" name="id" id="id_catatan" value="` +
                         noted[index]['id'] +
                         `">
                       <strong class="fa-2x">` +
                         hari[2] +
                         `</strong>/  ` +
                         bulan[1] +
                         `
                     
                     </div>
                     <div class="col-8 text-sm text-wrap">
                     <h6>Terkirim ke <strong>   ` +
                         noted[index]['penerima'] +
                         `</strong></h6>
                 <em>Catatan: </em>    ` +
                         noted[index]['catatan'] +
                         `
                     </div>
                     <div class="co-1">
                     <input type="hidden" value="` +
                         noted[index]['id'] +
                         `">
<span class="btn-hapus-catatan2"><i class="fas fa-trash text-white"></i></span>
</div>
                   </div>
   `
               );
          }
     });

     $(document).on('click', '.btn-hapus-catatan2', function () {
          Swal.fire({
               title: 'Yakin ingin hapus catatan?',
               icon: 'question',
               showCancelButton: true,
               showConfirmButton: false,
               customClass: {
                    confirmButton: 'submit-button-diswal',
               },
          });
          $('.swal2-actions').append('<a href="' + base_url + '/hapusCatatan/' + $(this).prev().val() + '" style="display: inline-block;" aria-label class="swal2-confirm submit-button-diswal swal2-styled" href="">Ya</a>');
     });

     if ($('.catatan-container-diterima').children().length == 0) {
          $('.pulse').addClass('d-none');
     }
});
