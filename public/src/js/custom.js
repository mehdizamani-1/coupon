var
    persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
    arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g],
    fixNumbers = function (str)
    {
         if(typeof str === 'string')
         {
              for(var i=0; i<10; i++)
              {
                   str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
              }
         }
         return str;
    };
$('#pdf').on('click',function(){
     $("#data_table").tableHTMLExport({type:'pdf',filename:'content.pdf'});
});
$('#json').on('click',function(){
     $("#data_table").tableHTMLExport({type:'json',filename:'content.json'});
});
$('#csv').on('click',function(){
     $("#data_table").tableHTMLExport({type:'csv',filename:'content.csv'});
});
function toExcel(name = "Excel Document Name", filename = "myFileName") {
     $(".table2excel").table2excel({
          exclude: ".noExl",
          name: name,
          filename: filename,
          fileext: ".xls",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
     });
}
$('.sub-list').before().click(function () {
     $(this).children('.sub-menu').slideToggle();
     $(this).toggleClass('sub-menu-show');
});
$('.close-nav-right').click(function () {
     $(".body").toggleClass('sidebar-right-hide');
     $(this).toggleClass('hide-nav');
});
$(window).on("load", function () {
     $('#loading').slideToggle();
});
$('.search-icon').click(function () {
     $(".search-form").slideToggle();
     $(this).children('.fa-search').toggleClass('fa-close');
});
// --- change 6/9/98 
$('.add-atr').click(function () {
     $('.tbody-atr').append('<tr class="tr-atr"><th> <input type="text" class="form-control" id="exampleInputUsername1" placeholder="ویژگی"></th> <td> <input type="text" class="form-control" id="exampleInputUsername1" placeholder="مقدار"></td> <td class="text-left"><div class="delete-atr"><i class="fa fa-times text-danger fa-2x mt-3"></i></div> </td> </tr>')
});
$('.add-atr2').click(function () {
     $('.tbody-atr2').append('<tr class="tr-atr"> <td><select class="form-control" id="exampleFormControlSelect1"> <option> جنسیت</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select></td> <td><select class="form-control" id="exampleFormControlSelect1"> <option>رنگ</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select></td> <td><select class="form-control" id="exampleFormControlSelect1"> <option>سایز</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select></td> <td><select class="form-control" id="exampleFormControlSelect1"> <option>واحد</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select></td> <td><input type="text" class="form-control" id="exampleInputUsername1" placeholder="تومان"></td> <td class="text-left"><div class="delete-atr"><i class="fa fa-times text-danger fa-2x mt-3"></i></div></td></tr>')
});
$(document).ready(function () {
     $('.delete-atr').click(function () {
          $(this).parents(".tr-atr").remove();
     });
});
// ---/ change 6/9/98 
$(document).ready(function () {
     $('#data_table').DataTable({
          oLanguage: {
               oAria: {
                    sSortAscending: ": activate to sort column ascending",
                    sSortDescending: ": activate to sort column descending"
               },
               oPaginate: {
                    sFirst: "اولین",
                    sLast: "آخرین",
                    sNext: "بعد",
                    sPrevious: "قبل"
               },
               sEmptyTable: "هیچ موردی موجود نیست",
               sInfo: "نمایش از _START_ تا _END_ از مجموع _TOTAL_ مورد",
               sInfoEmpty: "نمایش 0 تا از 0 مورد",
               sInfoFiltered: "(فیلتر شده از _MAX_ مجموع نتایج)",
               sInfoPostFix: "",
               sDecimal: "",
               sThousands: ",",
               sLengthMenu: "نمایش _MENU_ مورد",
               sLoadingRecords: "لطفا صبر کنید...",
               sProcessing: "در حال بررسی",
               sSearch: "جستجو:",
               sSearchPlaceholder: "",
               sUrl: "",
               sZeroRecords: "هیچ موردی یافت نکرد"
          },
     });
});
$(document).ready(function () {
     $('#data_table_2').DataTable({
          oLanguage: {
               oAria: {
                    sSortAscending: ": activate to sort column ascending",
                    sSortDescending: ": activate to sort column descending"
               },
               oPaginate: {
                    sFirst: "اولین",
                    sLast: "آخرین",
                    sNext: "بعد",
                    sPrevious: "قبل"
               },
               sEmptyTable: "هیچ پیام ای موجود نیست",
               sInfo: "نمایش از _START_ تا _END_ از مجموع _TOTAL_ پیام",
               sInfoEmpty: "نمایش 0 تا از 0 پیام",
               sInfoFiltered: "(فیلتر شده از _MAX_ مجموع نتایج)",
               sInfoPostFix: "",
               sDecimal: "",
               sThousands: ",",
               sLengthMenu: "نمایش _MENU_ پیام",
               sLoadingRecords: "لطفا صبر کنید...",
               sProcessing: "در حال بررسی",
               sSearch: "جستجو:",
               sSearchPlaceholder: "",
               sUrl: "",
               sZeroRecords: "هیچ پیام ای یافت نکرد"
          },
     });
});
$(document).ready(function () {
     $('#summernote').summernote({
          height: 300, // set editor height
          minHeight: null, // set minimum height of editor
          maxHeight: null, // set maximum height of editor
          focus: true, // set focus to editable area after initializing summernote
          log: false
     });
     // $('.summernote').summernote();
});
// $(document).ready(function () {
//      $('.dropzone').dropzone();
// });

