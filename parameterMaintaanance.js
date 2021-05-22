$(document).ready(function () {

    listParameter();
    screenWidthAdjustment();
    $("#addQuantity, #addAmount").val("");
    //presetEndDateAndEndTime();

    $(".nevermind").click(function(){
        $("#editFilename, #addFilename, #cloneFilename").val("").next('label').html('Select a file');
        $("#editFilePreview, #addFilePreview, #cloneFilePreview").attr("src", "");
        $(".form-control").val("");
    });

    $("#addStartDateReset").click(function(){
        $("#addStartDate").val("");
    });
    $("#addEndDateReset").click(function(){
        $("#addEndDate").val("");
    });
    $("#addStartTimeReset").click(function(){
        $("#addStartTime").val("");
    });
    $("#addEndTimeReset").click(function(){
        $("#addEndTime").val("");
    });

    $("#editStartDateReset").click(function(){
        $("#editStartDate").val("");
    });
    $("#editEndDateReset").click(function(){
        $("#editEndDate").val("");
    });
    $("#editStartTimeReset").click(function(){
        $("#editStartTime").val("");
    });
    $("#editEndTimeReset").click(function(){
        $("#editEndTime").val("");
    });

    $("#cloneStartDateReset").click(function(){
        $("#cloneStartDate").val("");
    });
    $("#cloneEndDateReset").click(function(){
        $("#cloneEndDate").val("");
    });
    $("#cloneStartTimeReset").click(function(){
        $("#cloneStartTime").val("");
    });
    $("#cloneEndTimeReset").click(function(){
        $("#cloneEndTime").val("");
    });


    $("#addFilename").change(function () {
        readURL(this, "#addFilePreview");
    });

    $("#editFilename").change(function () {
        readURL(this, "#editFilePreview");
    });

    $("#cloneFilename").change(function () {
        readURL(this, "#cloneFilePreview");
    });
    
    function readURL(input, previewID) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(previewID).attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);

        }
    }

    // function clearInput() {
    //     $("#editFilename, #addFilename, #cloneFilename").val("").next('label').html('Select a file');
    //     $("#editFilePreview, #addFilePreview, #cloneFilePreview").attr("src", "");
    //     $(".form-control").val("");
    //     //presetEndDateAndEndTime();
    // }

    function screenWidthAdjustment() {
        var screen = $(window).width();
        if (screen <= 576) {
            $("#report-table").removeClass("text-nowrap");
        } else {
            $("#report-table").addClass("text-nowrap");
        }
    }

    function listParameter() {

        $.ajax({
            type: "POST",
            url: "./backend/parameter/parameter.php",
            data: {
                postType: "view"
            },
            beforeLoad: function () {
                $("#report-table").append(
                    '<div class="d-flex justify-content-center">' +
                    '<div class="spinner-border" role="status">' +
                    '<span class="sr-only">Loading...</span>' +
                    '</div>' +
                    '</div>'
                );
            },
            success: function (results) {

                if (results) {
                    if (results != "0 results") {
                        results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);

                        $("#report-table").empty();
                        $("#report-table").append(
                            '<table id="userTable" class="table table-hover table-bordered text-center w-auto" cellspacing="0" width="100%"> ' +
                            ' <thead class="grey lighten-2  "> ' +
                            ' <th scope="col">#</th> ' +
                            ' <th scope="col" class="text-center th-lg">Action</th> ' +
                            //' <th scope="col" class="th-sm" class="th-lg">Image</th> ' +
                            ' <th scope="col" class="th-lg">Type</th> ' +
                            ' <th scope="col" class="th-sm">Description</th> ' +
                            ' <th scope="col" class="th-sm">Description 2</th> ' +
                            ' <th scope="col" class="th-sm">Description 3</th> ' +
                            ' <th scope="col" class="th-sm">Quantity</th> ' +
                            ' <th scope="col" class="th-sm">Amount</th> ' +
                            ' <th scope="col" class="th-sm">Start Date</th> ' +
                            ' <th scope="col" class="th-sm">End Date</th> ' +
                            ' <th scope="col" class="th-sm">Start Time</th> ' +
                            ' <th scope="col" class="th-sm">End Time</th> ' +

                            ' </tr> ' +
                            ' </thead> ' +
                            ' <tbody id="content"> ' +
                            ' </tbody> ' +
                            ' <tfoot class="grey lighten-2"> ' +
                            ' <tr> ' +
                            ' <th scope="col">#</th> ' +
                            //' <th scope="col" class="th-sm" class="th-lg">Image</th> ' +
                            ' <th scope="col" class="text-center th-lg">Action</th> ' +
                            ' <th scope="col" class="th-lg">Type</th> ' +
                            ' <th scope="col" class="th-sm">Description</th> ' +
                            ' <th scope="col" class="th-sm">Description 2</th> ' +
                            ' <th scope="col" class="th-sm">Description 3</th> ' +
                            ' <th scope="col" class="th-sm">Quantity</th> ' +
                            ' <th scope="col" class="th-sm">Amount</th> ' +
                            ' <th scope="col" class="th-sm">Start Date</th> ' +
                            ' <th scope="col" class="th-sm">End Date</th> ' +
                            ' <th scope="col" class="th-sm">Start Time</th> ' +
                            ' <th scope="col" class="th-sm">End Time</th> ' +

                            ' </tr> ' +
                            ' </tfoot> ' +
                            ' </table>'
                        );

                        $.each(results, function (i, item) {
                            i++;

                            var startTime = new Date(item.start_date + " " + item.start_time);
                            var endTime = new Date(item.end_date + " " + item.end_time);
                            $("#content").append(
                                "<tr>" +
                                ' <th scope="row" id="parameterID-' + item.parameter_id + '">' + i +"</th>" +
                                ' <td>' +
                                ' <button id="edit-' + item.parameter_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                                ' <span class="textBreak">Edit</span>' +
                                ' <span class="iconBreak"><i class="fas fa-edit"></i></i></span>' +
                                ' </button>' +
                                ' <button id="delete-' + item.parameter_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                                ' <span class="textBreak">Delete</span>' +
                                ' <span class="iconBreak"><i class="fas fa-trash-alt"></i></span>' +
                                ' </button>' +
                                ' <button id="clone-' + item.parameter_id + '" class="btn btn-secondary cloneBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#cloneModal">' +
                                ' <span class="textBreak">Clone</span>' +
                                ' <span class="iconBreak"><i class="fas fa-copy"></i></span>' +
                                ' </button>' +
                                ' </td>' +
                                //' <th scope="row" id="parameterID-' + item.parameter_id + '">' + i + "<img class='img-preview' id='image-" + item.parameter_id + "' hidden='true' src='./backend/parameter/upload/" + item.para_image + "' alt='" + (item.para_image ? item.para_image : "No Image") + "'/>" + "</th>" +
                                //" <td id='image-" + item.parameter_id + "'><img id='image-" + item.parameter_id + "' hidden='true' src='./backend/parameter/upload/" + item.para_image + "' alt='" + (item.para_image ? item.para_image : "No Image") + "'/></td>" +
                                " <td id='type-" + item.parameter_id + "'>" + item.para_code + ' </td>' +
                                ' <td id="description-' + item.parameter_id + '"> ' + item.para_description + ' </td>' +
                                ' <td id="description2-' + item.parameter_id + '"> ' + item.para_description2 + ' </td>' +
                                ' <td id="description3-' + item.parameter_id + '"> ' + item.para_description3 + ' </td>' +
                                ' <td id="quantity-' + item.parameter_id + '"> ' + (item.quantity == "0" ? "" : item.quantity) + ' </td>' +
                                ' <td id="amount-' + item.parameter_id + '"> ' + (item.amount == "0.00" ? "" : item.amount) + ' </td>' +
                                ' <td id="startdate-' + item.parameter_id + '"> ' + (item.start_date == "0000-00-00" ? "" : item.start_date) + ' </td>' +
                                ' <td id="enddate-' + item.parameter_id + '"> ' + (item.end_date == "0000-00-00" ? "" : item.end_date) + ' </td>' +
                                ' <td> ' + (item.start_time == "00:00:00" ? "" : startTime.toLocaleTimeString(navigator.language, {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })) + '<span id="starttime-' + item.parameter_id + '" hidden="true">' + item.start_time + '</span></td>' +
                                ' <td> ' + (item.end_time == "00:00:00" ? "" : endTime.toLocaleTimeString(navigator.language, {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })) + '<span id="endtime-' + item.parameter_id + '" hidden="true">' + item.end_time + '</span></td>' +

                                ' </tr>'
                            );
                        });

                        var table = $('#userTable').DataTable({
                            "paging": true,
                            "scrollX": true,
                            "scrollY": '1000px',
                            "scrollCollapse": true,
                            "lengthMenu": [
                                [-1, 50, 25, 10],
                                ["All", 50, 25, 10]
                            ]
                        });

                        $('.dataTables_length').addClass('bs-select');

                        $('a.toggle-vis').on( 'click', function (e) {
                            e.preventDefault();
                            var column = table.column( $(this).attr('data-column') );
                            column.visible( ! column.visible() );


                            if(!column.visible() == true){
                                $(this).addClass("cyan lighten-4");
                            }else{
                                $(this).removeClass("cyan lighten-4");
                            }
                        } );

                        $(".editBtn").click(function () {

                            console.log($("#editFilename").val());

                            var current_index_edit = $(this).attr('id');
                            var current_index = current_index_edit.split('-');
                            $("#editParameterIDHeader").empty().text(current_index[1]);
                            $("#editParameterID").val(current_index[1]);
                            //$("#editFilePreview").attr("src", $("#image-" + current_index[1]).attr("src"));
                            $("#editType").val($("#type-" + current_index[1]).text().trim());
                            $("#editDescription").val($("#description-" + current_index[1]).text().trim());
                            $("#editDescription2").val($("#description2-" + current_index[1]).text().trim());
                            $("#editDescription3").val($("#description3-" + current_index[1]).text().trim());
                            $("#editStartDate").val($("#startdate-" + current_index[1]).text().trim());
                            $("#editEndDate").val($("#enddate-" + current_index[1]).text().trim());
                            $("#editStartTime").val($("#starttime-" + current_index[1]).text().trim());
                            $("#editEndTime").val($("#endtime-" + current_index[1]).text().trim());
                            $("#editQuantity").val($("#quantity-" + current_index[1]).text().trim());
                            $("#editAmount").val($("#amount-" + current_index[1]).text().trim());

                        });

                        $(".cloneBtn").click(function () {
                            var current_index_clone = $(this).attr('id');
                            var current_index = current_index_clone.split('-');

                            $("#cloneType").val($("#type-" + current_index[1]).text().trim());
                            $("#cloneParameterIDHeader").text(current_index[1]);
                        });

                        $(".deleteBtn").click(function () {

                            var current_index_delete = $(this).attr('id');
                            var current_index = current_index_delete.split('-');

                            $("#deleteParameter").val(current_index[1]);
                            $("#deleteParameterIDHeader").empty().text(current_index[1]);
                            $("#deleteParameterID").val(current_index[1]);
                            //$("#editFilePreview").attr("src", $("#image-" + current_index[1]).attr("src"));
                            $("#deleteType").val($("#type-" + current_index[1]).text().trim());
                            $("#deleteDescription").val($("#description-" + current_index[1]).text().trim());
                            $("#deleteDescription2").val($("#description2-" + current_index[1]).text().trim());
                            $("#deleteDescription3").val($("#description3-" + current_index[1]).text().trim());
                            $("#deleteStartDate").val($("#startdate-" + current_index[1]).text().trim());
                            $("#deleteEndDate").val($("#enddate-" + current_index[1]).text().trim());
                            $("#deleteStartTime").val($("#starttime-" + current_index[1]).text().trim());
                            $("#deleteEndTime").val($("#endtime-" + current_index[1]).text().trim());
                            $("#deleteQuantity").val($("#quantity-" + current_index[1]).text().trim());
                            $("#deleteAmount").val($("#amount-" + current_index[1]).text().trim());

                        });
                    } else {
                        $("#report-table").empty();
                        $("#report-table").append(
                            '<table id="userTable" class="table table-hover table-bordered text-center w-auto" cellspacing="0" width="100%"> ' +
                            ' <thead class="grey lighten-2  "> ' +
                            ' <th scope="col">#</th> ' +
                            //' <th scope="col" class="th-sm" class="th-lg">Image</th> ' +
                            ' <th scope="col" class="th-lg">Type</th> ' +
                            ' <th scope="col" class="th-lg">Description</th> ' +
                            ' <th scope="col" class="th-sm">Quantity</th> ' +
                            ' <th scope="col" class="th-sm">Amount</th> ' +
                            ' <th scope="col" class="th-sm">Start Date</th> ' +
                            ' <th scope="col" class="th-sm">End Date</th> ' +
                            ' <th scope="col" class="th-sm">Start Time</th> ' +
                            ' <th scope="col" class="th-sm">End Time</th> ' +
                            ' <th scope="col" class="text-center th-lg">Action</th> ' +
                            ' </tr> ' +
                            ' </thead> ' +
                            ' <tbody id="content"> ' +
                            ' </tbody> ' +
                            ' <tfoot class="grey lighten-2"> ' +
                            ' <tr> ' +
                            ' <th scope="col">#</th> ' +
                            //' <th scope="col" class="th-sm" class="th-lg">Image</th> ' +
                            ' <th scope="col" class="th-lg">Type</th> ' +
                            ' <th scope="col" class="th-lg">Description</th> ' +
                            ' <th scope="col" class="th-sm">Quantity</th> ' +
                            ' <th scope="col" class="th-sm">Amount</th> ' +
                            ' <th scope="col" class="th-sm">Start Date</th> ' +
                            ' <th scope="col" class="th-sm">End Date</th> ' +
                            ' <th scope="col" class="th-sm">Start Time</th> ' +
                            ' <th scope="col" class="th-sm">End Time</th> ' +
                            ' <th scope="col" class="text-center th-lg">Action</th> ' +
                            ' </tr> ' +
                            ' </tfoot> ' +
                            ' </table>'
                        );

                        $('#userTable').DataTable({
                            // "paging": true,
                            // "scrollX": true,
                            // "scrollY": '800px',
                            // "scrollCollapse": true,
                            // "lengthMenu": [
                            //     [-1, 50, 25, 10],
                            //     ["All", 50, 25, 10]
                            // ]
                        });

                        $('.dataTables_length').addClass('bs-select');
                    }
                }
            },
            error: function () {
                console.log("Failed");
            }
        });
    }
})