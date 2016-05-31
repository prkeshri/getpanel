<!-- ... -->
      <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
      <script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
      <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	<script type="text/javascript">
        $(function () {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
            });
            $('.timepicker').datetimepicker({
                format: 'HH:mm:ss',
            });
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $('.timestamppicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
            }).on('dp.change', function(e){
            	$(this).find('input').val(moment(e.date).unix());
            });
        });
    </script>