<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Component !</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-6">
            <div class="kt-searchbar">
                <label for="">Search </label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                        </g>
                    </svg></span></div>
                    <input type="text" class="form-control" name="searchemployee" id="search"  placeholder="Search" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="kt-widget kt-widget--users kt-mt-20">
                <label class="kt-checkbox">
                    <input type="checkbox" name="select-all" class="select-all"> Select All
                    <span></span>
                </label>
                <div style="height: 315px; overflow-y:scroll;">
                    <form action="{{route('payroll.component.edit.catch.component',$id)}}" method="POST" id="form-component">
                        @csrf
                        <div class="kt-widget__items" id="component">
                        
                        </div>
                    </form>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 615px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 300px;"></div></div></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="kt-widget kt-widget--users kt-mt-20">
                <div style="height: 315px; overflow-y:scroll;">
                    <div class="kt-widget__items" id="component-items">
                    
                    </div>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 615px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 300px;"></div></div></div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="form-component" class="btn btn-primary">Save</button>
</div>