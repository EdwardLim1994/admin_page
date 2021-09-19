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
            url: "./backend/item/item.php",
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
            url: "./backend/item/item.php",
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
            url: "./backend/item/item.php",
            data: {
                postType: "searchRow",
                search: input,
                pageNum: currentPageNum
                
            },
            success: function (results) {
                
                paginate(searchRowCount(input));

                if (results == "No result") {

                    failedMessage("Failed", "No result match");
                    renderTable("item");
                    tableSetting("item");
                    renderTable("general");
                    tableSetting("general");
                    renderTable("vendor");
                    tableSetting("vendor");
                    renderTable("picture");
                    tableSetting("picture");
                    renderTable("plu");
                    tableSetting("plu");
                    renderTable("others");
                    tableSetting("others");

                } else {
                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    console.log(results);
                    renderContent(results, "item");
                    renderContent(results, "general");
                    renderContent(results, "vendor");
                    renderContent(results, "picture");
                    renderContent(results, "plu");
                    renderContent(results, "others");

                    $(".editBtn").on("click", function () {
                        var current_index_delete = $(this).attr("id");
                        var current_index = current_index_delete.split('-');

                        var item_no = $("#item-no-" + current_index[1]).text();
                        var doc_key = $("#doc-key-" + current_index[1]).text();
                        var description = $("#description-" + current_index[1]).text();
                        var description2 = $("#description2-" + current_index[1]).text();
                        var description3 = $("#description3-" + current_index[1]).text();
                        var master_vendor = $("#master-vendor-" + current_index[1]).text();
                        var vendor_item = $("#vendor-item-" + current_index[1]).text();
                        var item_type = $("#item-type-" + current_index[1]).text();
                        var category = $("#category-" + current_index[1]).text();
                        var item_group = $("#item-group-" + current_index[1]).text();

                        var unit_cost = $("#unit-cost-" + current_index[1]).text();
                        var selling_price1 = $("#selling-price1-" + current_index[1]).text();
                        var qty_hand = $("#qty-hand-" + current_index[1]).text();
                        var qty_hold = $("#qty-hold-" + current_index[1]).text();
                        var qty_available = $("#qty-available-" + current_index[1]).text();
                        var qty_reorder_available = $("#qty-reorder-available-" + current_index[1]).text();
                        var qty_max = $("#qty-max-" + current_index[1]).text();

                        var vendor = $("#vendor-" + current_index[1]).text();
                        var vendor_company = $("#vendor-company-" + current_index[1]).text();

                        //var item_picture = $("item-picture-" + current_index[1]).html();

                        var plu = $("#plu-" + current_index[1]).text();

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

                        //console.log(description);

                        $("#edit-item-no").val(item_no.replace(/\s/g, ''));
                        $("#edit-doc-key").val(doc_key);
                        $("#edit-description").val(description.replace(/\s/g, ''));
                        $("#edit-description2").val(description2);
                        $("#edit-description3").val(description3.replace(/\s/g, ''));
                        $("#edit-master-vendor").val(master_vendor);
                        $("#edit-vendor-item").val(vendor_item);
                        $("#edit-item-type").val(item_type);
                        $("#edit-category").val(category);
                        $("#edit-item-group").val(item_group);

                        $("#edit-unit-cost").val(unit_cost);
                        $("#edit-selling-price1").val(selling_price1);
                        $("#edit-qty-hand").val(qty_hand);
                        $("#edit-qty-hold").val(qty_hold);
                        $("#edit-qty-available").val(qty_available);
                        $("#edit-qty-reorder-available").val(qty_reorder_available);
                        $("#edit-qty-max").val(qty_max);

                        $("#edit-vendor-name").val(vendor);
                        $("#edit-vendor-company").val(vendor_company);

                        //$("#edit-item-picture").val(item_picture);
                        $("#edit-plu-item").val(plu);

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


                        $("#editItemSubmitButton").click(function () {
                            $("#edit_id").val(current_index[1]);
 
                        });

                    });

                    $(".deleteBtn").on("click", function () {
                        var current_index_delete = $(this).attr("id");
                        var current_index = current_index_delete.split('-');

                        $("#deleteItemName").empty().append($("#description-" + current_index[1]).html());

                        $("#delete_id").val(current_index[1]);

                        // $("#deleteItemSubmitButton").on("click", function () {
                        //     console.log("clicked");
                        //     deleteEvent(current_index[1]);
                        // });
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
            url: "./backend/item/item.php",
            data: {
                postType: "view",
                pageNum: currentPageNum
            },
            //dataType: "json",
            success: function (results) {

                if (results.replace(/\"/g, "") == "0 results" || results.replace(/\"/g, "") == "No result") {

                    renderTable("item");
                    tableSetting("item");
                    renderTable("general");
                    tableSetting("general");
                    renderTable("vendor");
                    tableSetting("vendor");
                    renderTable("picture");
                    tableSetting("picture");
                    renderTable("plu");
                    tableSetting("plu");
                    renderTable("others");
                    tableSetting("others");

                } else {
                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "item");
                    renderContent(results, "general");
                    renderContent(results, "vendor");
                    renderContent(results, "picture");
                    renderContent(results, "plu");
                    renderContent(results, "others");

                    $(".editBtn").on("click", function () {
                        var current_index_delete = $(this).attr("id");
                        var current_index = current_index_delete.split('-');

                        var item_no = $("#item-no-" + current_index[1]).text();
                        var doc_key = $("#doc-key-" + current_index[1]).text();
                        var description = $("#description-" + current_index[1]).text();
                        var description2 = $("#description2-" + current_index[1]).text();
                        var description3 = $("#description3-" + current_index[1]).text();
                        var master_vendor = $("#master-vendor-" + current_index[1]).text();
                        var vendor_item = $("#vendor-item-" + current_index[1]).text();
                        var item_type = $("#item-type-" + current_index[1]).text();
                        var category = $("#category-" + current_index[1]).text();
                        var item_group = $("#item-group-" + current_index[1]).text();

                        var unit_cost = $("#unit-cost-" + current_index[1]).text();
                        var selling_price1 = $("#selling-price1-" + current_index[1]).text();
                        var qty_hand = $("#qty-hand-" + current_index[1]).text();
                        var qty_hold = $("#qty-hold-" + current_index[1]).text();
                        var qty_available = $("#qty-available-" + current_index[1]).text();
                        var qty_reorder_available = $("#qty-reorder-available-" + current_index[1]).text();
                        var qty_max = $("#qty-max-" + current_index[1]).text();

                        var vendor = $("#vendor-" + current_index[1]).text();
                        var vendor_company = $("#vendor-company-" + current_index[1]).text();

                        //var item_picture = $("item-picture-" + current_index[1]).html();

                        var plu = $("#plu-" + current_index[1]).text();

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

                        //console.log(description);

                        $("#edit-item-no").val(item_no.replace(/\s/g, ''));
                        $("#edit-doc-key").val(doc_key);
                        $("#edit-description").val(description.replace(/\s/g, ''));
                        $("#edit-description2").val(description2);
                        $("#edit-description3").val(description3.replace(/\s/g, ''));
                        $("#edit-master-vendor").val(master_vendor);
                        $("#edit-vendor-item").val(vendor_item);
                        $("#edit-item-type").val(item_type);
                        $("#edit-category").val(category);
                        $("#edit-item-group").val(item_group);

                        $("#edit-unit-cost").val(unit_cost);
                        $("#edit-selling-price1").val(selling_price1);
                        $("#edit-qty-hand").val(qty_hand);
                        $("#edit-qty-hold").val(qty_hold);
                        $("#edit-qty-available").val(qty_available);
                        $("#edit-qty-reorder-available").val(qty_reorder_available);
                        $("#edit-qty-max").val(qty_max);

                        $("#edit-vendor-name").val(vendor);
                        $("#edit-vendor-company").val(vendor_company);

                        //$("#edit-item-picture").val(item_picture);
                        $("#edit-plu-item").val(plu);

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

                        $("#editItemSubmitButton").click(function () {
                            $("#edit_id").val(current_index[1]);
 
                        });

                    });



                    $(".deleteBtn").on("click", function () {
                        var current_index_delete = $(this).attr("id");
                        var current_index = current_index_delete.split('-');

                        $("#deleteItemName").empty().append($("#description-" + current_index[1]).html());

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
            case ("item"):

                var table = $('#itemTable').DataTable({
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

            case ("vendor"):

                var table = $('#vendorTable').DataTable({
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

            case ("picture"):

                var table = $('#pictureTable').DataTable({
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

            case ("plu"):

                var table = $('#pluTable').DataTable({
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

            case ("others"):

                var table = $('#othersTable').DataTable({
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
            case ("item"):

                $("#item-table").empty().append(
                    '<table id="itemTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Doc Key</th> ' +
                    ' <th scope="col" class="th-lg">Description</th> ' +
                    ' <th scope="col" class="th-lg">Description 2</th> ' +
                    ' <th scope="col" class="th-lg">Description 3</th> ' +
                    ' <th scope="col" class="th-lg">Selling Price1</th> ' +
                    ' <th scope="col" class="th-lg">Master Vendor</th> ' +
                    ' <th scope="col" class="th-lg">Vendor Item</th> ' +
                    ' <th scope="col" class="th-lg">Item Type</th> ' +
                    ' <th scope="col" class="th-lg">Category</th> ' +
                    ' <th scope="col" class="th-lg">Item Group</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="itemContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Doc Key</th> ' +
                    ' <th scope="col" class="th-lg">Description</th> ' +
                    ' <th scope="col" class="th-lg">Description 2</th> ' +
                    ' <th scope="col" class="th-lg">Description 3</th> ' +
                    ' <th scope="col" class="th-lg">Selling Price1</th> ' +
                    ' <th scope="col" class="th-lg">Master Vendor</th> ' +
                    ' <th scope="col" class="th-lg">Vendor Item</th> ' +
                    ' <th scope="col" class="th-lg">Item Type</th> ' +
                    ' <th scope="col" class="th-lg">Category</th> ' +
                    ' <th scope="col" class="th-lg">Item Group</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );




                break;

            case ("general"):

                $("#general-table").empty().append(
                    '<table id="generalTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Unit Cost</th> ' +
                    ' <th scope="col" class="th-lg">Qty on Hand</th> ' +
                    ' <th scope="col" class="th-sm">Qty Hold</th> ' +
                    ' <th scope="col" class="th-lg">Qty Available</th> ' +
                    ' <th scope="col" class="th-lg">Qty Reorder Available</th> ' +
                    ' <th scope="col" class="th-sm">Qty Max</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="generalContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Unit Cost</th> ' +
                    ' <th scope="col" class="th-lg">Qty on Hand</th> ' +
                    ' <th scope="col" class="th-sm">Qty Hold</th> ' +
                    ' <th scope="col" class="th-lg">Qty Available</th> ' +
                    ' <th scope="col" class="th-lg">Qty Reorder Available</th> ' +
                    ' <th scope="col" class="th-sm">Qty Max</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                break;

            case ("vendor"):

                $("#vendor-table").empty().append(
                    '<table id="vendorTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0"> ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Vendor</th> ' +
                    ' <th scope="col" class="th-lg">Vendor Company</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="vendorContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Vendor</th> ' +
                    ' <th scope="col" class="th-lg">Vendor Company</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                $('.dataTables_length').addClass('bs-select');
                break;

            case ("picture"):
                $("#picture-table").empty().append(
                    '<table id="pictureTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0"> ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Picture</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="pictureContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">Picture</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );


                break;

            case ("plu"):
                $("#plu-table").empty().append(
                    '<table id="pluTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">PLU</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="pluContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-lg">PLU</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );


                break;

            case ("others"):
                $("#others-table").empty().append(
                    '<table id="othersTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0"> ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-sm">Info 1</th> ' +
                    ' <th scope="col" class="th-sm">Info 2</th> ' +
                    ' <th scope="col" class="th-sm">Info 3</th> ' +
                    ' <th scope="col" class="th-sm">Info 4</th> ' +
                    ' <th scope="col" class="th-sm">Info 5</th> ' +
                    ' <th scope="col" class="th-sm">Info 6</th> ' +
                    ' <th scope="col" class="th-sm">Info 7</th> ' +
                    ' <th scope="col" class="th-sm">Info 8</th> ' +
                    ' <th scope="col" class="th-sm">Info 9</th> ' +
                    ' <th scope="col" class="th-sm">Info 10</th> ' +

                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="othersContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Item No</th> ' +
                    ' <th scope="col" class="th-sm">Info 1</th> ' +
                    ' <th scope="col" class="th-sm">Info 2</th> ' +
                    ' <th scope="col" class="th-sm">Info 3</th> ' +
                    ' <th scope="col" class="th-sm">Info 4</th> ' +
                    ' <th scope="col" class="th-sm">Info 5</th> ' +
                    ' <th scope="col" class="th-sm">Info 6</th> ' +
                    ' <th scope="col" class="th-sm">Info 7</th> ' +
                    ' <th scope="col" class="th-sm">Info 8</th> ' +
                    ' <th scope="col" class="th-sm">Info 9</th> ' +
                    ' <th scope="col" class="th-sm">Info 10</th> ' +

                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );


                break;
        }

    }

    function renderContent(results, type) {

        switch (type) {
            case ("item"):

                renderTable("item");
                $.each(results, function (i, item) {
                    i++;
                    $("#itemContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + item.item_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + item.item_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='item-no-" + item.item_id + "'>" + item.item_no + '</td>' +
                        ' <td id="doc-key-' + item.item_id + '">' + item.doc_key + '</td>' +
                        ' <td id="description-' + item.item_id + '">' + item.description + '</td>' +
                        ' <td id="description2-' + item.item_id + '">' + item.description2 + '</td>' +
                        ' <td id="description3-' + item.item_id + '">' + item.description3 + '</td>' +
                        ' <td id="selling-price1-' + item.item_id + '">' + item.selling_price1 + '</td>' +
                        ' <td id="master-vendor-' + item.item_id + '">' + item.master_vendor + '</td>' +
                        ' <td id="vendor-item-' + item.item_id + '">' + item.vendor_item + '</td>' +
                        ' <td id="item-type-' + item.item_id + '">' + item.item_type + '</td>' +
                        ' <td id="category-' + item.item_id + '">' + item.category + '</td>' +
                        ' <td id="item-group-' + item.item_id + '">' + item.item_group + '</td>' +
                        ' </tr>'
                    );
                });

                tableSetting("item");
                break;

            case ("general"):
                renderTable("general");
                $.each(results, function (i, item) {
                    i++;

                    $("#generalContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + item.item_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + item.item_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='item-no-" + item.item_id + "'>" + item.item_no + '</td>' +
                        ' <td id="unit-cost-' + item.item_id + '">' + item.unit_cost + '</td>' +
                        ' <td id="qty-hand-' + item.item_id + '">' + item.qty_hand + '</td>' +
                        ' <td id="qty-hold-' + item.item_id + '">' + item.qty_hold + '</td>' +
                        ' <td id="qty-available-' + item.item_id + '">' + item.qty_available + '</td>' +
                        ' <td id="qty-reorder-available-' + item.item_id + '">' + item.qty_reorder_available + '</td>' +
                        ' <td id="qty-max-' + item.item_id + '">' + item.qty_max + '</td>' +
                        ' </tr>'
                    );
                });
                tableSetting("general");
                break;

            case ("vendor"):
                renderTable("vendor");
                $.each(results, function (i, item) {
                    i++;

                    $("#vendorContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + item.item_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + item.item_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='type-" + item.item_id + "'>" + item.item_no + '</td>' +
                        ' <td id="vendor-' + item.item_id + '">' + item.vendor + '</td>' +
                        ' <td id="vendor-company-' + item.item_id + '">' + item.vendor_company + '</td>' +
                        ' </tr>'
                    );
                });
                tableSetting("vendor");
                break;

            case ("picture"):
                renderTable("picture");
                $.each(results, function (i, item) {
                    i++;

                    $("#pictureContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + item.item_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + item.item_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='item-no-" + item.item_id + "'>" + item.item_no + '</td>' +
                        ' <td id="item-picture-' + item.item_id + '"><img class="w-25" src="./assets/placeholder-images-image_large.png" alt="placeholder"></td>' +
                        // ' <td id="item-picture-' + item.item_id + '"> ' + item.item_picture + ' </td>' +
                        ' </tr>'
                    );
                });
                tableSetting("picture");
                break;

            case ("plu"):
                renderTable("plu");
                $.each(results, function (i, item) {
                    i++;

                    $("#pluContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + item.item_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + item.item_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='item-no-" + item.item_id + "'>" + item.item_no + '</td>' +
                        ' <td id="plu-' + item.item_id + '">' + item.plu + '</td>' +
                        ' </tr>'
                    );
                });
                tableSetting("plu");
                break;

            case ("others"):
                renderTable("others");
                $.each(results, function (i, item) {
                    i++;

                    $("#othersContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + item.item_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + item.item_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        ' </button>' +
                        ' </td>' +
                        " <td id='item-no-" + item.item_id + "'>" + item.item_no + ' /td>' +
                        ' <td id="info1-' + item.item_id + '">' + item.info1 + '</td>' +
                        ' <td id="info2-' + item.item_id + '">' + item.info2 + '</td>' +
                        ' <td id="info3-' + item.item_id + '">' + item.info3 + '</td>' +
                        ' <td id="info4-' + item.item_id + '">' + item.info4 + '</td>' +
                        ' <td id="info5-' + item.item_id + '">' + item.info5 + '</td>' +
                        ' <td id="info6-' + item.item_id + '">' + item.info6 + '</td>' +
                        ' <td id="info7-' + item.item_id + '">' + item.info7 + '</td>' +
                        ' <td id="info8-' + item.item_id + '">' + item.info8 + '</td>' +
                        ' <td id="info9-' + item.item_id + '">' + item.info9 + '</td>' +
                        ' <td id="info10-' + item.item_id + '">' + item.info10 + '</td>' +
                        ' </tr>'
                    );
                });
                tableSetting("others");
                break;
        }
    }
});