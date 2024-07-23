@extends('layouts.master')
@section('content')
<div id="brands" class="container">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#brandModal">Add <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
    <div class="card-body" style="height: 210px;">
        <input type="text" id='brandSearch' placeholder="--search--">
    </div>
    <div class="table-responsive">
        <table id="brandtable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Brand ID</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Website</th>
                    <th>Description</th>
                    <th>Logo</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="brandbody">
            </tbody>
        </table>
    </div>
</div>

<div id="brands" class="container">
    <div class="card-body">
        <form action="{{ url('brands/import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <input type="file" name="importFile" class="form-control" />
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </div>

<div class="modal fade" id="brandModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Brand</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="brandform" method="#" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="control-label">Brand Name</label>
                        <input type="text" class="form-control" id="name_id" name="name">
                    </div>
                    <div class="form-group">
                        <label for="company" class="control-label">Company</label>
                        <input type="text" class="form-control" id="company_id" name="company">
                    </div>
                    <div class="form-group">
                        <label for="website" class="control-label">Website</label>
                        <input type="text" class="form-control" id="website_id" name="website">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <input type="text" class="form-control" id="description_id" name="description">
                    </div>
                    <div class="form-group">
                      <label for="image" class="control-label">Logo</label>
                      <input type="file" class="form-control" id="image" name="uploads[]" multiple>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <input type="text" class="form-control" id="status_id" name="status">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="brandSubmit" type="submit" class="btn btn-primary">Save</button>
                <button id="brandUpdate" type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection
