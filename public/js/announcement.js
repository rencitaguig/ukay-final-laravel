$(document).ready(function () {
    var table = $('#announcementTable').DataTable({
        ajax: {
            url: "/api/announcements",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Announcement',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#announcementForm").trigger("reset");
                    $('#announcementModal').modal('show');
                    $('#announcementUpdate').hide();
                    $('#announcementSubmit').show();
                    $('#announcementImages').html('');
                }
            }
        ],
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'title', title: 'Title' },
            { data: 'date_of_arrival', title: 'Date of Arrival' },
            { data: 'description', title: 'Description' },
            {
                data: 'logo',
                title: 'Image',
                render: function (data, type, row) {
                    var imgPaths = data ? data.split(',') : [];
                    var imagesHTML = '';
                    imgPaths.forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" width="50" height="60" style="margin-right: 5px;">`;
                        }
                    });
                    return imagesHTML;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function (data, type, row) {
                    return `<a href='#' class='editBtn' data-id="${data.id}"><i class='fas fa-edit' style='font-size:24px'></i></a>
                            <a href='#' class='deleteBtn' data-id="${data.id}"><i class='fas fa-trash-alt' style='font-size:24px; color:red'></i></a>`;
                }
            }
        ]
    });

    // Handle Add Announcement form submission
    $("#announcementSubmit").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#announcementForm')[0]);
        $.ajax({
            type: "POST",
            url: "/api/announcements",
            data: data,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (response) {
                $("#announcementModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Handle Edit Announcement button click
    $('#announcementTable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!id) {
            console.error("Invalid ID:", id);
            return;
        }
        $('#announcementModal').modal('show');
        $('#announcementSubmit').hide();
        $('#announcementUpdate').show();

        $.ajax({
            type: "GET",
            url: `/api/announcements/${id}`,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#announcementForm').trigger("reset");
                $('#announcementId').val(data.id);
                $('#title_id').val(data.title);
                $('#date_of_arrival_id').val(data.date_of_arrival);
                $('#description_id').val(data.description);

                var imagesHTML = '';
                if (data.logo) {
                    data.logo.split(',').forEach(function (path) {
                        if (path.endsWith('.jpg') || path.endsWith('.jpeg') || path.endsWith('.png')) {
                            imagesHTML += `<img src="${path}" width='200px' height='200px'>`;
                        }
                    });
                }
                $("#announcementImages").html(imagesHTML);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Handle Update Announcement form submission
    $("#announcementUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#announcementId').val();
        if (!id) {
            console.error("Invalid ID:", id);
            return;
        }
        var data = new FormData($('#announcementForm')[0]);
        data.append("_method", "PUT");
        $.ajax({
            type: "POST",
            url: `/api/announcements/${id}`,
            data: data,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (response) {
                $('#announcementModal').modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

        // Handle Delete Announcement button click
        $('#announcementTable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        bootbox.confirm({
            message: "Do you want to delete this announcement?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: `/api/announcements/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            table.row($row).remove().draw();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    });
});
