@extends('layout-admin.base', [
    'pages' => 'Setting Attemdance',
    'subpages' => 'Setting Attemdance',
])

@push('css')
<style>
    .btn:focus, .btn.focus {
        outline: 0;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
</style>            
@endpush
@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Settings Location</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('location.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                    <i class="la la-plus"></i>
                    Add Location
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="mb-5">
                        <h5 class="text-dark">BULK UPDATE LOCATION SETTING</h5>
                        <div class="dropzone dropzone-multi kt_dropzone_4">
                            <div class="d-flex my-3">
                                <a href="{{ asset('public\download\format-employee.xlsx')}}" target="_blank" class="btn btn-outline-secondary btn-sm" id="ExportAssignEmployee">Export Template</a>
                                <div class="dropzone-panel">
                                    <a href="javascript:void(0);" class="dropzone-select px-5 btn ml-3 btn btn-outline-secondary btn-sm" >Import</a>
                                </div>
                            </div>
                            <div class="dropzone-items">
                                <div class="dropzone-item" style="display:none">
                                    <div class="dropzone-file">
                                        <div class="dropzone-filename" title="some_image_file_name.jpg">
                                            <span data-dz-name>some_image_file_name.jpg</span> <strong>(<span  data-dz-size>340kb</span>)</strong>
                                        </div>
                                        <div class="dropzone-error" data-dz-errormessage></div>
                                    </div>
                                    <div class="dropzone-progress">
                                        <div class="progress">
                                            <div class="progress-bar kt-bg-brand" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                                        </div>
                                    </div>
                                    <div class="dropzone-toolbar">
                                        <span class="dropzone-delete" data-dz-remove><i class="flaticon2-cross"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-dark">BULK ASSIGN EMPLOYEE</h5>
                        <div class="dropzone dropzone-multi kt_dropzone_5">
                            <div class="d-flex my-3">
                                <a href="{{ asset('public\download\format-employee.xlsx')}}" target="_blank" class="btn btn-outline-secondary btn-sm" id="ExportAssignEmployee">Export Template</a>
                                <div class="dropzone-panel">
                                    <a href="javascript:void(0);" class="dropzone-select px-5 btn ml-3 btn btn-outline-secondary btn-sm" >Import</a>
                                </div>
                            </div>
                            <div class="dropzone-items">
                                <div class="dropzone-item" style="display:none">
                                    <div class="dropzone-file">
                                        <div class="dropzone-filename" title="some_image_file_name.jpg">
                                            <span data-dz-name>some_image_file_name.jpg</span> <strong>(<span  data-dz-size>340kb</span>)</strong>
                                        </div>
                                        <div class="dropzone-error" data-dz-errormessage></div>
                                    </div>
                                    <div class="dropzone-progress">
                                        <div class="progress">
                                            <div class="progress-bar kt-bg-brand" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                                        </div>
                                    </div>
                                    <div class="dropzone-toolbar">
                                        <span class="dropzone-delete" data-dz-remove><i class="flaticon2-cross"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!--begin: Datatable -->
                    <table class="table table-sm table-striped- table-bordered table-hover table-checkable kt_table_11 mt-0">
                        <thead>
                            <tr>
                                <th>GPS Location</th>
                                <th>Assign to</th>
                                <th>Radius</th>
                                <th>Coordinat</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>WFH</td>
                                <td>0 Employee(s)</td>
                                <td>200m</td>
                                <td>-8.6659946, 115.2161178</td>
                                <td>
                                    <a target="_blank" href="https://www.google.com/maps?q=-8.6659946, 115.2161178" class="kt-link kt-font-bold">Preview</a>
                                </td>
                                <td>
                                    <a href="{{route('location.edit')}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                        <i class="la flaticon-edit"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean ml-3 btn-icon btn-icon-md" title="Delete">
                                        <i class="la flaticon-delete text-danger" data-toggle="modal" data-target="#kt_modal_1"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>WFO</td>
                                <td>32 Employee(s)</td>
                                <td>200m</td>
                                <td>-8.6659946, 115.2161178</td>
                                <td>
                                    <a target="_blank" href="https://www.google.com/maps?q=-8.6659946, 115.2161178" class="kt-link kt-font-bold">Preview</a>
                                </td>
                                <td>
                                    <a href="{{route('location.edit')}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                        <i class="la flaticon-edit"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean ml-3 btn-icon btn-icon-md" title="Delete">
                                        <i class="la flaticon-delete text-danger" data-toggle="modal" data-target="#kt_modal_1"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>WFO</td>
                                <td>12 Employee(s)</td>
                                <td>200m</td>
                                <td>-8.6659946, 115.2161178</td>
                                <td>
                                    <a target="_blank" href="https://www.google.com/maps?q=-8.6659946, 115.2161178" class="kt-link kt-font-bold">Preview</a>
                                </td>
                                <td>
                                    <a href="{{route('location.edit')}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                        <i class="la flaticon-edit"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-clean ml-3 btn-icon btn-icon-md" title="Delete">
                                        <i class="la flaticon-delete text-danger" data-toggle="modal" data-target="#kt_modal_1"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

    <!--begin::Modal Delete -->
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Warning !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text">Are you sure detele this Location ? Coordinat -8.6659946, 115.2161178</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scriptjs')
<script>
    var demo1 = function () {
        // set the dropzone container id
        var id = '.kt_dropzone_4';
        // set the preview element template
        var previewNode = $(id + " .dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parent('.dropzone-items').html();
        previewNode.remove();
        var myDropzone5 = new Dropzone(id, { // Make the whole body a dropzone
            url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
            parallelUploads: 20,
            maxFilesize: 1, // Max filesize in MB
            previewTemplate: previewTemplate,
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
        });
        myDropzone5.on("addedfile", function(file) {
            // Hookup the start button
            $(document).find( id + ' .dropzone-item').css('display', '');
        });
        // Update the total progress bar
        myDropzone5.on("totaluploadprogress", function(progress) {
            $( id + " .progress-bar").css('width', progress + "%");
        });
        myDropzone5.on("sending", function(file) {
            // Show the total progress bar when upload starts
            $( id + " .progress-bar").css('opacity', "1");
        });
        // Hide the total progress bar when nothing's uploading anymore
        myDropzone5.on("complete", function(progress) {
            var thisProgressBar = id + " .dz-complete";
            setTimeout(function(){
                $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").css('opacity', '0');
            }, 300)
        });
    }();
    var demo2 = function () {
        // set the dropzone container id
        var id = '.kt_dropzone_5';
        // set the preview element template
        var previewNode = $(id + " .dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parent('.dropzone-items').html();
        previewNode.remove();
        var myDropzone5 = new Dropzone(id, { // Make the whole body a dropzone
            url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
            parallelUploads: 20,
            maxFilesize: 1, // Max filesize in MB
            previewTemplate: previewTemplate,
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
        });
        myDropzone5.on("addedfile", function(file) {
            // Hookup the start button
            $(document).find( id + ' .dropzone-item').css('display', '');
        });
        // Update the total progress bar
        myDropzone5.on("totaluploadprogress", function(progress) {
            $( id + " .progress-bar").css('width', progress + "%");
        });
        myDropzone5.on("sending", function(file) {
            // Show the total progress bar when upload starts
            $( id + " .progress-bar").css('opacity', "1");
        });
        // Hide the total progress bar when nothing's uploading anymore
        myDropzone5.on("complete", function(progress) {
            var thisProgressBar = id + " .dz-complete";
            setTimeout(function(){
                $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").css('opacity', '0');
            }, 300)
        });
    }()
    var initTable1 = function () {
        var table = $(".kt_table_11");
        // begin first table
        table.DataTable({
            responsive: true,
            lengthMenu: [10, 25, 50],
            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
            },
            autoWidth: true,
            // Order settings
            order: [[1, "asc"]],
        });
    }();
</script>
@endpush
