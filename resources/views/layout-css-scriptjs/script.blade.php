<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<script src="{{ asset('demo10/assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('demo10/assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('demo10/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="{{ asset('demo10/assets/plugins/custom/gmaps/gmaps.js')}}" type="text/javascript"></script>
<script src="{{asset('demo10/assets/js/pages/dashboard.js')}}" type="text/javascript"></script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script src="{{ asset('demo10/assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    $('.datepicker').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        format: "dd/mm/yyyy",
        autoclose: true,
    });
    $('.select2').select2({
        placeholder: "Select a choose"
     });
</script>
@if(session('success'))
<div id="success-title">
    {{ session('success') }}
</div>
<script>
    var success =$('#success-title').html();
    Swal.fire({
        position: 'center',
        type: 'success',
        title:success,
        showConfirmButton: false,
        timer: 2000,
    });
  </script>
@endif
@if(session('warning'))
<div id="warning-title">
    {{ session('warning') }}
</div>
<script>
    var warning = $('#warning-title').html();
    Swal.fire({
        position: 'center',
        type: 'warning',
        title:warning,
        showConfirmButton: false,
        timer: 2000,
    });
</script>
@endif
@if(session('danger'))
<div id="danger-title">
    {{ session('danger') }}
</div>
<script>
    var danger = $('#danger-title').html();
    Swal.fire({
        position: 'center',
        type: 'error',
        title:danger,
        showConfirmButton: false,
        timer: 2000,
    });
</script>
@endif
