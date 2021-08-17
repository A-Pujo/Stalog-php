    <div class="modal fade" id="modal-opening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Halo peeps!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body p-4">
                <p>Sebelum mulai menggunakan Lapak Staner, pastikan kamu sudah membaca dokumen <a href="https://drive.google.com/file/d/17EXc7H8Wcpzvgrk_GyFogPTQfSMdvHZ2/view?usp=sharing" class="text-link" target="_blank">syarat dan ketentuan</a> terlebih dahulu yaa!.</p>
                <p>Untuk tutorial silahkan lihat video di bawah ini.</p>
                <p><b>Untuk Penjual:</b></p>
                <div class="iframe-container">
                    <!--<img class="ratio" src="http://placehold.it/16x9"/>-->
                    <iframe src="https://www.youtube.com/embed/Wy8cHVlV-1k?rel=0" allow="fullscreen;"></iframe>
                </div> <br>
                <p><b>Untuk Pembeli:</b></p>
                <div class="iframe-container">
                    <!--<img class="ratio" src="http://placehold.it/16x9"/>-->
                    <iframe src="https://www.youtube.com/embed/hR7o_WvGx7s?rel=0" allow="fullscreen;"></iframe>
                </div>
              </div>
            </div>
        </div>
    </div>
    
    <footer class="sticky-footer bg-white">
        <hr>
        <div class="container py-2">
            <div class="row">
                <div class="col mb-3">
                    <b>Tetap dalam Jangkauan</b><br>
                    <i class="far fa-envelope"></i> <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&to=ekraf.bempknstan@gmail.com" class="text-gray-500" target="_blank">ekraf.bempknstan@gmail.com</a><br>
                    <i class="fab fa-whatsapp"></i> <a href="https://wa.me/6285212414851" class="text-gray-500" target="_blank">Admin 1</a><br>
                    <i class="fab fa-whatsapp"></i> <a href="https://wa.me/6283195187670" class="text-gray-500" target="_blank">Admin 2</a><br>
                    <i class="fab fa-whatsapp"></i> <a href="https://wa.me/6285783374231" class="text-gray-500" target="_blank">Admin 3</a><br>
                </div>
                <div class="col mb-3">
                    <b>Lapak Staner - Everything you need</b><br>
                    <p>Lapak Staner adalah platform pertama di PKN STAN yang berfungsi untuk menghubungkan antara penjual dan pembeli secara daring tanpa biaya apapun. Bergabunglah dengan mulai mendaftarkan produk jualan dan berbelanja kapan saja, di mana saja.</p>
                </div>
            </div>
        </div>
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Made with enthusiasm by <b>Kominfo</b>-<b>Ekraf</b> <i class="fas fa-copyright"></i> BEM PKN STAN 2021</span>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/jquery.md5.min.js') ?>" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <!-- ckeditor -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>
        function filePreview_1() {
            const customFile_1 = document.querySelector('#customFile-1');
            const fileLabel_1 = document.querySelector('#customFile-1-label');

            fileLabel_1.textContent = customFile_1.files[0].name;
        }

        function filePreview_2() {
            const customFile_2 = document.querySelector('#customFile-2');
            const fileLabel_2 = document.querySelector('#customFile-2-label');

            fileLabel_2.textContent = customFile_2.files[0].name;
        }

        function convertToSlug(Text)
        {
            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        }
        
        CKEDITOR.replace('store_desc');
        
        // $(window).on('load', function(){
        //     // Animate loader off screen
        //     $(".se-pre-con").fadeOut("slow");;
        // });
        
        $(document).ready(function () {
            $('textarea[id*=Desc]').ckeditor();
            $('textarea[id*=desc]').ckeditor();
            
            // whatsapp input number corrector
            $('input[id*=_whatsapp]').change(function() {
                let val_wa = $(this).val();
                if (val_wa[0] == '0') {
                    val_wa = '62' + val_wa.substring(1);
                    $(this).val(val_wa);
                }
            });
            
            // ig input corrector 
            $('#social_instagram').change(function() {
                let val_ig = $(this).val();
                if (val_ig[0] == '@') {
                    val_ig = val_ig.substring(1);
                    $(this).val(val_ig);
                }
            });
            
            // ext link input corrector
            $('#ext_link').change(function() {
                let val_ext = $(this).val();
                if (val_ext != '' && val_ext.substring(0, 7) !== 'http://'){
                    $(this).val('http://' + val_ext);
                }
            });
            
            if (document.cookie.indexOf('modal_shown=') >= 0) {
             //do nothing if modal_shown cookie is present
            } else {
              $('#modal-opening').modal('show');  //show modal pop up
              document.cookie = 'modal_shown=seen'; //set cookie modal_shown
              //cookie will expire when browser is closed
            }
            
            $('#modal-opening').click(function(e){
                e.preventDefault();
                console.log($(this).hasClass('show'));
                $('.iframe-container iframe').each(function(){
                    $(this).attr("src", $(this).attr("src"));
                });
            });
            
            $('#title').keyup(function() {
                $('#title_hash').val($.MD5($('#title').val()));
            });

            $('#name').keyup(function() {
                $('#slug').val(convertToSlug($('#name').val()));
            });

            // select2
            $('.js-example-basic-single').select2();
        });
    </script>
</body>
</html>