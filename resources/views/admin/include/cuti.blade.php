<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
        <div class="kt-widget kt-widget--user-profile-3">
            <div class="kt-widget__content">
                <div class="form-group">
                    <div class="kt-todo__title">
                        <span class="h5">Cuti Tahunan Balance</span><br>
                        <span class="kt-todo__text h3 black pt-5">7 Hari</span>
                        <div class="kt-todo__labels pt-3">
                            <a href="{{route('employee.account.overtime', $employee['id'])}}" class="kt-todo__text ">Request Cuti Tahunan</a>
                        </div>
                    </div>
                </div>
                <div class="kt-todo__title">
                    <span class="h5">Cuti Dengan Surat Dokter</span><br>
                    <span class="kt-todo__text h3 black pt-3">0 Hari</span>
                    <div class="kt-todo__labels pt-3">
                        <a href="{{route('employee.account.overtime', $employee['id'])}}" class="kt-todo__text">Request Sakit dengan izin Dokter</a>
                    </div>
                </div>
            </div>
            <div class="kt-widget__bottom ">
                <div class="kt-widget__item right">
                    <a href="{{route('employee.account.overtime', $employee['id'])}}" class="kt-todo__text">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>