$(function () {
     // multi select
     $('#option_s2').select2({
          placeholder: "انتخاب کنید",
          dir: "rtl"
     });
     // multi select
     $('#option_s3').select2({
          placeholder: "انتخاب کنید",
          dir: "rtl"
     });
     // tagging support
     $('#option_s9').select2({
          placeholder: "برچسب را وارد کنید و اینتر را بزنید",
          tags: true,
          dir: "rtl",
          noresults: "message"
     });
     $('#option_s8').select2({
          placeholder: "کلمه کلیدی را وارد کنید و اینتر را بزنید",
          tags: true,
          dir: "rtl",
          noresults: "message"
     });
     $('#option_s80').select2({
          placeholder: "مثال: ادویه به مقدار لازم بعد اینتر را بزنید",
          tags: true,
          dir: "rtl",
          noresults: "message"
     });

});
$(document).ready(function () {
     var drEvent_file = $(".dropify").dropify({
          messages: {
               default: "تصویر مورد نظر را بکشید و اینجا بی اندازید یا کلیک کنید",
               replace: "برای جایگزین بکشید و بی اندازید یا کلیک کنید",
               remove: "حذف کردن",
               error: "مشکلی به وجود آمده است،لطفا دوباره امتحان کنید."
          },
          tpl: {
               message: '<div class="dropify-message"><span class="fa fa-image fa-3x" /> <p>{{ default }}</p></div>',
               filename: '<p class="dropify-filename"><span class="fa fa-image fa-3x"></span> <span class="dropify-filename-inner"></span></p>',
          }
     });
     drEvent_file.on('dropify.beforeClear', function(event, element){
          $('#main_photo').val('');
          $('#avatar').val('');
     });
     var e = $("#input-file-events").dropify();
     e.on("dropify.beforeClear", function (e, r) {
          return confirm('آیا میخواید حذف کنید "' + r.file.name + '" ?')
     }), e.on("dropify.afterClear", function (e, r) {
          alert("عکس حذف شد")
     }), e.on("dropify.errors", function (e, r) {
          console.log("ارور ها:")
     });
     var r = $("#input-file-to-destroy").dropify();
     r = r.data("dropify"), $("#toggleDropify").on("click", function (e) {
          e.preventDefault(), r.isDropified() ? r.destroy() : r.init()
     })
});




// (function ($) {
//      'use strict';
//      $(".my-awesome-dropzone").dropzone({
//           url: "#"
//      });
// })(jQuery);

! function (i) {
     "use strict";
     var e = function () {};
     e.prototype.respChart = function (e, r, a, o) {
          var t = e.get(0).getContext("2d"),
              n = i(e).parent();

          function s() {
               e.attr("width", i(n).width());
               switch (r) {
                    case "Bar":
                         new Chart(t, {
                              type: "bar",
                              data: a,
                              options: o
                         });
                         break;
               }
          }
          i(window).resize(s), s()
     }, e.prototype.init = function () {

          this.respChart(i("#bar"), "Bar", {
               labels: ["12/8/98", "13/8/98", "14/8/98", "15/8/98", "16/8/98", "17/8/98", "18/8/98"],
               defaultFontFamily: "'IRANSans', sans-serif",
               datasets: [{
                    label: "بازدید ها",
                    backgroundColor: "rgba(68, 162, 210, 0.4)",
                    borderColor: "#44a2d2",
                    borderWidth: 2,
                    barPercentage: .3,
                    categoryPercentage: .5,
                    hoverBackgroundColor: "rgba(68, 162, 210, 0.7)",
                    hoverBorderColor: "#44a2d2",
                    data: [65, 59, 80, 81, 56, 55, 40, 20]
               }]
          }, {
               responsive: !0,
               scales: {
                    xAxes: [{
                         barPercentage: .8,
                         categoryPercentage: .4,
                         display: !0
                    }]
               }
          });

     }, i.ChartJs = new e, i.ChartJs.Constructor = e
}(window.jQuery),
    function (e) {
         "use strict";
         window.jQuery.ChartJs.init()
    }();