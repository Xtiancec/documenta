<!-- Bootstrap tether Core JavaScript -->
<script src="../app/template/plugins/bootstrap/js/popper.min.js"></script>
<script src="../app/template/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="../app/template/js/perfect-scrollbar.jquery.min.js"></script>


<!--Wave Effects -->
<script src="../app/template/js/waves.js"></script>
<!--Menu sidebar -->
<script src="../app/template/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="../app/template/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="../app/template/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Custom JavaScript -->
<script src="../app/template/js/custom.min.js"></script>

<!-- Dropify (File Upload) -->
<script src="../app/template/plugins/dropify/dist/js/dropify.min.js"></script>

<!-- Jasny Bootstrap -->
<script src="../app/template/js/jasny-bootstrap.js"></script>

<!-- Tablesaw -->
<script src="../app/template/plugins/tablesaw-master/dist/tablesaw.js"></script>

<!-- Toastify -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<script src="../app/template/plugins/select2/dist/js/select2.full.min.js"></script>

<!-- Bootstrap Select -->
<script src="../app/template/plugins/bootstrap-select/bootstrap-select.min.js"></script>

<!-- Moment.js -->
<script src="../app/template/plugins/moment/moment.js"></script>

<!-- Bootstrap Material Datetimepicker -->
<script src="../app/template/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Clockpicker -->
<script src="../app/template/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>

<!-- Color Picker -->
<script src="../app/template/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="../app/template/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="../app/template/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>





<!-- Bootstrap Datepicker -->
<script src="../app/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<!-- Timepicker -->
<script src="../app/template/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<!-- Daterangepicker -->
<script src="../app/template/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Chartist -->
<script src="../app/template/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="../app/template/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>

<!-- D3.js -->
<script src="../app/template/plugins/d3/d3.min.js"></script>

<!-- C3.js -->
<script src="../app/template/plugins/c3-master/c3.min.js"></script>

<!-- ECharts -->
<script src="../app/template/plugins/echarts/echarts-all.js"></script>

<!-- Bootstrap Switch -->
<script src="../app/template/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>

<!-- iCheck -->
<script src="../app/template/plugins/icheck/icheck.min.js"></script>

<!-- Easy Pie Chart -->
<script src="../app/template/plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="../app/template/plugins/jquery.easy-pie-chart/easy-pie-chart.init.js"></script>

<!--c3 JavaScript -->

<!-- Switch Buttons -->
<script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState");
            });
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck");
            });
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", false);
            });
        };
        return {
            init: function() {
                bt();
            }
        };
    }();
    $(document).ready(function() {
        radioswitch.init();
    });
</script>

<!-- Print Area -->
<script src="../app/template/js/jquery.PrintArea.js"></script>
<script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>

<!-- DataTables and Buttons -->
<script src="../app/template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<!-- Style Switcher -->
<script src="../app/template/plugins/styleswitcher/jQuery.style.switcher.js"></script>

</body>

</html>