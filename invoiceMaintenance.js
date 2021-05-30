$(document).ready(function () {


    var totalRow = countRow();
    var totalPage = paginate(totalRow);
    generateTable();

    // if ($("#searchRow").val()) {
    //     $("#search-input-wrapper").css("display", "block");
    //     $("#search-input").empty().append($("#searchRow").val());
    //     searchTable();
    // } else {
    //     generateTable();
    // }


    // $("#searchConfirm").click(function () {
    //     searchTable($("#searchRow").val());
    // })

    // $("#searchClear").click(function () {
    //     generateTable();
    //     $("#searchRow").val("");
    //     $("#search-input-wrapper").css("display", "none");
    // });

    $("#currentPageNum").focusout(function () {
        if ($("#searchRow").val() != "") {
            searchTable();
        } else {
            generateTable();
        }

    });
    // $("#search-customer_name").change(customerSearchResults());
    // $("#search-customer_id").change(customerSearchResults());

    $("#search-customer_name").on('keyup', function () {
        customerSearchResults(1);
    });
    $("#search-customer_id").on('keyup', function () {
        customerSearchResults(1);
    });

    $("#search-item").on("keyup", function () {
        itemSearchResults(1);
    })



    $("#addInvoiceSubmitBtn").click(function () {

    })

    //customer name or customer id on input
    //show dropdown result
    //after choose result
    //both customer name and id will set value in input

    function customerSearchResults(pageNum) {

        var timer;
        var isSpinnerOn;
        var searchResult;

        if ($("#search-customer_name").val() != "" || $("#search-customer_id").val() != "") {

            clearTimeout(timer);
            $("#customer-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);

            isSpinnerOn = true;
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowCustomer",
                        searchCustomerName: $("#search-customer_name").val(),
                        searchCustomerID: $("#search-customer_id").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#customer-search").empty().html(`<h5>${results}</h5>`);
                                isSpinnerOn = false;
                            }

                        } else if (results == "") {
                            $("#customer-search").empty().removeClass("border");
                            isSpinnerOn = false;
                        } else {
                            searchResult = `
                            <div class="sticky-top bg-white">
                                <div class="row px-3 py-2">
                                    <div class=" col-6 py-2 py-md-0">
                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="customerSearchRowTotal"></span></p>
                                    </div>
                                    <div class=" col-6 py-2 py-md-0">
                                        <div class="d-flex flex-row justify-content-end">
                                            <p class="my-auto">Page : </p>
                                            <input type="number" id="customerSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="customerSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;
                            $.each(JSON.parse(results), function (i, value) {
                                searchResult += `
                                <a class="customer-search-results">
                                    <div class="view overlay">
                                        <div class="row px-3 py-2">
                                            <div class="col-6">
                                                <h5 class="my-auto customerName">${value.name}</h5>
                                            </div>
                                            <div class="col-6 text-right">
                                                <p class="my-auto customerID">${value.customer_account}</p>
                                            </div>
                                            <div class="mask flex-center rgba-grey-slight"> </div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="p-0 m-0">
                                `;
                            });
                            searchResult += `</div>`;
                            $("#customer-search").empty().html(searchResult);
                            isSpinnerOn = false;
                            customerSearchResultsCountRow();
                            customerSearchResultsSelect();
                        }
                    }
                });
            }, 1000);
        } else {
            $("#customer-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    }

    function customerSearchResultsSelect() {
        $(".customer-search-results").click(function () {
            $("#search-customer_name").val($(this).find(".customerName").text());
            $("#search-customer_id").val($(this).find(".customerID").text());
            $("#customer-search").empty().removeClass("border");
        });
    }

    function customerSearchResultsPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#customerSearchPageTotal").empty().text(totalPage);
        $("#customerSearchCurrentPageNum").attr("max", totalPage);

        $("#customerSearchCurrentPageNum").on('focusout', function () {
            if ($("#customerSearchCurrentPageNum").val() < totalPage)
                customerSearchResults($("#customerSearchCurrentPageNum").val());
            else
                customerSearchResults(totalPage);
        })
    }

    function customerSearchResultsCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountCustomer",
                searchCustomerName: $("#search-customer_name").val(),
                searchCustomerID: $("#search-customer_id").val()
            },
            success: function (results) {
                $("#customerSearchRowTotal").empty().html(results);
                customerSearchResultsPagination(results);
            }
        });
    }

    //when search item input is searching item name or barcode
    //show dropdown results with item name, barcode and quantity
    //when select one of the result, search input will be clean
    //item will be added into bucket as json

    function itemSearchResults(pageNum) {

        var timer;
        var isSpinnerOn;
        var searchResult;

        if ($("#search-item").val() != "") {
            clearTimeout(timer);
            $("#item-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);

            isSpinnerOn = true;

            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowItem",
                        search: $("#search-item").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#item-search").empty().html(`<h5>${results}</h5>`);
                                isSpinnerOn = false;
                            }

                        } else if (results == "") {
                            $("#item-search").empty().removeClass("border");
                            isSpinnerOn = false;
                        } else {
                            searchResult = `
                            <div class="sticky-top bg-white">
                                <div class="row px-3 py-2 ">
                                    <div class=" col-6 py-2 py-md-0">
                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="itemSearchRowTotal"></span></p>
                                    </div>
                                    <div class=" col-6 py-2 py-md-0">
                                        <div class="d-flex flex-row justify-content-end">
                                            <p class="my-auto">Page : </p>
                                            <input type="number" id="itemSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="itemSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;
                            $.each(JSON.parse(results), function (i, value) {
                                var isItemSoldOut = false;
                                if (value.qty_available == 0) {
                                    isItemSoldOut = true
                                } else {
                                    isItemSoldOut = false;
                                }
                                searchResult += `
                                <a class="item-search-results" data-id="${value.item_id}">
                                    <div class="view overlay  ${value.qty_available == 0 ? "red lighten-4" : ""}">
                                        <div class="row px-3 py-2">
                                            <div class="col-8 d-flex flex-row">
                                                <h5 class="my-auto">${value['description']}</h5>
                                                <small class="my-auto px-2 text-muted">${value['item_no']}</small>
                                            </div>
                                            <div class="col-4 d-flex flex-row justify-content-end">
                                                <strong class="my-auto">Qty: </strong>
                                                <p class="my-auto px-1 ${value['qty_available'] == 0 ? 'text-danger' : ''}">${value['qty_available']}</p>
                                            </div>
                                            <div class="mask flex-center ${value.qty_available == 0 ? "rgba-red-strong" : "rgba-grey-slight"}"></div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="p-0 m-0">
                                `;
                            });
                            searchResult += `</div>`;
                            $("#item-search").empty().html(searchResult);
                            isSpinnerOn = false;
                            itemSearchResultsCountRow();
                            itemSearchResultsSelect();

                        }
                    }
                });
            }, 1000);

        } else {
            $("#item-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    }

    function itemBucketTotalPrice(itemID) {
        var itemQuantity = $("[data-id='" + itemID + "']").find(".itemQuantity").val();
        var itemPrice = $("[data-id='" + itemID + "']").find(".selling_price").text();
        $("[data-id='" + itemID + "']").find(".total_price").text((itemQuantity * itemPrice).toFixed(2));


    }

    function itemBucketTotalCost() {
        var totalCost = 0.0;

        $.each($(".item-row"), function (i, value) {

            var totalPrice = $(".item-row:nth-child(" + (i + 1) + ")").find(".total_price").text();
            totalCost += parseFloat(totalPrice);

        })
        $("#total_cost").empty().html(totalCost.toFixed(2));
    }

    function itemSearchResultsSelect() {
        $(".item-search-results").click(function () {
            $.ajax({
                type: "POST",
                url: "./backend/invoice/viewCustmrItem.php",
                data: {
                    postType: "searchRowItemAdd",
                    itemID: $(this).data("id")
                },
                success: function (results) {
                    var item_results;
                    var isItemSoldOut = false;
                    var itemID;
                    $.each(JSON.parse(results), function (i, value) {
                        itemID = value.item_id;
                        if (value.qty_available > 0) {
                            isItemSoldOut = false;
                            if (value.item_id == $(".item-row").data("id")) {
                                var itemQty = $('[data-id=' + value.item_id + ']').find(".itemQuantity").val();
                                $('[data-id=' + value.item_id + ']').find(".itemQuantity").val((parseInt(itemQty) + 1));
                            } else {
                                item_results += `
                                <tr class="item-row" data-id="${value.item_id}">
                                    <td>
                                        <button class="btn btn-danger deleteItemBtn py-md-3 px-md-4 p-sm-3">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td class="item_no">${value.item_no}</td>
                                    <td class="description">${value.description}</td>
                                    <td class="selling_price">${value.selling_price1}</td>
                                    <td>
                                        <input type="number" class="form-control itemQuantity" min="1" max="${value.qty_available}" value="1">
                                    </td>
                                    <td class="total_price"></td>
                                </tr>
                                `;
                            }
                        } else {
                            isItemSoldOut = true;
                        }
                    })
                    if (isItemSoldOut == false) {
                        if ($("#item-bucket").find(".noResultText").length > 0) {
                            $("#item-bucket").empty();
                        }
                        if (item_results != "") {
                            $("#item-bucket").append(item_results);
                        }
                        $("#item-search").empty().removeClass("border");
                        $("#search-item").val("");
                        itemBucketTotalPrice(itemID);
                        itemBucketTotalCost();

                        $(".itemQuantity").change(function () {
                            if ($(this).val() > $(this).attr("max")) {
                                $(this).val($(this).attr("max"));
                            }

                            itemBucketTotalPrice($(this).closest("tr").data("id"));
                            itemBucketTotalCost();

                        })
                    }
                    itemBucketRemoveItem();
                }
            });
        })
    }

    function itemBucketRemoveItem() {

        $(".deleteItemBtn").click(function () {
            $(this).closest("tr").remove();

            if ($.trim($("#item-bucket").html()).length == 0) {
                $("#item-bucket").html(`
                    <tr class="noResultText">
                        <td colspan="7" class="text-center">
                            <h5>No item added yet</h5>
                        </td>
                    </tr>
                `);
            }
        });

    }

    //console.log($("#item-search").html().length());

    function itemSearchResultsPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#itemSearchPageTotal").empty().text(totalPage);
        $("#itemSearchCurrentPageNum").attr("max", totalPage);

        $("#itemSearchCurrentPageNum").on('focusout', function () {
            if ($("#itemSearchCurrentPageNum").val() < totalPage)
                itemSearchResults($("#itemSearchCurrentPageNum").val());
            else
                itemSearchResults(totalPage);
        })
    }

    function itemSearchResultsCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountItem",
                search: $("#search-item").val()
            },
            success: function (results) {
                $("#itemSearchRowTotal").empty().html(results);
                itemSearchResultsPagination(results);
            }
        });
    }



    function failedMessage(headline, body) {
        $("#failedToModal").modal("show");
        $("#failedModalHeadline").empty().append(headline);
        $("#failedModalBody").empty().append(body);
    }

    function countRow() {

        var totalRowCount;

        $.ajax({
            type: "POST",
            url: "./backend/customer/customer.php",
            data: {
                postType: "countRow",
            },
            async: false,
            success: function (results) {
                $("#rowTotal").empty().append(results);
                totalRowCount = results;

            }
        });

        return totalRowCount;
    }

    // function searchRowCount(input){

    //     var totalRowSearch;

    //     $.ajax({
    //         type: "POST",
    //         url: "./backend/customer/customer.php",
    //         data: {
    //             postType: "searchRowCount",
    //             search: input
    //         },
    //         async: false,
    //         success: function(results){
    //             $("#rowTotal").empty().append(results);
    //             totalRowSearch = results;

    //         }
    //     });

    //     return totalRowSearch;
    // }

    function paginate(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#pageTotal").empty().text(totalPage);

        if ($("#currentPageNum").val() > totalPage) {
            $("#currentPageNum").val(totalPage);
        }

        return totalPage;
    }

    // function searchTable() {

    //     $("#search-input-wrapper").css("display", "block");
    //     $("#search-input").empty().append($("#searchRow").val());

    //     var input = $("#searchRow").val();
    //     var currentPageNum = $("#currentPageNum").val() > totalPage ? totalPage :  $("#currentPageNum").val();
    //     $("#currentPageNum").val(currentPageNum);
    //     $.ajax({
    //         type: "POST",
    //         url: "./backend/customer/customer.php",
    //         data: {
    //             postType: "searchRow",
    //             search: input,
    //             pageNum: currentPageNum

    //         },
    //         success: function (results) {

    //             paginate(searchRowCount(input));

    //             if (results == "No result") {

    //                 failedMessage("Failed", "No result match");
    //                 renderTable("general");
    //                 tableSetting("general");


    //             } else {
    //                 results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
    //                 renderContent(results, "general");

    //                 $(".editBtn").on("click", function () {
    //                     $(".editBtn").on("click", function () {
    //                         var current_index_edit = $(this).attr("id");
    //                         var current_index = current_index_edit.split('-');

    //                         var customer_account = $("#customer_account-" + current_index[1]).text();
    //                         var name = $("#name-" + current_index[1]).text();
    //                         var reg_num = $("#reg_num-" + current_index[1]).text();
    //                         var outstanding = $("#outstanding-" + current_index[1]).text();
    //                         var points = $("#points-" + current_index[1]).text();
    //                         var status = $("#status-" + current_index[1]).text();
    //                         var address = $("#address-" + current_index[1]).text();
    //                         var postcode = $("#postcode-" + current_index[1]).text();
    //                         var state = $("#state-" + current_index[1]).text();
    //                         var salutation = $("#salutation-" + current_index[1]).text();
    //                         var email = $("#email-" + current_index[1]).text();
    //                         var website = $("#website-" + current_index[1]).text();
    //                         var biz_nature = $("#biz_nature-" + current_index[1]).text();
    //                         var salesperson = $("#salesperson-" + current_index[1]).text();
    //                         var category = $("#category-" + current_index[1]).text();
    //                         var city = $("#city-" + current_index[1]).text();
    //                         var country = $("#country-" + current_index[1]).text();
    //                         var attention = $("#attention-" + current_index[1]).text();
    //                         var introducer = $("#introducer-" + current_index[1]).text();
    //                         var reg_date = $("#reg_date-" + current_index[1]).text();
    //                         var expiry_date = $("#expiry_date-" + current_index[1]).text();
    //                         var telephone1 = $("#telephone1-" + current_index[1]).text();
    //                         var telephone2 = $("#telephone2-" + current_index[1]).text();
    //                         var fax = $("#fax-" + current_index[1]).text();
    //                         var handphone = $("#handphone-" + current_index[1]).text();
    //                         var skype = $("#skype-" + current_index[1]).text();
    //                         var nric = $("#nric-" + current_index[1]).text();
    //                         var gender = $("#gender-" + current_index[1]).text();
    //                         var dob = $("#dob-" + current_index[1]).text();
    //                         var race = $("#race-" + current_index[1]).text();
    //                         var religion = $("#religion-" + current_index[1]).text();

    //                         var info1 = $("#info1-" + current_index[1]).text();
    //                         var info2 = $("#info2-" + current_index[1]).text();
    //                         var info3 = $("#info3-" + current_index[1]).text();
    //                         var info4 = $("#info4-" + current_index[1]).text();
    //                         var info5 = $("#info5-" + current_index[1]).text();
    //                         var info6 = $("#info6-" + current_index[1]).text();
    //                         var info7 = $("#info7-" + current_index[1]).text();
    //                         var info8 = $("#info8-" + current_index[1]).text();
    //                         var info9 = $("#info9-" + current_index[1]).text();
    //                         var info10 = $("#info10-" + current_index[1]).text();

    //                         var control_ac = $("#control_ac-" + current_index[1]).text();
    //                         var accounting_account = $("#accounting_account-" + current_index[1]).text();

    //                         $("#edit-customer_account").val(customer_account);
    //                         $("#edit-name").val(name);
    //                         $("#edit-reg_num").val(reg_num);
    //                         $("#edit-outstanding").val(outstanding);
    //                         $("#edit-points").val(points);
    //                         $("#edit-status").val(status);
    //                         $("#edit-address").val(address);
    //                         $("#edit-postcode").val(postcode);
    //                         $("#edit-state").val(state);
    //                         $("#edit-salutation").val(salutation);
    //                         $("#edit-email").val(email);
    //                         $("#edit-website").val(website);
    //                         $("#edit-biz_nature").val(biz_nature);
    //                         $("#edit-salesperson").val(salesperson);
    //                         $("#edit-category").val(category);
    //                         $("#edit-city").val(city);
    //                         $("#edit-country").val(country);
    //                         $("#edit-attention").val(attention);
    //                         $("#edit-introducer").val(introducer);
    //                         $("#edit-reg_date").val(reg_date);
    //                         $("#edit-expiry_date").val(expiry_date);
    //                         $("#edit-telephone1").val(telephone1);
    //                         $("#edit-telephone2").val(telephone2);
    //                         $("#edit-fax").val(fax);
    //                         $("#edit-handphone").val(handphone);
    //                         $("#edit-skype").val(skype);
    //                         $("#edit-nric").val(nric);
    //                         $("#edit-gender").val(gender);
    //                         $("#edit-dob").val(dob);
    //                         $("#edit-race").val(race);
    //                         $("#edit-religion").val(religion);

    //                         $("#edit-info1").val(info1);
    //                         $("#edit-info2").val(info2);
    //                         $("#edit-info3").val(info3);
    //                         $("#edit-info4").val(info4);
    //                         $("#edit-info5").val(info5);
    //                         $("#edit-info6").val(info6);
    //                         $("#edit-info7").val(info7);
    //                         $("#edit-info8").val(info8);
    //                         $("#edit-info9").val(info9);
    //                         $("#edit-info10").val(info10);

    //                         $("#edit-control_ac").val(control_ac);
    //                         $("#edit-accounting_account").val(accounting_account);

    //                         $("#editItemSubmitButton").click(function () {
    //                             $("#edit_id").val(current_index[1]);
    //                         });
    //                     });

    //                 });

    //                 $(".deleteBtn").on("click", function () {
    //                     var current_index_delete = $(this).attr("id");
    //                     var current_index = current_index_delete.split('-');

    //                     $("#deleteCustomerName").empty().append($("#customer_account-" + current_index[1]).html());

    //                     $("#delete_id").val(current_index[1]);

    //                 });
    //             }

    //         },
    //         error: function (e) {
    //             failedMessage("Failed", "Unexpected error occur : " + e);
    //         }
    //     });
    // }


    function generateTable() {
        totalRow = countRow();
        totalPage = paginate(totalRow);
        var currentPageNum;

        if ($("#currentPageNum").val() != 0) {
            if ($("#currentPageNum").val() > totalPage) {
                currentPageNum = totalPage;
            } else {
                currentPageNum = $("#currentPageNum").val();
            }
        } else {
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

                } else {
                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "general");

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

        }
    }
});