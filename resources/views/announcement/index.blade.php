@extends('layouts.master')
@section('content')
<div id="announcements" class="container">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#announcementModal">Add <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
    <div class="card-body" style="height: 210px;">
        <input type="text" id='announcementSearch' placeholder="--search--">
    </div>
    <div class="table-responsive">
        <table id="announcementTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Announcement ID</th>
                    <th>Title</th>
                    <th>Date of Arrival</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="announcementBody">
            </tbody>
        </table>
    </div>
</div>

<div id="announcements" class="container">
    <div class="card-body">
        <form action="{{ url('announcements/import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <input type="file" name="importFile" class="form-control" />
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </div>

<div class="modal fade" id="announcementModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Announcement</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="announcementForm" method="#" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" class="form-control" id="title_id" name="title">
                    </div>

                    <div class="form-group">
                        <label for="date_of_arrival" class="control-label">Date of Arrival</label>
                        <input type="date" class="form-control" id="date_of_arrival_id" name="date_of_arrival">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <input type = "hidden" id = "announcementId">
                        <textarea class="form-control" id="description_id" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Image</label>
                        <input type="file" class="form-control" id="image" name="uploads[]" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="announcementSubmit" type="submit" class="btn btn-primary">Save</button>
                <button id="announcementUpdate" type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
   
</div>
@endsection
