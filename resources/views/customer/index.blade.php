@extends('layouts.master')
@section('content')
    <div id="items" class="container">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#customerModal">add<span
            class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        {{-- @include('layouts.flash-messages') --}}
        {{-- <a class="btn btn-primary" href="{{ route('items.create') }}" role="button">add</a> --}}
        {{-- <form method="POST" enctype="multipart/form-data" action="{{ route('item-import') }}">
            {{ csrf_field() }}
            <input type="file" id="uploadName" name="item_upload" required>
            <button type="submit" class="btn btn-info btn-primary ">Import Excel File</button>

        </form> --}}
        <div class="card-body" style="height: 210px;">
            <input type="text" id='itemSearch' placeholder="--search--">
        </div>
        <div class="table-responsive">
            <table id="ctable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Customer/User ID</th>
                        <th>Image</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Phone Number</th>
                        <!-- <th>Zipcode</th> -->
                        <th>Address</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="cbody"></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="customerModal" role="dialog" style="display:none">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create New Customer</h4>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="cform" method="#" action="#" enctype="multipart/form-data">

                  <div class="form-group">
                      <label for="user_id" class="control-label">Customer/User ID</label>
                      <input type="text" class="form-control" id="user_id" name="user_id" readonly>
                    </div>

                <div class="form-group">
                  <label for="last_name" class="control-label">Last Name</label>
                  <input type="text" class="form-control " id="last_name" name="last_name">
                </div>
                <div class="form-group">
                  <label for="first_name" class="control-label">First Name</label>
                  <input type="text" class="form-control " id="first_name" name="first_name">
                </div>
                <div class="form-group">
                  <label for="address" class="control-label">Address</label>
                  <input type="text" class="form-control " id="address" name="address">
                </div>

                <!-- <div class="form-group">
                  <label for="zip_code" class="control-label">Zipcode</label>
                  <input type="text" class="form-control " id="zip_code" name="zip_code">
                </div> -->
                <div class="form-group">
                  <label for="phone_number" class="control-label">Phone Number</label>
                  <input type="text" class="form-control " id="phone_number" name="phone_number">
                </div>
                <div class="form-group">
                  <label for="email" class="control-label">Email</label>
                  <input type="text" class="form-control " id="email" name="email">
                </div>
                <div class="form-group">
                  <label for="pass" class="control-label">Password</label>
                  <input type="password" class="form-control " id="pass" name="password">
                </div>
                <div class="form-group">
                  <label for="image" class="control-label">Image</label>
                  <input type="file" class="form-control" id="image_upload" name="uploads" />
                </div>
              </form>
            </div>
            <div class="modal-footer" id="footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button id="customerSubmit" type="submit" class="btn btn-primary">Save</button>
              <button id="customerUpdate" type="submit" class="btn btn-primary">update</button>
            </div>

          </div>
        </div>
      </div>
@endsection
