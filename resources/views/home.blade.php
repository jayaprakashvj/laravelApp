@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile 
               
                <a href="#" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat"><i class="fa fa-pencil-square-o float-right" aria-hidden="true" style="font-size:25px" onclick="editCustomerReg('{{$customerData->user_id}}')" ></i></a>
                
                 </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif

                    <table class="table table-bordered">
                   
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center" id="user_profile_pic">
                            @if($customerData->profile_pic)
                                <img id="profile_img" style="width:50px"  src="{{ asset('assets/images/'.$customerData->profile_pic)}}"/>
                            @else
                            
                            <i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:55px;"></i>
                            @endif
                            </td>
                        </tr>
                        <tr>                       
                            <td>name</td>
                            <td id="user_nane">{{$customerData->name}}</td>
                        </tr>
                        <tr>                       
                            <td>Email</td>
                            <td id="user_email">{{$customerData->email}}</td>
                        </tr>
                        <tr>                       
                            <td>Address</td>
                            <td id="user_address">{{$customerData->address}}</td>
                        </tr>
                        <tr>                       
                            <td>Phone</td>
                            <td id="user_phone">{{$customerData->phone}}</td>
                        </tr>
                        <tr>                       
                            <td>Gender</td>
                            <td id="user_gender">{{ ucwords($customerData->gender) }}</td>
                        </tr>
                     
                    </tbody>
                    </table>
                </div>
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
        $('#user_nane').html(userinfo.name);
        $('#user_email').html(userinfo.email);
        $('#user_address').html(userinfo.address);
        $('#user_phone').html(userinfo.phone);
        $('#user_gender').html(userinfo.gender);       
        $("#user_profile_pic").html(`
            <img style="width:50px"  src="/assets/images/${userinfo.profile_pic}"/>
        `);
        $("#profile_img").attr("src","assets/images/"+userinfo.profile_pic);
    }


</script>
    
@endpush
@endsection
