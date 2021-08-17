<!-- Footer -->
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Made with enthusiasm by <b>Kominfo</b>-<b>Ekraf</b> <i class="fas fa-copyright"></i> BEM PKN STAN 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.md5.min.js') ?>" type="text/javascript" charset="utf-8"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js') ?>"></script>

    <script src="<?= base_url('assets/js/demo/datatables-demo.js') ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/js/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('assets/js/demo/chart-pie-demo.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- ckeditor -->
    <script src="//cdn.ckeditor.com/4.16.2/basic/ckeditor.js"></script>
    <script src="<?= base_url() ?>/assets/js/adapters/jquery.js"></script>
    
    <script>
        function filePreview() {
            const customFile = document.querySelector('#customFile');
            const fileLabel = document.querySelector('.custom-file-label');

            if (customFile.files.length == 3) {
                fileLabel.textContent = customFile.files[0].name+';'+customFile.files[1].name+';'+customFile.files[2].name;
            }
            if (customFile.files.length == 2) {
                fileLabel.textContent = customFile.files[0].name+';'+customFile.files[1].name;
            }
            if (customFile.files.length == 1) {
                fileLabel.textContent = customFile.files[0].name;
            }
        }

        function convertToSlug(Text)
        {
            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        }
        
        $(document).ready(function () {
            $('textarea[id*=Desc]').ckeditor();
            $('textarea[id*=desc]').ckeditor();

            $('#dataTable-product').DataTable();

            $('#title').keyup(function() {
                $('#title_hash').val($.MD5($('#title').val() + '<?= user()->id . date("d/m/Y H:i:s") ?>'));
            });

            $('#name').keyup(function() {
                $('#slug').val(convertToSlug($('#name').val()));
            });

            $('.js-basic-single').select2();

            $('.js-basic-multiple').select2();
            
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
                if ($(this).val() != null && $(this).substring(0, 7) !== 'http://'){
                    $(this).val('http://' + $(this).val());
                }
            });

            
            $('input[id*=title-]').change(function(){
                let helper = $(this).attr('id');
                helper = helper.split('-');
                if(confirm('apa anda yakin akan mengubah judul produk ini?')){    
                    $.ajax({
                        url: "<?= base_url() ?>/panel/ajaxUpdateHelper",
                        headers: {'X-Requested-With': 'XMLHttpRequest'},
                        data: {idp: helper[1], title: $(this).val()},
                        dataType:'json',
                        success:function(){
                            alert('Berhasil');
                        }
                    });
                    $('#oldTitle-'+helper[1]).val($(this).val());
                    $('#colTitle-'+helper[1]).text($(this).val());
                } else {
                    $(this).val($('#oldTitle-'+helper[1]).val());
                }
            });

            $('input[id*=price-]').change(function(){
                let helper = $(this).attr('id');
                helper = helper.split('-');
                if(confirm('apa anda yakin akan mengubah harga produk ini?')){    
                    $.ajax({
                        url: "<?= base_url() ?>/panel/ajaxUpdateHelper",
                        headers: {'X-Requested-With': 'XMLHttpRequest'},
                        data: {idp: helper[1], price: $(this).val()},
                        dataType:'json',
                        success:function(){
                            alert('Berhasil');
                        }
                    });
                    $('#oldPrc').val($(this).val());
                    $('#colPrc-'+helper[1]).text($(this).val());
                } else {
                    $(this).val($('#oldPrc-'+helper[1]).val());
                }
            });

            $('select[id*=curCategory]').change(function(){
                let helper = $(this).attr('id');
                helper = helper.split('-');
                if(confirm('apa anda yakin akan mengubah kategori produk ini?')){    
                    $.ajax({
                        url: "<?= base_url() ?>/panel/ajaxUpdateHelper",
                        headers: {'X-Requested-With': 'XMLHttpRequest'},
                        data: {idp: helper[1], cur_category: $(this).val()},
                        dataType:'json',
                        success:function(){
                            alert('Berhasil');
                        }  
                    });
                    $('#oldCat-'+helper[1]).val($(this).val());
                    $('#colCat-'+helper[1]).text($('#curCategory-'+helper[1]+' option:selected').text());
                } else {
                    $(this).val($('#oldCat-'+helper[1]).val());
                }
            });

            $('button[id*=tmblSave-]').click(function(){
                let helper = $(this).attr('id');
                helper = helper.split('-');
                if(confirm('apa anda yakin akan mengubah deskripsi produk ini?')){    
                    $.ajax({
                        url: "<?= base_url() ?>/panel/ajaxUpdateHelper",
                        headers: {'X-Requested-With': 'XMLHttpRequest'},
                        data: {idp: helper[1], desc: $('#newDesc-'+helper[1]).val()},
                        dataType:'json',
                        success:function(){
                            alert('Berhasil');
                        }  
                    });

                    $('#oldDesc-'+helper[1]).val($('#newDesc-'+helper[1]).val());
                } else {
                    $('#newDesc-'+helper[1]).val($('#oldDesc-'+helper[1]).val());
                }
            });

            $('#save-update').click(function(){
                let idp = $('input[name=idp-d]').val();
                let newDesc = $('#new-description').val();

                $.ajax({
                    url: "<?= base_url() ?>/panel/ajaxUpdateHelper",
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    data: {idp: idp, desc: newDesc},
                    dataType:'json',
                    success:function(){
                        alert('Berhasil');
                    }  
                });

                $('#old-desc-' + idp).val($('#new-description').val());
            });

            $('select[id*=curStock-]').change(function(){
                let helper = $(this).attr('id');
                helper = helper.split('-');
                if(confirm('apa anda yakin akan mengubah status produk ini?')){    
                    $.ajax({
                        url: "<?= base_url() ?>/panel/ajaxUpdateHelper",
                        headers: {'X-Requested-With': 'XMLHttpRequest'},
                        data: {idp: helper[1], in_stock: $(this).val()},
                        dataType:'json',
                        success:function(){
                            alert('Berhasil');
                        }  
                    });
                    $('#oldStk'+helper[1]).val($(this).val());
                    $('#colStk-'+helper[1]).text($('#curStock-'+helper[1]+' option:selected').text());
                } else {
                    $(this).val($('#oldStk'+helper[1]).val());
                }
            });

        });

        
    </script>
</body>

</html>