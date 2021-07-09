    <footer class="sticky-footer bg-white">
        <hr>
        <div class="container py-2">
            <div class="row">
                <div class="col">
                    <b>Kritik dan Saran</b><br>
                    <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&to=" class="text-gray-500"><i class="fas fa-at"></i>&nbsp; email</a><br>
                    <a href="https://www.instagram.com/bebeb_aw/" class="text-gray-500"><i class="fab fa-instagram"></i>&nbsp; ig</a>
                </div>
                <div class="col">
                    <b>Staco</b><br>
                    asdas deskripsinya ini
                </div>
            </div>
        </div>
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © Biro PTI Kominfo BEM PKN STAN 2020</span>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/jquery.md5.min.js') ?>" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>

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

        $(window).on('load', function(){
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
        
        $(document).ready(function () {
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