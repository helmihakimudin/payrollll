<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Slipgaji Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body">
   <form action="{{route('slipgaji.detail.karyawan.update',$payslips->id)}}" method="POST" id="form-slip-edit" >
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="">Announcement By Email</label>
       <textarea name="" class="form-control" cols="30" rows="10" value="Berikut Slip Gaji A.n  jika terdapat nilai tidak sesuai. harap segera hubungi hrd. Terimakasih">
     
       </textarea>
   </div>
       
   </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="form-slip-edit" class="btn btn-primary">Update</button>
</div>