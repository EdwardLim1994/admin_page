$(document).ready(function () {

    listUsers();

    $("#PasswordVisible").click(function () {
        toggleVisiblePassword("#PasswordVisible", "#registerPassword");
    });
    $("#ConfirmPasswordVisible").click(function () {
        toggleVisiblePassword("#ConfirmPasswordVisible", "#passwordConfirm");
    });

    $("#editPasswordVisible").click(function () {
        toggleVisiblePassword("#editPasswordVisible", "#editPassword");
    });
    $("#editConfirmPasswordVisible").click(function () {
        toggleVisiblePassword("#editConfirmPasswordVisible", "#editPasswordConfirm");
    });

    var registerPasswordMatch = false;


    $("#passwordConfirm, #registerPassword").on("input focusout", function () {
        var password = $("#registerPassword").val();
        var confirm = $("#passwordConfirm").val();
        if (password != confirm) {
            notValidInput("#passwordConfirm", "#passwordConfirmValidate", "Password is not matched");
            registerPasswordMatch = false;
        } else if (password == "") {
            notValidInput("#passwordConfirm", "#passwordConfirmValidate", "Password is empty");
            registerPasswordMatch = false;
        } else {
            validInput("#passwordConfirm", "#passwordConfirmValidate");
            registerPasswordMatch = true;
        }
    });

    var editPasswordMatch = true;
    useOldPassword("#editPasswordConfirm", "#editPasswordConfirmValidate");
    useOldPassword("#editPassword", "#editPasswordValidate");
    $("#editPasswordConfirm, #editPassword").on("input focusout", function () {
        var password = $("#editPassword").val();
        var confirm = $("#editPasswordConfirm").val();

        if (password != "" && confirm != "") {
            if (password != confirm) {
                notValidInput("#editPasswordConfirm", "#editPasswordConfirmValidate", "Password is not matched");
                editPasswordMatch = false;
            } else {
                validInput("#editPasswordConfirm", "#editPasswordConfirmValidate");
                editPasswordMatch = true;
            }
        } else if (password == "" && confirm != "") {
            notValidInput("#editPasswordConfirm", "#editPasswordConfirmValidate", "Password is empty");
            editPasswordMatch = false;

        } else if (confirm == "" && password != "") {
            notValidInput("#editPasswordConfirm", "#editPasswordConfirmValidate", "Confirm Password is empty");
            editPasswordMatch = false;
        } else {

            useOldPassword("#editPasswordConfirm", "#editPasswordConfirmValidate");
            useOldPassword("#editPassword", "#editPasswordValidate");
            editPasswordMatch = true;
        }


        // if (password == "" && confirm == "") {
        //     editPasswordMatch = true;
        // }
    });

    $(".nevermind").click(function () {
        $(".form-control").val("");
    });

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $(".list-group-item-action").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $("#addUserSubmitBtn").click(function () {
        var username = $("#registerUsername").val();
        var password = $("#registerPassword").val();
        var role = $("#registerRole").val();
        var email = $("#registerEmail").val();
        var contact = $("#registerContact").val();
        var status = $("#registerStatus").val();

        if (password != "" && username != "" && email != "" && contact != "") {
            if (registerPasswordMatch) {
                $.ajax({
                    type: "POST",
                    url: "./backend/login/userOperation.php",
                    data: {
                        postType: "add",
                        username: username,
                        role: role,
                        email: email,
                        contact_num: contact,
                        password: password,
                        status: status
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
                        switch (results) {
                            case ("Success"):
                                $('#userTable').dataTable({
                                    "bDestroy": true
                                });
                                listUsers();
                                $("#addModal").modal("hide");
                                $("#registerUsername").val("");
                                $("#registerPassword").val("");
                                $("#passwordConfirm").val("");
                                $("#registerEmail").val("");
                                $("#registerContact").val("");
                                $("#passwordConfirm").removeClass("is-valid");
                                $("#passwordConfirmValidate").removeClass("valid-feedback").empty();
                                $("#successModalHeadline").empty().append("New User Added");
                                $("#successModalBody").empty().append("A New User is successfully added.");
                                $('#successToModal').modal('show');
                                break;
                            case ("Username Already Existed"):
                                $("#failedModalHeadline").empty().append("Failed to Add User");
                                $("#failedModalBody").empty().append("Username have been used already");
                                $('#failedToModal').modal('show');
                                break;
                        }
                    },
                    error: function () {
                        $("#addModal").modal("hide");
                        $("#failedModalHeadline").empty().append("Failed to Add User");
                        $("#failedModalBody").empty().append("Add New User Process Failed.");
                        $('#failedToModal').modal('show');
                    }
                });
            } else {
                $("#failedModalHeadline").empty().append("Failed to Add User");
                $("#failedModalBody").empty().append("Your password is not matched with Confirm Password");
                $('#failedToModal').modal('show');
            }
        } else {
            $("#failedModalHeadline").empty().append("Failed to Add User");
            $("#failedModalBody").empty().append("Please fill up all the required fields");
            $('#failedToModal').modal('show');
        }
    });

    $("#editeUserSubmitButton").click(function () {
        var username = $("#editUsername").val();
        var password = $("#editPassword").val();
        var email = $("#editEmail").val();
        var contact_num = $("#editContact").val();
        var confirm = $("#editPasswordConfirm").val();
        var login = $("#editLoginAttempt").val();
        var role = $("#editRole").val();
        var status = $("#editStatus").val();

        if (username != "" && email != "" && contact_num != "") {
            if (editPasswordMatch) {
                $.ajax({
                    type: "POST",
                    url: "./backend/login/userOperation.php",
                    data: {
                        postType: "update",
                        username: username,
                        role: role,
                        email: email,
                        contact_num: contact_num,
                        login_attempt: login,
                        password: password,
                        status: status
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
                        if (results == "Success") {
                            $('#userTable').dataTable({
                                "bDestroy": true
                            });
                            listUsers();
                            $("#editModal").modal("hide");
                            $("#editPassword").val("");
                            $("#editPasswordConfirm").val("");
                            $("#editEmail").val("");
                            $("#editContact").val("");
                            $("#editPasswordConfirm").removeClass("is-valid");
                            $("#editPasswordConfirmValidate").removeClass("valid-feedback").empty();
                            $("#successModalHeadline").empty().append("Updated" + username);
                            $("#successModalBody").empty().append(username + "\'s data has been updated");
                            $('#successToModal').modal('show');
                        } else {
                            console.log("no change");
                        }
                    },
                    error: function () {
                        $("#editPassword").val("");
                        $("#editPasswordConfirm").val("");
                        $("#failedModalHeadline").empty().append("Failed to update" + username);
                        $("#failedModalBody").empty().append("Update " + username + "\'s data failed");
                        $('#failedToModal').modal('show');
                    }
                });
            } else {

                if (password == "" && confirm == "") {
                    $("#failedModalHeadline").empty().append("Failed to update" + username);
                    $("#failedModalBody").empty().append("Either to fill in both password and confirm password for changing password, or let both password and confirm password blank for not changing password");
                    $('#failedToModal').modal('show');
                } else if (password == "" || confirm == "") {
                    $("#failedModalHeadline").empty().append("Failed to update" + username);
                    $("#failedModalBody").empty().append("Either to fill in both password and confirm password for changing password, or let both password and confirm password blank for not changing password");
                    $('#failedToModal').modal('show');
                } else {
                    $("#failedModalHeadline").empty().append("Failed to update" + username);
                    $("#failedModalBody").empty().append("Password is not matched with Confirm Password.");
                    $('#failedToModal').modal('show');
                }
            }
        } else {
            $("#failedModalHeadline").empty().append("Failed to Add User");
            $("#failedModalBody").empty().append("Please fill up all the required fields");
            $('#failedToModal').modal('show');
        }
    });

    $("#deleteUserSubmitButton").click(function () {
        var username = $("#deleteUserName").text();
        $.ajax({
            type: "POST",
            url: "./backend/login/userOperation.php",
            data: {
                postType: "delete",
                username: username,
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
                switch (results) {
                    case ("Success"):
                        $('#userTable').dataTable({
                            "bDestroy": true
                        });
                        listUsers();
                        $("#deleteModal").modal("hide");
                        $("#successModalHeadline").empty().append(username + " Deleted");
                        $("#successModalBody").empty().append(username + " has been deleted");
                        $('#successToModal').modal('show');
                        break;
                };
            },
            error: function () {
                $("#deleteModal").modal("hide");
                $("#failedModalHeadline").empty().append(username + " Deleted failed");
                $("#failedModalBody").empty().append("Failed to delete " + username);
                $('#failedToModal').modal('show');
            }
        })
    });

    function listUsers() {
        $.ajax({
            type: "POST",
            url: "./backend/login/userOperation.php",
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
                            '<table id="userTable" class="table table-hover table-bordered text-center " cellspacing="0" width="100%"> ' +
                            ' <thead class="grey lighten-2"> ' +
                            ' <tr> ' +
                            ' <th scope="col">#</th> ' +
                            ' <th scope="col" class="th-lg">Username</th> ' +
                            ' <th scope="col">User Role</th> ' +
                            ' <th scope="col">Contact No</th> ' +
                            ' <th scope="col">Email</th> ' +
                            ' <th scope="col">Login Attempt</th> ' +
                            ' <th scope="col">Status</th> ' +
                            ' <th scope="col" class="text-center th-lg">Action</th> ' +
                            ' </tr> ' +
                            ' </thead> ' +
                            ' <tbody id="content"> ' +
                            ' </tbody> ' +
                            ' <tfoot class="grey lighten-2"> ' +
                            ' <tr> ' +
                            ' <th scope="col">#</th> ' +
                            ' <th scope="col" class="th-lg">Username</th> ' +
                            ' <th scope="col">User Role</th> ' +
                            ' <th scope="col">Contact No</th> ' +
                            ' <th scope="col">Email</th> ' +
                            ' <th scope="col">Login Attempt</th> ' +
                            ' <th scope="col">Status</th> ' +
                            ' <th scope="col" class="text-center th-lg">Action</th> ' +
                            ' </tr> ' +
                            ' </tfoot> ' +
                            ' </table>'
                        );

                        $.each(results, function (i, item) {
                            i++;
                            $("#content").append(
                                "<tr>" +
                                ' <th scope="row">' + i + "</th>" +
                                "<td id='username-" + i + "'>" + item.username + ' </td>' +
                                ' <td id="role-' + i + '"> ' + item.role + ' </td>' +
                                ' <td id="contactno-' + i + '"> ' + item.contact_num + ' </td>' +
                                ' <td id="email-' + i + '"> ' + item.email + ' </td>' +
                                ' <td id="login-' + i + '"> ' + item.login_attempt + ' </td>' +
                                ' <td id="status-' + i + '"> ' + item.status + ' </td>' +
                                ' <td>' +
                                ' <button id="edit-' + i + '" class="btn btn-info editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                                ' <span class="textBreak">Edit</span>' +
                                ' <span class="iconBreak"><i class="fas fa-user-edit"></i></span>' +
                                ' </button>' +
                                ' <button id="delete-' + i + '" class="btn btn-warning deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                                ' <span class="textBreak">Delete</span>' +
                                ' <span class="iconBreak"><i class="fas fa-user-minus"></i></span>' +
                                ' </button>' +
                                ' </td>' +
                                '  </tr>'
                            );
                        });

                        $('#userTable').dataTable({
                            "paging": true,
                            "scrollX": true,
                            "scrollY": '800px',
                            "scrollCollapse": true,
                            "lengthMenu": [
                                [-1, 50, 25, 10],
                                ["All", 50, 25, 10]
                            ]
                        });

                        $('.dataTables_length').addClass('bs-select');
                        $(".editBtn").click(function () {

                            var current_index_edit = $(this).attr('id');
                            var current_index = current_index_edit.split('-');

                            $("#editUsername").val($("#username-" + current_index[1]).text().trim());
                            $("#editLoginAttempt").val($("#login-" + current_index[1]).text().trim());
                            $("#editRole").val($("#role-" + current_index[1]).text().trim());
                            $("#editEmail").val($("#email-" + current_index[1]).text().trim());
                            $("#editContact").val($("#contactno-" + current_index[1]).text().trim());
                            $("#editStatus").val($("#status-" + current_index[1]).text().trim() == "" ? "active" : $("#status-" + current_index[1]).text().trim());
                        });

                        $(".deleteBtn").click(function () {
                            var current_index_edit = $(this).attr('id');
                            var current_index = current_index_edit.split('-');
                            $("#deleteUserName").text($("#username-" + current_index[1]).text().trim());
                        });
                    }
                }
            },
            error: function () {
                console.log("Failed");
            }
        });
    }

    // //Toggle Visible Password Functions
    // function toggleVisiblePassword(toggleID, inputID) {
    //     if ($(inputID).attr("type") === "password") {
    //         $(inputID).attr("type", "text");
    //         $(toggleID + " .fas").removeClass("fa-eye").addClass("fa-eye-slash");
    //     } else {
    //         $(inputID).attr("type", "password");
    //         $(toggleID + " .fas").removeClass("fa-eye-slash").addClass("fa-eye");
    //     }
    // }

    // //Not Valid Input function
    // function notValidInput(inputID, validateID, text) {
    //     $(inputID).removeClass("is-valid").addClass("is-invalid");
    //     $(validateID).removeClass("valid-feedback").addClass("invalid-feedback").empty().html(text);
    // }

    // //Valid Input function
    // function validInput(inputID, validateID) {
    //     $(inputID).removeClass("is-invalid").addClass("is-valid");
    //     $(validateID).removeClass("invalid-feedback").addClass("valid-feedback").empty().html("Looks good!");
    // }

});