$(document).ready(function () {
    var totalRow = countRow();
    var totalPage = paginate(totalRow);

    if ($("#searchRow").val()) {
        $("#search-input-wrapper").css("display", "block");
        $("#search-input").empty().append($("#searchRow").val());
        searchTable();
    } else {
        generateTable();
    }


    $("#searchConfirm").click(function () {
        searchTable($("#searchRow").val());
    })

    $("#searchClear").click(function () {
        generateTable();
        $("#searchRow").val("");
        $("#search-input-wrapper").css("display", "none");
    });

    $("#currentPageNum").focusout(function () {
        if($("#searchRow").val() != ""){
            searchTable();
        }else{
            generateTable();
        }
        
    });

    function failedMessage(headline, body) {
        $("#failedToModal").modal("show");
        $("#failedModalHeadline").empty().append(headline);
        $("#failedModalBody").empty().append(body);
    }

    function countRow(){

        var totalRowCount;

        $.ajax({
            type: "POST",
            url: "./backend/customer/customer.php",
            data: {
                postType: "countRow",
            },
            async: false,
            success: function(results){
                $("#rowTotal").empty().append(results);
                totalRowCount = results;
                
            }
        });

        return totalRowCount;
    }

    function searchRowCount(input){
        
        var totalRowSearch;

        $.ajax({
            type: "POST",
            url: "./backend/customer/customer.php",
            data: {
                postType: "searchRowCount",
                search: input
            },
            async: false,
            success: function(results){
                $("#rowTotal").empty().append(results);
                totalRowSearch = results;
                
            }
        });

        return totalRowSearch;
    }

    function paginate(total){
        var rowperpage = 20;
        var totalPage = Math.ceil(total/rowperpage);
        $("#pageTotal").empty().text(totalPage);

        if($("#currentPageNum").val() > totalPage){
            $("#currentPageNum").val(totalPage);
        }

        return totalPage;
    }

    function searchTable() {

        $("#search-input-wrapper").css("display", "block");
        $("#search-input").empty().append($("#searchRow").val());

        var input = $("#searchRow").val();
        var currentPageNum = $("#currentPageNum").val() > totalPage ? totalPage :  $("#currentPageNum").val();
        $("#currentPageNum").val(currentPageNum);
        $.ajax({
            type: "POST",
            url: "./backend/customer/customer.php",
            data: {
                postType: "searchRow",
                search: input,
                pageNum: currentPageNum
                
            },
            success: function (results) {
                
                paginate(searchRowCount(input));

                if (results == "No result") {

                    failedMessage("Failed", "No result match");
                    renderTable("general");
                    tableSetting("general");
                    renderTable("additionalinfo");
                    tableSetting("additionalinfo");
                    renderTable("accounting");
                    tableSetting("accounting");

                } else {
                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "general");
                    renderContent(results, "additionalinfo");
                    renderContent(results, "accounting");

                    $(".editBtn").on("click", function () {
                        $(".editBtn").on("click", function () {
                            var current_index_edit = $(this).attr("id");
                            var current_index = current_index_edit.split('-');
    
                            var customer_account = $("#customer_account-" + current_index[1]).text();
                            var name = $("#name-" + current_index[1]).text();
                            var reg_num = $("#reg_num-" + current_index[1]).text();
                            var outstanding = $("#outstanding-" + current_index[1]).text();
                            var points = $("#points-" + current_index[1]).text();
                            var status = $("#status-" + current_index[1]).text();
                            var address = $("#address-" + current_index[1]).text();
                            var postcode = $("#postcode-" + current_index[1]).text();
                            var state = $("#state-" + current_index[1]).text();
                            var salutation = $("#salutation-" + current_index[1]).text();
                            var email = $("#email-" + current_index[1]).text();
                            var website = $("#website-" + current_index[1]).text();
                            var biz_nature = $("#biz_nature-" + current_index[1]).text();
                            var salesperson = $("#salesperson-" + current_index[1]).text();
                            var category = $("#category-" + current_index[1]).text();
                            var city = $("#city-" + current_index[1]).text();
                            var country = $("#country-" + current_index[1]).text();
                            var attention = $("#attention-" + current_index[1]).text();
                            var introducer = $("#introducer-" + current_index[1]).text();
                            var reg_date = $("#reg_date-" + current_index[1]).text();
                            var expiry_date = $("#expiry_date-" + current_index[1]).text();
                            var telephone1 = $("#telephone1-" + current_index[1]).text();
                            var telephone2 = $("#telephone2-" + current_index[1]).text();
                            var fax = $("#fax-" + current_index[1]).text();
                            var handphone = $("#handphone-" + current_index[1]).text();
                            var skype = $("#skype-" + current_index[1]).text();
                            var nric = $("#nric-" + current_index[1]).text();
                            var gender = $("#gender-" + current_index[1]).text();
                            var dob = $("#dob-" + current_index[1]).text();
                            var race = $("#race-" + current_index[1]).text();
                            var religion = $("#religion-" + current_index[1]).text();
    
                            var info1 = $("#info1-" + current_index[1]).text();
                            var info2 = $("#info2-" + current_index[1]).text();
                            var info3 = $("#info3-" + current_index[1]).text();
                            var info4 = $("#info4-" + current_index[1]).text();
                            var info5 = $("#info5-" + current_index[1]).text();
                            var info6 = $("#info6-" + current_index[1]).text();
                            var info7 = $("#info7-" + current_index[1]).text();
                            var info8 = $("#info8-" + current_index[1]).text();
                            var info9 = $("#info9-" + current_index[1]).text();
                            var info10 = $("#info10-" + current_index[1]).text();
    
                            var control_ac = $("#control_ac-" + current_index[1]).text();
                            var accounting_account = $("#accounting_account-" + current_index[1]).text();
    
                            $("#edit-customer_account").val(customer_account);
                            $("#edit-name").val(name);
                            $("#edit-reg_num").val(reg_num);
                            $("#edit-outstanding").val(outstanding);
                            $("#edit-points").val(points);
                            $("#edit-status").val(status);
                            $("#edit-address").val(address);
                            $("#edit-postcode").val(postcode);
                            $("#edit-state").val(state);
                            $("#edit-salutation").val(salutation);
                            $("#edit-email").val(email);
                            $("#edit-website").val(website);
                            $("#edit-biz_nature").val(biz_nature);
                            $("#edit-salesperson").val(salesperson);
                            $("#edit-category").val(category);
                            $("#edit-city").val(city);
                            $("#edit-country").val(country);
                            $("#edit-attention").val(attention);
                            $("#edit-introducer").val(introducer);
                            $("#edit-reg_date").val(reg_date);
                            $("#edit-expiry_date").val(expiry_date);
                            $("#edit-telephone1").val(telephone1);
                            $("#edit-telephone2").val(telephone2);
                            $("#edit-fax").val(fax);
                            $("#edit-handphone").val(handphone);
                            $("#edit-skype").val(skype);
                            $("#edit-nric").val(nric);
                            $("#edit-gender").val(gender);
                            $("#edit-dob").val(dob);
                            $("#edit-race").val(race);
                            $("#edit-religion").val(religion);
    
                            $("#edit-info1").val(info1);
                            $("#edit-info2").val(info2);
                            $("#edit-info3").val(info3);
                            $("#edit-info4").val(info4);
                            $("#edit-info5").val(info5);
                            $("#edit-info6").val(info6);
                            $("#edit-info7").val(info7);
                            $("#edit-info8").val(info8);
                            $("#edit-info9").val(info9);
                            $("#edit-info10").val(info10);
    
                            $("#edit-control_ac").val(control_ac);
                            $("#edit-accounting_account").val(accounting_account);
    
                            $("#editItemSubmitButton").click(function () {
                                $("#edit_id").val(current_index[1]);
                            });
                        });

                    });

                    $(".deleteBtn").on("click", function () {
                        var current_index_delete = $(this).attr("id");
                        var current_index = current_index_delete.split('-');

                        $("#deleteCustomerName").empty().append($("#customer_account-" + current_index[1]).html());

                        $("#delete_id").val(current_index[1]);

                    });
                }

            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });
    }


    function generateTable() {
        totalRow = countRow();
        totalPage = paginate(totalRow);
        var currentPageNum;

        if($("#currentPageNum").val() != 0){
            if($("#currentPageNum").val() > totalPage ){
                currentPageNum = totalPage;
            }else{
                currentPageNum = $("#currentPageNum").val();
            }
        }else{
            currentPageNum = 1;
        }

        $("#currentPageNum").val(currentPageNum);

        $.ajax({
            type: "POST",
            url: "./backend/customer/customer.php",
            data: {
                postType: "view",
                pageNum: currentPageNum
            },
            //dataType: "json",
            success: function (results) {

                if (results == "0 results" || results == "No Result") {

                    renderTable("general");
                    tableSetting("general");
                    renderTable("additionalinfo");
                    tableSetting("additionalinfo");
                    renderTable("accounting");
                    tableSetting("accounting");


                } else {
                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "general");
                    renderContent(results, "additionalinfo");
                    renderContent(results, "accounting");


                    $(".editBtn").on("click", function () {
                        var current_index_edit = $(this).attr("id");
                        var current_index = current_index_edit.split('-');

                        var customer_account = $("#customer_account-" + current_index[1]).text();
                        var name = $("#name-" + current_index[1]).text();
                        var reg_num = $("#reg_num-" + current_index[1]).text();
                        var outstanding = $("#outstanding-" + current_index[1]).text();
                        var points = $("#points-" + current_index[1]).text();
                        var status = $("#status-" + current_index[1]).text();
                        var address = $("#address-" + current_index[1]).text();
                        var postcode = $("#postcode-" + current_index[1]).text();
                        var state = $("#state-" + current_index[1]).text();
                        var salutation = $("#salutation-" + current_index[1]).text();
                        var email = $("#email-" + current_index[1]).text();
                        var website = $("#website-" + current_index[1]).text();
                        var biz_nature = $("#biz_nature-" + current_index[1]).text();
                        var salesperson = $("#salesperson-" + current_index[1]).text();
                        var category = $("#category-" + current_index[1]).text();
                        var city = $("#city-" + current_index[1]).text();
                        var country = $("#country-" + current_index[1]).text();
                        var attention = $("#attention-" + current_index[1]).text();
                        var introducer = $("#introducer-" + current_index[1]).text();
                        var reg_date = $("#reg_date-" + current_index[1]).text();
                        var expiry_date = $("#expiry_date-" + current_index[1]).text();
                        var telephone1 = $("#telephone1-" + current_index[1]).text();
                        var telephone2 = $("#telephone2-" + current_index[1]).text();
                        var fax = $("#fax-" + current_index[1]).text();
                        var handphone = $("#handphone-" + current_index[1]).text();
                        var skype = $("#skype-" + current_index[1]).text();
                        var nric = $("#nric-" + current_index[1]).text();
                        var gender = $("#gender-" + current_index[1]).text();
                        var dob = $("#dob-" + current_index[1]).text();
                        var race = $("#race-" + current_index[1]).text();
                        var religion = $("#religion-" + current_index[1]).text();

                        var info1 = $("#info1-" + current_index[1]).text();
                        var info2 = $("#info2-" + current_index[1]).text();
                        var info3 = $("#info3-" + current_index[1]).text();
                        var info4 = $("#info4-" + current_index[1]).text();
                        var info5 = $("#info5-" + current_index[1]).text();
                        var info6 = $("#info6-" + current_index[1]).text();
                        var info7 = $("#info7-" + current_index[1]).text();
                        var info8 = $("#info8-" + current_index[1]).text();
                        var info9 = $("#info9-" + current_index[1]).text();
                        var info10 = $("#info10-" + current_index[1]).text();

                        var control_ac = $("#control_ac-" + current_index[1]).text();
                        var accounting_account = $("#accounting_account-" + current_index[1]).text();

                        $("#edit-customer_account").val(customer_account);
                        $("#edit-name").val(name);
                        $("#edit-reg_num").val(reg_num);
                        $("#edit-outstanding").val(outstanding);
                        $("#edit-points").val(points);
                        $("#edit-status").val(status);
                        $("#edit-address").val(address);
                        $("#edit-postcode").val(postcode);
                        $("#edit-state").val(state);
                        $("#edit-salutation").val(salutation);
                        $("#edit-email").val(email);
                        $("#edit-website").val(website);
                        $("#edit-biz_nature").val(biz_nature);
                        $("#edit-salesperson").val(salesperson);
                        $("#edit-category").val(category);
                        $("#edit-city").val(city);
                        $("#edit-country").val(country);
                        $("#edit-attention").val(attention);
                        $("#edit-introducer").val(introducer);
                        $("#edit-reg_date").val(reg_date);
                        $("#edit-expiry_date").val(expiry_date);
                        $("#edit-telephone1").val(telephone1);
                        $("#edit-telephone2").val(telephone2);
                        $("#edit-fax").val(fax);
                        $("#edit-handphone").val(handphone);
                        $("#edit-skype").val(skype);
                        $("#edit-nric").val(nric);
                        $("#edit-gender").val(gender);
                        $("#edit-dob").val(dob);
                        $("#edit-race").val(race);
                        $("#edit-religion").val(religion);

                        $("#edit-info1").val(info1);
                        $("#edit-info2").val(info2);
                        $("#edit-info3").val(info3);
                        $("#edit-info4").val(info4);
                        $("#edit-info5").val(info5);
                        $("#edit-info6").val(info6);
                        $("#edit-info7").val(info7);
                        $("#edit-info8").val(info8);
                        $("#edit-info9").val(info9);
                        $("#edit-info10").val(info10);

                        $("#edit-control_ac").val(control_ac);
                        $("#edit-accounting_account").val(accounting_account);

                        $("#editItemSubmitButton").click(function () {
                            $("#edit_id").val(current_index[1]);
                        });
                    });


                    $(".deleteBtn").on("click", function () {
                        var current_index_delete = $(this).attr("id");
                        var current_index = current_index_delete.split('-');

                        $("#deleteCustomerName").empty().append($("#customer_account-" + current_index[1]).html());

                        $("#delete_id").val(current_index[1]);

                    });
                }
            },
            error: function () {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });
    }

    function tableSetting(type) {
        switch (type) {
            case ("general"):

                var table = $('#generalTable').DataTable({
                    searching: false,
                    paginate: false,
                    lengthChange: false,
                    info: false,
                    scrollX: true,
                    scrollY: '1000px',
                    scrollCollapse: true,
                    // lengthMenu: [
                    //     [10, 25, 50, 100, -1],
                    //     [10, 25, 50, 100, "All"]
                    // ]
                }).columns.adjust();

                $('.dataTables_length').addClass('bs-select');
                break;

            case ("additionalinfo"):


                var table = $('#additionalinfoTable').DataTable({
                    searching: false,
                    paginate: false,
                    lengthChange: false,
                    info: false,
                    scrollX: true,
                    scrollY: '1000px',
                    scrollCollapse: true,
                    // lengthMenu: [
                    //     [10, 25, 50, 100, -1],
                    //     [10, 25, 50, 100, "All"]
                    // ]
                }).columns.adjust();

                $('.dataTables_length').addClass('bs-select');

                break;

            case ("accounting"):

                var table = $('#accountingTable').DataTable({
                    searching: false,
                    paginate: false,
                    lengthChange: false,
                    info: false,
                    scrollX: true,
                    scrollY: '1000px',
                    scrollCollapse: true,
                    // lengthMenu: [
                    //     [10, 25, 50, 100, -1],
                    //     [10, 25, 50, 100, "All"]
                    // ]
                }).columns.adjust();

                $('.dataTables_length').addClass('bs-select');
                break;

            
        }
    }

    function renderTable(type) {
        switch (type) {
            case ("general"):

                $("#general-table").empty().append(
                    '<table id="generalTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Name</th> ' +
                    ' <th scope="col" class="th-lg">Reg Num</th> ' +
                    ' <th scope="col" class="th-lg">Outstanding</th> ' +
                    ' <th scope="col" class="th-lg">Points</th> ' +
                    ' <th scope="col" class="th-lg">Status</th> ' +
                    ' <th scope="col" class="th-lg">Address</th> ' +
                    ' <th scope="col" class="th-lg">Postcode</th> ' +
                    ' <th scope="col" class="th-lg">State</th> ' +
                    ' <th scope="col" class="th-lg">Salutation</th> ' +
                    ' <th scope="col" class="th-lg">Email</th> ' +
                    ' <th scope="col" class="th-lg">Website</th> ' +
                    ' <th scope="col" class="th-lg">Biz Nature</th> ' +
                    ' <th scope="col" class="th-lg">Sales Person</th> ' +
                    ' <th scope="col" class="th-lg">Category</th> ' +
                    ' <th scope="col" class="th-lg">City</th> ' +
                    ' <th scope="col" class="th-lg">Country</th> ' +
                    ' <th scope="col" class="th-lg">Attention</th> ' +
                    ' <th scope="col" class="th-lg">Introducer</th> ' +
                    ' <th scope="col" class="th-lg">Reg Date</th> ' +
                    ' <th scope="col" class="th-lg">Expire Date</th> ' +
                    ' <th scope="col" class="th-lg">Telephone 1</th> ' +
                    ' <th scope="col" class="th-lg">Telephone 2</th> ' +
                    ' <th scope="col" class="th-lg">Fax</th> ' +
                    ' <th scope="col" class="th-lg">Handphone</th> ' +
                    ' <th scope="col" class="th-lg">Skype</th> ' +
                    ' <th scope="col" class="th-lg">NRIC</th> ' +
                    ' <th scope="col" class="th-lg">Gender</th> ' +
                    ' <th scope="col" class="th-lg">DOB</th> ' +
                    ' <th scope="col" class="th-lg">Race</th> ' +
                    ' <th scope="col" class="th-lg">Religion</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="generalContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Name</th> ' +
                    ' <th scope="col" class="th-lg">Reg Num</th> ' +
                    ' <th scope="col" class="th-lg">Outstanding</th> ' +
                    ' <th scope="col" class="th-lg">Points</th> ' +
                    ' <th scope="col" class="th-lg">Status</th> ' +
                    ' <th scope="col" class="th-lg">Address</th> ' +
                    ' <th scope="col" class="th-lg">Postcode</th> ' +
                    ' <th scope="col" class="th-lg">State</th> ' +
                    ' <th scope="col" class="th-lg">Salutation</th> ' +
                    ' <th scope="col" class="th-lg">Email</th> ' +
                    ' <th scope="col" class="th-lg">Website</th> ' +
                    ' <th scope="col" class="th-lg">Biz Nature</th> ' +
                    ' <th scope="col" class="th-lg">Sales Person</th> ' +
                    ' <th scope="col" class="th-lg">Category</th> ' +
                    ' <th scope="col" class="th-lg">City</th> ' +
                    ' <th scope="col" class="th-lg">Country</th> ' +
                    ' <th scope="col" class="th-lg">Attention</th> ' +
                    ' <th scope="col" class="th-lg">Introducer</th> ' +
                    ' <th scope="col" class="th-lg">Reg Date</th> ' +
                    ' <th scope="col" class="th-lg">Expire Date</th> ' +
                    ' <th scope="col" class="th-lg">Telephone 1</th> ' +
                    ' <th scope="col" class="th-lg">Telephone 2</th> ' +
                    ' <th scope="col" class="th-lg">Fax</th> ' +
                    ' <th scope="col" class="th-lg">Handphone</th> ' +
                    ' <th scope="col" class="th-lg">Skype</th> ' +
                    ' <th scope="col" class="th-lg">NRIC</th> ' +
                    ' <th scope="col" class="th-lg">Gender</th> ' +
                    ' <th scope="col" class="th-lg">DOB</th> ' +
                    ' <th scope="col" class="th-lg">Race</th> ' +
                    ' <th scope="col" class="th-lg">Religion</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                break;

            case ("additionalinfo"):

                $("#additionalinfo-table").empty().append(
                    '<table id="additionalinfoTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Info 1</th> ' +
                    ' <th scope="col" class="th-lg">Info 2</th> ' +
                    ' <th scope="col" class="th-lg">Info 3</th> ' +
                    ' <th scope="col" class="th-lg">Info 4</th> ' +
                    ' <th scope="col" class="th-lg">Info 5</th> ' +
                    ' <th scope="col" class="th-lg">Info 6</th> ' +
                    ' <th scope="col" class="th-lg">Info 7</th> ' +
                    ' <th scope="col" class="th-lg">Info 8</th> ' +
                    ' <th scope="col" class="th-lg">Info 9</th> ' +
                    ' <th scope="col" class="th-lg">Info 10</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="additionalinfoContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Info 1</th> ' +
                    ' <th scope="col" class="th-lg">Info 2</th> ' +
                    ' <th scope="col" class="th-lg">Info 3</th> ' +
                    ' <th scope="col" class="th-lg">Info 4</th> ' +
                    ' <th scope="col" class="th-lg">Info 5</th> ' +
                    ' <th scope="col" class="th-lg">Info 6</th> ' +
                    ' <th scope="col" class="th-lg">Info 7</th> ' +
                    ' <th scope="col" class="th-lg">Info 8</th> ' +
                    ' <th scope="col" class="th-lg">Info 9</th> ' +
                    ' <th scope="col" class="th-lg">Info 10</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                break;

            case ("accounting"):

                $("#accounting-table").empty().append(
                    '<table id="accountingTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0"> ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Control A/C</th> ' +
                    ' <th scope="col" class="th-lg">Account</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="accountingContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Control A/C</th> ' +
                    ' <th scope="col" class="th-lg">Account</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                $('.dataTables_length').addClass('bs-select');
                break;

        }

    }

    function renderContent(results, type) {

        switch (type) {
            case ("general"):

                renderTable("general");
                $.each(results, function (i, customer) {
                    i++;
                    $("#generalContent").append(
                        "<tr>" +
                            ' <th scope="row">' + i + "</th>" +
                            ' <td>' +
                                ' <button id="edit-' + customer.customer_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                                ' <i class="fas fa-edit"></i>' +
                                ' </button>' +
                                ' <button id="delete-' + customer.customer_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                                ' <i class="fas fa-trash-alt"></i>' +
                                ' </button>' +
                            ' </td>' +
                            " <td id='customer_id-" + customer.customer_id + "'>" + customer.customer_id + '</td>' +
                            " <td id='customer_account-" + customer.customer_id + "'>" + customer.customer_account + '</td>' +
                            " <td id='name-" + customer.customer_id + "'>" + customer.name + '</td>' +
                            " <td id='reg_num-" + customer.customer_id + "'>" + customer.reg_num + '</td>' +
                            " <td id='outstanding-" + customer.customer_id + "'>" + customer.outstanding + '</td>' +
                            " <td id='points-" + customer.customer_id + "'>" + customer.points + '</td>' +
                            " <td id='status-" + customer.customer_id + "'>" + customer.status + '</td>' +
                            " <td id='address-" + customer.customer_id + "'>" + customer.address + '</td>' +
                            " <td id='postcode-" + customer.customer_id + "'>" + customer.postcode + '</td>' +
                            " <td id='state-" + customer.customer_id + "'>" + customer.state + '</td>' +
                            " <td id='salutation-" + customer.customer_id + "'>" + customer.salutation + '</td>' +
                            " <td id='email-" + customer.customer_id + "'>" + customer.email + '</td>' +
                            " <td id='website-" + customer.customer_id + "'>" + customer.website + '</td>' +
                            " <td id='biz_nature-" + customer.customer_id + "'>" + customer.biz_nature + '</td>' +
                            " <td id='salesperson-" + customer.customer_id + "'>" + customer.salesperson + '</td>' +
                            " <td id='category-" + customer.customer_id + "'>" + customer.category + '</td>' +
                            " <td id='city-" + customer.customer_id + "'>" + customer.city + '</td>' +
                            " <td id='country-" + customer.customer_id + "'>" + customer.country + '</td>' +
                            " <td id='attention-" + customer.customer_id + "'>" + customer.attention + '</td>' +
                            " <td id='introducer-" + customer.customer_id + "'>" + customer.introducer + '</td>' +
                            " <td id='reg_date-" + customer.customer_id + "'>" + customer.reg_date + '</td>' +
                            " <td id='expiry_date-" + customer.customer_id + "'>" + customer.expiry_date + '</td>' +
                            " <td id='telephone1-" + customer.customer_id + "'>" + customer.telephone1 + '</td>' +
                            " <td id='telephone2-" + customer.customer_id + "'>" + customer.telephone2 + '</td>' +
                            " <td id='fax-" + customer.customer_id + "'>" + customer.fax + '</td>' +
                            " <td id='handphone-" + customer.customer_id + "'>" + customer.handphone + '</td>' +
                            " <td id='skype-" + customer.customer_id + "'>" + customer.skype + '</td>' +
                            " <td id='nric-" + customer.customer_id + "'>" + customer.nric + '</td>' +
                            " <td id='gender-" + customer.customer_id + "'>" + customer.gender + '</td>' +
                            " <td id='dob-" + customer.customer_id + "'>" + customer.dob + '</td>' +
                            " <td id='race-" + customer.customer_id + "'>" + customer.race + '</td>' +
                            " <td id='religion-" + customer.customer_id + "'>" + customer.religion + '</td>' +
                        '</tr>'
                    );
                });

                tableSetting("general");
                break;

            case ("additionalinfo"):
                renderTable("additionalinfo");
                $.each(results, function (i, customer) {
                    i++;

                    $("#additionalinfoContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + customer.customer_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + customer.customer_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='customer-id-" + customer.customer_id + "'>" + customer.customer_id + '</td>' +
                        " <td id='info1-" + customer.customer_id + "'>" + customer.info1 + '</td>' +
                        " <td id='info2-" + customer.customer_id + "'>" + customer.info2 + '</td>' +
                        " <td id='info3-" + customer.customer_id + "'>" + customer.info3 + '</td>' +
                        " <td id='info4-" + customer.customer_id + "'>" + customer.info4 + '</td>' +
                        " <td id='info5-" + customer.customer_id + "'>" + customer.info5 + '</td>' +
                        " <td id='info6-" + customer.customer_id + "'>" + customer.info6 + '</td>' +
                        " <td id='info7-" + customer.customer_id + "'>" + customer.info7 + '</td>' +
                        " <td id='info8-" + customer.customer_id + "'>" + customer.info8 + '</td>' +
                        " <td id='info9-" + customer.customer_id + "'>" + customer.info9 + '</td>' +
                        " <td id='info10-" + customer.customer_id + "'>" + customer.info10 + '</td>' +
                        ' </tr>'
                    );
                });
                tableSetting("additionalinfo");
                break;

            case ("accounting"):
                renderTable("accounting");
                $.each(results, function (i, customer) {
                    i++;

                    $("#accountingContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + customer.customer_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + customer.customer_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='customer-id-" + customer.customer_id + "'>" + customer.customer_id + '</td>' +
                        " <td id='control_ac-" + customer.customer_id + "'>" + customer.control_ac + '</td>' +
                        " <td id='accounting_account-" + customer.customer_id + "'>" + customer.accounting_account + '</td>' +
                        ' </tr>'
                    );
                });
                tableSetting("accounting");
                break;

            
        }
    }
});