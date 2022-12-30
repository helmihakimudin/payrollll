
<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body">
                <h3 class="kt-portlet__head-title user-hello">
                    Good Afternoon <small>{{" ".Auth::user()->name}}</small>
                </h3>
                <label class="font-11px">it's Friday, 10 june</label>
                <div class="row shortcut-header">
                    <div class="col-lg-8 navigation-menu-custom">
                        <label>Shortcut</label>
                        <div class="form-group row">
                            <a href="#" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill mb-3 w-22">
                                Request Reimbursment
                            </a>
                            <a href="#" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill  mb-3 w-24">
                                Request Time Off
                            </a>
                            <a href="#" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill  mb-3 w-24">
                                Request Time Off
                            </a>
                            <a href="#" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill  mb-3 w-24">
                                Request Over Time
                            </a>
                            <a href="#" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10 rounded-pill  mb-3 w-23">
                                Request More
                            </a>
                        </div>
                    </div>  
                    <div class="col-lg-4 image-trim">
                        @if($gender->gender == 'Male')
                        <img src="{{asset('logo/boy_working-1.png')}}" class="img-fluid position-absolute img-avatar-boy">
                        @elseif($gender->gender == 'Female') 
                        <img src="{{asset('logo/girl_working-1.png')}}" class="img-fluid position-absolute img-avatar-girl">
                        @endif
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>