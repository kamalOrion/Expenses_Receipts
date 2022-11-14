    <div class="footer">
        <div>
            <strong>Copyright</strong> INOVACT &copy; 2022
        </div>
    </div>

    <div id="dialog-confirm">
        <p class='text-center'><b><span id='confirm_message_container'></span></b></p>
    </div>

    <!-- Toast notifications -->
    <div style="position: absolute; top: 20px; right: 70px;">
        <div id='toast_container' class="toast toast-bootstrap" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa fa-newspaper-o"> </i>
                <strong class="mr-auto m-l-sm">Notification</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id='toast_message_container' class="toast-body"></div>
        </div>
    </div>

</div>





<!-- Modal corfimations -->
<!-- <div class="modal inmodal fade" id="confirm_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn m-top">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title m-0"><i class='fa fa-question-circle'></i> Confirmation</h5>
            </div>
            <div class="modal-body text-center">
                <div id='confirm_message_container' class="toast-body"></div>
                <div>
                    <button id='confirm_action' class='btn btn-danger btn-xs'><i class="fa fa-times-circle"></i> Non</button>
                    <button id='denied_action' class='btn btn-primary btn-sm m-l-lg'><i class="fa fa-check"></i> Oui</button>
                </div>
            </div>
        </div>
    </div>
</div> -->



<!-- Mainly scripts -->
<script src="<?= base_url('assets/');?>js/jquery-3.1.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?= base_url('assets/');?>js/popper.min.js"></script>
<script src="<?= base_url('assets/');?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="<?= base_url('assets/');?>js/plugins/flot/jquery.flot.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/flot/jquery.flot.spline.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/flot/jquery.flot.resize.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="<?= base_url('assets/');?>js/plugins/peity/jquery.peity.min.js"></script>
<script src="<?= base_url('assets/');?>js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url('assets/');?>js/inspinia.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="<?= base_url('assets/');?>js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="<?= base_url('assets/');?>js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="<?= base_url('assets/');?>js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="<?= base_url('assets/');?>js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="<?= base_url('assets/');?>js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url('assets/');?>js/plugins/toastr/toastr.min.js"></script>

<!-- Data picker -->
<script src="<?= base_url('assets/');?>js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Dual Listbox -->
<script src="<?= base_url('assets/');?>js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>

<!-- Datatable -->
<script src="<?= base_url('assets/');?>js/plugins/dataTables/datatables.min.js"></script>
<script src="<?= base_url('assets/');?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.colVis.min.js"></script>
<!-- DataTable Responsive -->
<!-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> -->

<!-- Touch Punch - Touch Event Support for jQuery UI -->
<script src="<?= base_url('assets/');?>js/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>

<!-- Validate js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- My_custom_js -->
<script src="<?= base_url('assets/');?>js/custom/general_init.js"></script>
<script src="<?= base_url('assets/');?>js/custom/dashbord_bar_chart.js"></script>
<script src="<?= base_url('assets/');?>js/custom/datatable_init.js"></script>
<script src="<?= base_url('assets/');?>js/custom/form_rules.js"></script>
<script src="<?= base_url('assets/');?>js/custom/user.js"></script>
<script src="<?= base_url('assets/');?>js/custom/structure.js"></script>
<script src="<?= base_url('assets/');?>js/custom/groupe.js"></script>
<script src="<?= base_url('assets/');?>js/custom/profil.js"></script>
<script src="<?= base_url('assets/');?>js/custom/type_depense.js"></script>
<script src="<?= base_url('assets/');?>js/custom/produit.js"></script>
<script src="<?= base_url('assets/');?>js/custom/depense.js"></script>
<script src="<?= base_url('assets/');?>js/custom/vente.js"></script>



</body>

</html>
