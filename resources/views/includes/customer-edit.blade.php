<form enctype="multipart/form-data" method="post" id="customer_edit">
@csrf
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $customerData->name}}">
            <span class="text-danger err_clear" id="name_error"></span>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email" disabled value="{{ $customerData->email}}">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $customerData->phone}}">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Gender:</label>
            <select class="form-control" name="gender">
                <option value="male" <?= ($customerData->gender=='male'?'selected':'')?>>Male</option>
                <option value="female" <?= ($customerData->gender=='female'?'selected':'')?>>Female</option>
                <option value="other" <?= ($customerData->gender=='other'?'selected':'')?>>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Address:</label>
            <textarea class="form-control" id="address" name="address">{{ $customerData->address}}</textarea>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">profile image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <input type="hidden" value="{{$customerData->user_id}}" name="user_id" id="user_id"/>
          </div>
        </form>