@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-3">
        @include('admin.includes.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">

            <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">profile pic</th>
      <th scope="col">Name</th>
      <th scope="col">Address</th>
      <th scope="col">Gender</th>
      <th scope="col">Email</th>
      <th scope="col">phone</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($customerData as $customerInfo)
    <tr id="customer_row_{{$customerInfo->user_id}}">
      <th scope="row">{{ $loop->index + 1}}</th>
      <td id="user_profile_pic_{{$customerInfo->user_id}}">
      @if($customerInfo->profile_pic)
          <img id="profile_img_{{$customerInfo->user_id}}" style="width:50px"  src="{{ asset('assets/images/'.$customerInfo->profile_pic)}}"/>
      @else
      
      <i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:55px;"></i>
      @endif
      </td>
      <td id="user_name_{{$customerInfo->user_id}}">{{$customerInfo->name}}</td>
      <td id="user_address_{{$customerInfo->user_id}}">{{$customerInfo->address}}</td>
      <td id="user_gender_{{$customerInfo->user_id}}">{{ ucwords($customerInfo->gender) }}</td>
      <td id="user_email_{{$customerInfo->user_id}}">{{$customerInfo->email}}</td>
      <td id="user_phone_{{$customerInfo->user_id}}">{{$customerInfo->phone}}</td>
      <td>
      <div class="dropdown show">
                <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Settings
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat" onclick="editCustomerReg('{{$customerInfo->user_id}}')"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i> Edit</a>
                    <a class="dropdown-item" href="#" onclick="deleteCustomer('{{$customerInfo->user_id}}')"><i class="fa fa-trash text-danger" aria-hidden="true"></i> Delete</a>

                   
                    
                </div>
                </div>
      </td>
    </tr>
    @endforeach
    
  </tbody>
</table>
                

               
            </div>
        </div>
    </div>
</div>

<!-- model box start-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="customer_details">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateCustomerReg()" >Update Profile</button>
      </div>
    </div>
  </div>
</div>
<!-- model box end-->
@push('custom-scripts')
<script>
    function deleteCustomer(id){
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {

            $.ajax({
                type: "POST",
                url: '{{ route('admin.customerDelete')}}',
                data: {'cust_id':id,'_token':'{{ csrf_token()}}'},
                dataType: 'json',                                     
                
                success: function(data){
                    $('#customer_row_'+id).remove();
                    swal("Poof! Your data has been deleted!", {
                      icon: "success",
                    });
                
                }
            });


           

          } else {
            swal("Your data is safe!");
          }
        });

    }


    function editCustomerReg(id){
       
       $.ajax({
           type: "POST",
           url: '{{ route('edit.customer')}}',
           data: {'cust_id':id,'_token':'{{ csrf_token()}}'},
           dataType: 'html',                                     
           
           success: function(data){
               $('#customer_details').html(data);
           
           }
       });

}

function updateCustomerReg(){
   event.preventDefault();     
   var form = document.getElementById('customer_edit');
   var formData = new FormData(form);
       $.ajax({
           type: "POST",
           url: '{{ route('update.customer')}}',
           data: formData,
           dataType: 'json',                                      
           processData: false,
           contentType: false,
           success: function(data){                   
               if(data.success === false){

                   showValidationErrors(data.errors);

               }else
               {
               $('#customer_edit').trigger("reset");
               $('.err_clear').html("");
               $('#exampleModal').modal('hide');
               updateProfileData(data.userinfo);
              
           
               }
               
           }
       });
}

  function showValidationErrors(errors){
    if(errors.name){
        $('#name_error').html(errors.name);
    }else{
        $('#name_error').html(''); 
    }

  }

  function updateProfileData(userinfo){
        $('#user_name_'+userinfo.user_id).html(userinfo.name);
        $('#user_email_'+userinfo.user_id).html(userinfo.email);
        $('#user_address_'+userinfo.user_id).html(userinfo.address);
        $('#user_phone_'+userinfo.user_id).html(userinfo.phone);
        $('#user_gender_'+userinfo.user_id).html(userinfo.gender); 
        $("#user_profile_pic_"+userinfo.user_id).html();      
        $("#user_profile_pic_"+userinfo.user_id).html(`
            <img style="width:50px"  src="/assets/images/${userinfo.profile_pic}"/>
        `);
       
       
    }
</script>
@endpush
@endsection
