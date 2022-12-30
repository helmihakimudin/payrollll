
<style>
/* begin flash message */
.float-alert{
position: absolute;
top: 70px;
right: -270px;
width: 250px;
color: #fff;
padding: 10px 15px 10px 20px;
z-index: 99;
border-radius: 10px;
transition: right .5s ease;
}
.float-alert i{
    font-size: 20px;
}
.float-alert span{
    font-size: 18px;
}
.float-alert.active{
    right: 10px;
     transition: right .5s ease;
}
/* end flash message */
</style>
@if(session()->has('success'))
<div class="bg-success float-alert">
	<i class="flaticon2-shield text-white"></i><span>&nbsp;Success</span>
	<p class="mt-2">{{session()->get('success')}}</p>
</div>
@endif
@if(session()->has('error'))
<div class="bg-danger float-alert">
	<i class="flaticon2-shield text-white"></i><span>&nbsp;Error</span>
	<p class="mt-2">{{session()->get('error')}}</p>
</div>
@endif

