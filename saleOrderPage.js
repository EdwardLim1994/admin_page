salesOrderMainFunction();

function salesOrderMainFunction() {
    var salesordertotalRow = countRow();
    var salesordertotalPage = paginate(salesordertotalRow);
    var timerCustomer;
    var isSpinnerOnCustomer = false;
    var timerItem;
    var isSpinnerOnItem = false;
    var timerCustomerUpdate;
    var isSpinnerOnCustomerUpdate = false;
    var timerItemUpdate;
    var isSpinnerOnItemUpdate = false;
    generateTable();

    //Pagination Input
    $("#salesorder-currentPageNum").focusout(function () {
        generateTable();
    });

    // $("#salesorder_filter_select").change(function () {
    //     generateTable();
    // })

    $("input[name='showingsalesordermode']").change(function () {
        generateTable();
    })

    //Search Customer Input for Add Modal
    $("#salesorder-search-customer_name").on("keyup", function () {
        clearTimeout(timerCustomer);
        if (!isSpinnerOnCustomer) {
            $("#salesorder-customer-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);
            isSpinnerOnCustomer = true;

        }

        if ($(this).val()) {
            timerCustomer = setTimeout(function () {
                customerSearchResults(1);
            }, 1000);
        } else {
            $("#salesorder-customer-search").empty().removeClass("border");
            isSpinnerOnCustomer = false;
        }
    })

    //Search Item Input for Add Modal
    $("#salesorder-search-item").on("keyup", function () {
        clearTimeout(timerItem);
        if (!isSpinnerOnItem) {
            $("#salesorder-item-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);
            isSpinnerOnItem = true;
        }

        if ($(this).val()) {
            timerItem = setTimeout(function () {
                itemSearchResults(1);
            }, 1000);
        } else {
            $("#salesorder-item-search").empty().removeClass("border");
            isSpinnerOnCustomer = false;
        }

    })

    //Search Customer Input for Update Modal
    $("#salesorder-update-search-customer_name").on("keyup", function () {
        clearTimeout(timerCustomerUpdate);
        if (!isSpinnerOnCustomerUpdate) {
            $("#salesorder-update-customer-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);
            isSpinnerOnCustomerUpdate = true;

        }

        if ($(this).val()) {
            timerCustomerUpdate = setTimeout(function () {
                updateCustomerSearchResults(1);
            }, 1000);
        } else {
            $("#salesorder-update-customer-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    })

    //Search Item Input for Update Modal
    $("#salesorder-update-search-item").on("keyup", function () {
        clearTimeout(timerItemUpdate);
        if (!isSpinnerOnItemUpdate) {
            $("#salesorder-update-item-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);
            isSpinnerOnItemUpdate = true;

        }

        if ($(this).val()) {
            timerItemUpdate = setTimeout(function () {
                updateItemSearchResults(1);
            }, 1000);
        } else {
            $("#salesorder-update-item-search").empty().removeClass("border");
            isSpinnerOnItemUpdate = false;
        }
    })


    //Add Sales Order Button
    $("#addSalesOrderModalBtn").click(function () {
        $("#salesorder-salesperson, #salesorder-search-item, #salesorder-search-customer_id, #salesorder-search-customer_name, #salespayment-reference").val("");
        $("#salesorder-payment_mode").val("cash");
        $("#salespayment-amount_apply").val("0.00");
        $("#salesorder-total_discount, #salesorder-total_cost").empty();
        $("#salespayment_totalCharge, #salespayment_amountPaid, #salespayment_exchange").empty().text("0.00");
        $("#salesorder-item-bucket").empty().html(`
        <tr class="salesorder-noResultText">
            <td colspan="9" class="text-center">
                <h5>No item added yet</h5>
            </td>
        </tr>
        `);
    })

    //Submit Sales Order on add
    $("#addSalesOrderSubmitBtn").click(function () {
        $(this).attr("disabled", true).empty().html(`
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `);

        setTimeout(function () {
            if (parseFloat($("#salespayment_amountPaid").text()) <= 0) {
                failedMessage("Failed", "Current payment amount is 0");
                $("#addSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            } else if (parseFloat($("#salespayment_totalCharge").text()) > parseFloat($("#salespayment_amountPaid").text())) {
                failedMessage("Failed", "Amount paid is not enough to fulfill current charge");
                $("#addSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            } else if ($("#salesorder-item-bucket").find(".salesorder-noResultText").length > 0) {
                failedMessage("Failed", "No sales order added yet");
                $("#addSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            } else {
                addSalesOrder("add");
                $("#addSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            }
            
        }, 1000);
    })


    $("#onholdSalesOrderSubmitBtn").click(function () {
        $(this).attr("disabled", true).empty().html(`
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `);

        setTimeout(function () {
            if (parseFloat($("#update-salesorder_amountPaid").text()) <= 0) {
                failedMessage("Failed", "Current payment amount is 0");
                $("#onholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('On Hold');
            } else if (parseFloat($("#update-salesorder_totalCharge").text()) > parseFloat($("#update-salesorder_amountPaid").text())) {
                failedMessage("Failed", "Amount paid is not enough to fulfill current charge");
                $("#onholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('On Hold');
            } else if ($("#salesorder-update-item-bucket").find(".salesorder-update-noResultText").length > 0) {
                failedMessage("Failed", "No sales order added yet");
                $("#onholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('On Hold');
            } else {
                addSalesOrder("onhold");
                $("#onholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('On Hold');
            }
        }, 1000);
    })


    $("#editonholdSalesOrderSubmitBtn").click(function () {

        $(this).attr("disabled", true).empty().html(`
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `);

        setTimeout(function () {
            if (parseFloat($("#update-salesorder_amountPaid").text()) <= 0) {
                failedMessage("Failed", "Current payment amount is 0");
                $("#editonholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            } else if (parseFloat($("#update-salesorder_totalCharge").text()) > parseFloat($("#update-salesorder_amountPaid").text())) {
                failedMessage("Failed", "Amount paid is not enough to fulfill current charge");
                $("#editonholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            } else if ($("#salesorder-update-item-bucket").find(".salesorder-update-noResultText").length > 0) {
                failedMessage("Failed", "No sales order added yet");
                $("#editonholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            } else {
                addSalesPayment();
                $("#editonholdSalesOrderSubmitBtn").attr("disabled", false).empty().text('Pay');
            }


        }, 1000);



    })

    //Submit Sales Order on update
    $("#editSalesOrderSubmitBtn").click(function () {

        $(this).attr("disabled", true).empty().html(`
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `);

        setTimeout(function () {
            switch ($("#update-salesorder_payment_status").val()) {
                case ("UnPaid"):
                    switch ($("#update-salesorder_isOnHold").val()) {
                        case ("Yes"):
                            editSalesOrder("onhold");
                            $("#editSalesOrderSubmitBtn").attr("disabled", false).empty().text('Update');
                            break;

                        case ("No"):
                            editSalesOrder("update");
                            $("#editSalesOrderSubmitBtn").attr("disabled", false).empty().text('Update');
                            break;
                    }

                    break;

                case ("Paid"):
                    console.log("triggered")
                    $("#editSalesOrderSubmitBtn").attr("disabled", false).empty().text('Update');
                    break;
            }

        }, 1000);
    })

    //Submit Sales Order on delete
    $("#deleteSalesOrderSubmitButton").click(function () {
        switch ($("#salesorderDelete_isPaid").val()) {
            case ("UnPaid"):
                deleteSalesOrder();

                break;

            case ("Paid"):
                $("#deleteSalesOrderModal").modal("hide");
                failedMessage("Failed", "This sale order has been paid and cannot be deleted for the sake of record");
                break;
        }

    })


    //Customer Search Function for Add Modal
    function customerSearchResults(pageNum) {
        var timer;
        var searchResult;

        if ($("#salesorder-search-customer_name").val() != "") {
            clearTimeout(timer);
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowCustomer",
                        searchCustomerName: $("#salesorder-search-customer_name").val(),
                        searchCustomerID: $("#salesorder-search-customer_id").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOnCustomer == true) {
                                $("#salesorder-customer-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>
                                    </div>
                                </div>
                                    
                                `);
                                isSpinnerOnCustomer = false;
                            }
                        } else if (results == "") {
                            $("#salesorder-customer-search").empty().removeClass("border");
                            isSpinnerOnCustomer = false;
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
                            $("#salesorder-customer-search").empty().html(searchResult);
                            isSpinnerOnCustomer = false;
                            customerSearchCountRow();
                            customerSearchSelect();

                            $("#customerSearchCurrentPageNum").focusout(function () {
                                customerSearchResults(parseInt($(this).val()));
                            })
                        }
                    },
                    error: function (e) {
                        failedMessage("Failed", "Unexpected error occur : " + e);
                    }
                });
            }, 1000);
        } else {
            $("#salesorder-customer-search").empty().removeClass("border");
            isSpinnerOnCustomer = false;
        }
    }


    function customerSearchSelect() {
        $(".customer-search-results").click(function () {
            $("#salesorder-search-customer_name").val($(this).find(".customerName").text());
            $("#salesorder-search-customer_id").val($(this).find(".customerID").text());
            $("#salesorder-customer-search").empty().removeClass("border");
        });
    }

    function customerSearchPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#customerSearchPageTotal").empty().text(totalPage);
        $("#customerSearchCurrentPageNum").attr("max", totalPage);

        $("#customerSearchCurrentPageNum").on('input', function () {
            if ($("#customerSearchCurrentPageNum").val() == "") {
                console.log("empty customer search");
            } else if ($("#customerSearchCurrentPageNum").val() < totalPage)
                customerSearchResults($("#customerSearchCurrentPageNum").val());
            else
                customerSearchResults(totalPage);
        })
    }

    function customerSearchCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountCustomer",
                searchCustomerName: $("#salesorder-search-customer_name").val(),
                searchCustomerID: ""
            },
            success: function (results) {
                $("#customerSearchRowTotal").empty().html(results);
                customerSearchPagination(results);
            }
        });
    }


    //Item Search Function for Add Modal
    function itemSearchResults(pageNum) {
        var timer;
        var searchResult;

        if ($("#salesorder-search-item").val() != "") {
            clearTimeout(timer);
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowItem",
                        search: $("#salesorder-search-item").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOnItem == true) {
                                $("#salesorder-item-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./itemMaintenance.php">Go add new item</a>
                                    </div>
                                </div>
                                `);
                                isSpinnerOnItem = false;
                            }
                        } else if (results == "") {
                            $("#salesorder-item-search").empty().removeClass("border");
                            isSpinnerOnItem = false;
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
                                <a class="item-search-results" data-id="${value.item_id}" data-issoldout="${isItemSoldOut}">
                                    <div class="view overlay  ${isItemSoldOut ? "red lighten-4" : ""}">
                                        <div class="row px-3 py-2">
                                            <div class="col-8 d-flex flex-row">
                                                <h5 class="my-auto">${value['description']}</h5>
                                                <small class="my-auto px-2 text-muted">${value['item_no']}</small>
                                            </div>
                                            <div class="col-4 d-flex flex-row justify-content-end">
                                                <strong class="my-auto">Qty: </strong>
                                                <p class="my-auto px-1 ${isItemSoldOut ? 'text-danger' : ''}">${value['qty_available']}</p>
                                            </div>
                                            <div class="mask flex-center ${isItemSoldOut ? "rgba-red-strong" : "rgba-grey-slight"}"></div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="p-0 m-0">
                                `;
                            });
                            searchResult += `</div>`;
                            $("#salesorder-item-search").empty().html(searchResult);
                            isSpinnerOnItem = false;
                            itemSearchCountRow();
                            itemSearchSelect();

                            $("#itemSearchCurrentPageNum").focusout(function () {
                                itemSearchResults(parseInt($(this).val()));
                            })
                        }
                    },
                    error: function (e) {
                        failedMessage("Failed", "Unexpected error occur : " + e);
                    }
                });
            }, 1000);

        } else {
            $("#salesorder-item-search").empty().removeClass("border");
            isSpinnerOnItem = false;
        }
    }

    function itemSearchSelect() {
        $(".item-search-results").click(function () {
            var isItemSoldOut = $(this).data("issoldout");
            $("#salesorder-item-search").empty().removeClass("border");
            $("#salesorder-search-item").val("");
            $.ajax({
                type: "POST",
                url: "./backend/invoice/viewCustmrItem.php",
                data: {
                    postType: "searchRowItemAdd",
                    itemID: $(this).data("id")
                },
                success: function (results) {
                    var item_results;
                    var item_id = [];
                    var itemID;
                    //if (!isItemSoldOut) {
                    $.each($(".update-item-row"), function (i, v) {
                        item_id.push($(`.update-item-row:eq(${i})`).data("id"))
                    });
                    $.each(JSON.parse(results), function (i, value) {
                        itemID = value.item_id;
                        //if (value.qty_available > 0) {
                        //   isItemSoldOut = false;

                        if ($.inArray(value.item_id, item_id) > -1) {
                            var itemQty = $('[data-id=' + value.item_id + ']').find(".itemQuantity").val();
                            $('[data-id=' + value.item_id + ']').find(".itemQuantity").val((parseInt(itemQty) + 1));
                            return false;
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
                                    <td>
                                        <input type="number" class="form-control itemQuantity" min="1" value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control itemUnit" value="unit">
                                    </td>
                                    <td class="selling_price">${value.selling_price1}</td>
                                    <td>
                                        <input type="number" class="form-control itemDiscount" value="0" min="0" max="100" step="1">
                                    </td>
                                    <td class="total_price"></td>
                                </tr>
                                `;
                        }
                    });
                    //} else {
                    //    isItemSoldOut = true;
                    //}

                    //if (isItemSoldOut == false) {
                    if ($("#salesorder-item-bucket").find(".salesorder-noResultText").length > 0) {
                        $("#salesorder-item-bucket").empty();
                    }

                    if (item_results != "") {
                        $("#salesorder-item-bucket").append(item_results);
                    }

                    itemBucketTotalPrice(itemID);
                    itemBucketTotalDiscount();
                    itemBucketTotalCost();
                    salespaymentCalculation();

                    $(".itemQuantity").change(function () {
                        if ($(this).val() > parseInt($(this).attr("max"))) {
                            $(this).val($(this).attr("max"));
                        }

                        if ($(this).val() < parseInt($(this).attr("min"))) {
                            $(this).val($(this).attr("min"));
                        }
                        itemBucketTotalPrice($(this).closest("tr").data("id"));
                        itemBucketTotalDiscount()
                        itemBucketTotalCost();

                    })

                    $(".itemDiscount").change(function () {
                        if ($(this).val() > parseInt($(this).attr("max"))) {
                            $(this).val($(this).attr("max"));
                        }

                        if ($(this).val() < parseInt($(this).attr("min"))) {
                            $(this).val($(this).attr("min"));
                        }

                        itemBucketTotalPrice($(this).closest("tr").data("id"));
                        itemBucketTotalDiscount()
                        itemBucketTotalCost();

                    });
                    //}
                    itemBucketRemoveItem();
                    $("#salespayment_totalCharge").empty().text($("#salesorder-total_cost").text());

                    // } else {
                    //     $("#salesorder-item-search").empty().removeClass("border");
                    //     $("#salesorder-search-item").val("");
                    //     failedMessage("Failed", "Item is sold out");
                    // }

                },
                error: function (e) {
                    failedMessage("Failed", "Unexpected error occur : " + e);
                }
            });
        })
    }

    function itemBucketTotalPrice(itemID) {
        var itemQuantity = $("[data-id='" + itemID + "']").find(".itemQuantity").val();
        var discountAmount = $("[data-id='" + itemID + "']").find(".itemDiscount").val();
        var itemPrice = $("[data-id='" + itemID + "']").find(".selling_price").text();

        if (discountAmount > 0) {
            itemPrice = itemPrice - (itemPrice * (discountAmount / 100));
        }
        $("[data-id='" + itemID + "']").find(".total_price").text((itemQuantity * itemPrice).toFixed(2));

    }

    function itemBucketTotalCost() {
        var totalCost = 0.0;
        $.each($(".item-row"), function (i, value) {
            var totalPrice = $(".item-row:nth-child(" + (i + 1) + ")").find(".total_price").text();
            totalCost += parseFloat(totalPrice);
        })
        $("#salesorder-total_cost, #salespayment_totalCharge").empty().html(totalCost.toFixed(2));
        if (parseFloat($("#salespayment_amountPaid").text()) > parseFloat($("#salespayment_totalCharge").text())) {
            $("#salespayment_exchange").empty().text((parseFloat($("#salespayment_amountPaid").text()) - parseFloat($("#salespayment_totalCharge").text())).toFixed(2));
        }
    }

    function itemBucketTotalDiscount() {
        var totalDiscount = 0.0;
        $.each($(".item-row"), function (i, value) {
            var unit_price = $(".item-row:nth-child(" + (i + 1) + ")").find(".selling_price").text();
            var quantity = $(".item-row:nth-child(" + (i + 1) + ")").find(".itemQuantity").val();
            var discount = $(".item-row:nth-child(" + (i + 1) + ")").find(".itemDiscount").val();
            if (discount > 0) {
                totalDiscount += (unit_price * (discount / 100)) * quantity;
            }
        })
        $("#salesorder-total_discount").empty().html(totalDiscount.toFixed(2));
    }

    function itemBucketRemoveItem() {

        $(".deleteItemBtn").click(function () {
            $(this).closest("tr").remove();

            if ($.trim($("#salesorder-item-bucket").html()).length == 0) {
                $("#salesorder-item-bucket").html(`
                    <tr class="salesorder-noResultText">
                        <td colspan="9" class="text-center">
                            <h5>No item added yet</h5>
                        </td>
                    </tr>
                `);
            }
        });
    }

    function itemSearchPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#itemSearchPageTotal").empty().text(totalPage);
        $("#itemSearchCurrentPageNum").attr("max", totalPage);

        $("#itemSearchCurrentPageNum").on('input', function () {
            if ($("#itemSearchCurrentPageNum").val() == "") {
                console.log("empty item search");
            } else if ($("#itemSearchCurrentPageNum").val() < totalPage)
                itemSearchResults($("#itemSearchCurrentPageNum").val());
            else
                itemSearchResults(totalPage);
        })
    }

    function itemSearchCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountItem",
                search: $("#salesorder-search-item").val()
            },
            success: function (results) {
                $("#itemSearchRowTotal").empty().html(results);
                itemSearchPagination(results);
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });
    }


    //Customer Search Function for Update Modal
    function updateCustomerSearchResults(pageNum) {
        var timer;
        var searchResult;

        if ($("#salesorder-update-search-customer_name").val() != "") {
            clearTimeout(timer);
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowCustomer",
                        searchCustomerName: $("#salesorder-update-search-customer_name").val(),
                        searchCustomerID: $("#salesorder-update-search-customer_id").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOnCustomerUpdate == true) {
                                $("#salesorder-update-customer-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>
                                    </div>
                                </div>
                                `);
                                isSpinnerOnCustomerUpdate = false;
                            }
                        } else if (results == "") {
                            $("#salesorder-update-customer-search").empty().removeClass("border");
                            isSpinnerOnCustomerUpdate = false;
                        } else {
                            searchResult = `
                            <div class="sticky-top bg-white">
                                <div class="row px-3 py-2">
                                    <div class=" col-6 py-2 py-md-0">
                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="updatecustomerSearchRowTotal"></span></p>
                                    </div>
                                    <div class=" col-6 py-2 py-md-0">
                                        <div class="d-flex flex-row justify-content-end">
                                            <p class="my-auto">Page : </p>
                                            <input type="number" id="updatecustomerSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="updatecustomerSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;
                            $.each(JSON.parse(results), function (i, value) {
                                searchResult += `
                                <a class="update-customer-search-results">
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
                            $("#salesorder-update-customer-search").empty().html(searchResult);
                            isSpinnerOnCustomerUpdate = false;
                            updateCustomerSearchCountRow();
                            updateCustomerSearchSelect();
                        }
                    },
                    error: function (e) {
                        failedMessage("Failed", "Unexpected error occur : " + e);
                    }
                });
            }, 1000);
        } else {
            $("#salesorder-update-customer-search").empty().removeClass("border");
            isSpinnerOnCustomerUpdate = false;
        }
    }

    function updateCustomerSearchSelect() {
        $(".update-customer-search-results").click(function () {
            $("#salesorder-update-search-customer_name").val($(this).find(".customerName").text());
            $("#salesorder-update-search-customer_id").val($(this).find(".customerID").text());
            $("#salesorder-update-customer-search").empty().removeClass("border");
        });
    }

    function updateCustomerSearchPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#updatecustomerSearchPageTotal").empty().text(totalPage);
        $("#updatecustomerSearchCurrentPageNum").attr("max", totalPage);

        $("#updatecustomerSearchCurrentPageNum").on('input', function () {
            if ($("#updatecustomerSearchCurrentPageNum").val() == "") {
                console.log("Empty update customer search");
            } else if ($("#updatecustomerSearchCurrentPageNum").val() < totalPage)
                updateCustomerSearchResults($("#updatecustomerSearchCurrentPageNum").val());
            else
                updateCustomerSearchResults(totalPage);
        })
    }

    function updateCustomerSearchCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountCustomer",
                searchCustomerName: $("#salesorder-update-search-customer_name").val(),
                searchCustomerID: ""
            },
            success: function (results) {
                $("#updateCustomerSearchRowTotal").empty().html(results);
                updateCustomerSearchPagination(results);
            }
        });
    }

    function salespaymentCalculation() {
        $("#salespayment-amount_apply").change(function () {
            var amount = (parseFloat($(this).val())).toFixed(2);
            $(this).val(amount);
            $("#salespayment_amountPaid").empty().text(amount);

            var amountPaid = parseFloat($("#salespayment_amountPaid").text());
            var totalCharge = parseFloat($("#salespayment_totalCharge").text())
            if (amountPaid > totalCharge) {
                $("#salespayment_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
            } else {
                $("#salespayment_exchange").empty().text("0.00");
            }
        })
    }


    // Item Search Function for Update Modal
    function updateItemSearchResults(pageNum) {
        var timer;
        var searchResult;

        if ($("#salesorder-update-search-item").val() != "") {
            clearTimeout(timer);
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowItem",
                        search: $("#salesorder-update-search-item").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOnItemUpdate == true) {
                                $("#salesorder-update-item-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./itemMaintenance.php">Go add new item</a>
                                    </div>
                                </div>
                                `);
                                isSpinnerOnItemUpdate = false;
                            }
                        } else if (results == "") {
                            $("#salesorder-update-item-search").empty().removeClass("border");
                            isSpinnerOnItemUpdate = false;
                        } else {
                            searchResult = `
                            <div class="sticky-top bg-white">
                                <div class="row px-3 py-2 ">
                                    <div class=" col-6 py-2 py-md-0">
                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="updateitemSearchRowTotal"></span></p>
                                    </div>
                                    <div class=" col-6 py-2 py-md-0">
                                        <div class="d-flex flex-row justify-content-end">
                                            <p class="my-auto">Page : </p>
                                            <input type="number" id="updateitemSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="updateitemSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;
                            $.each(JSON.parse(results), function (i, value) {
                                if (value.qty_available == 0) {
                                    isItemSoldOut = true
                                } else {
                                    isItemSoldOut = false;
                                }
                                searchResult += `
                                <a class="update-item-search-results" data-id="${value.item_id}" data-issoldout="${isItemSoldOut}">
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
                            $("#salesorder-update-item-search").empty().html(searchResult);

                            isSpinnerOnItemUpdate = false;
                            updateItemSearchCountRow();
                            updateItemSearchSelect();
                        }
                    },
                    error: function (e) {
                        failedMessage("Failed", "Unexpected error occur : " + e);
                    }
                });
            }, 1000);
        } else {
            $("#salesorder-update-item-search").empty().removeClass("border");
            isSpinnerOnItemUpdate = false;
        }
    }

    function updateItemSearchSelect() {
        $(".update-item-search-results").click(function () {
            // var isItemSoldOut = $(this).data("issoldout");
            $("#salesorder-update-item-search").empty().removeClass("border");
            $("#salesorder-update-search-item").val("");
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
                    var item_id = [];
                    //if (!isItemSoldOut) {
                    $.each($(".update-item-row"), function (i, v) {
                        item_id.push($(`.update-item-row:eq(${i})`).data("id"))
                    });
                    $.each(JSON.parse(results), function (i, value) {
                        itemID = value.item_id;
                        //if (value.qty_available > 0) {
                        //isItemSoldOut = false;

                        if ($.inArray(value.item_id, item_id) > -1) {
                            var itemQty = $('[data-id=' + value.item_id + ']').find(".update-itemQuantity").val();
                            $('[data-id=' + value.item_id + ']').find(".update-itemQuantity").val((parseInt(itemQty) + 1));

                        } else {

                            item_results += `
                                    <tr class="update-item-row" data-id="${value.item_id}">
                                        <td>
                                            <button class="btn btn-danger update-deleteItemBtn py-md-3 px-md-4 p-sm-3">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                        <td class="update-item_no">${value.item_no}</td>
                                        <td class="update-description">${value.description}</td>
                                        <td>
                                            <input type="number" class="form-control update-itemQuantity" min="1 value="1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control update-itemUnit" value="unit">
                                        </td>
                                        <td class="update-selling_price">${value.selling_price1}</td>
                                        <td>
                                            <input type="number" class="form-control update-itemDiscount" value="0" min="0" max="100" step="1">
                                        </td>
                                        <td class="update-total_price"></td>
                                    </tr>
                                    `;
                        }

                        //} else {
                        //    isItemSoldOut = true;
                        //}
                    })
                    //if (isItemSoldOut == false) {
                    if ($("#salesorder-update-item-bucket").find(".salesorder-update-noResultText").length > 0) {
                        $("#salesorder-update-item-bucket").empty();
                    }
                    if (item_results != "") {
                        $("#salesorder-update-item-bucket").append(item_results);
                    }

                    updateitemBucketTotalPrice(itemID);
                    updateitemBucketTotalDiscount();
                    updateitemBucketTotalCost();
                    $("#salesorder-update-amount_apply").change(function () {
                        var amount = (parseFloat($(this).val())).toFixed(2);
                        $(this).val(amount);
                        console.log("in updateitem select", (parseFloat($(this).val())).toFixed(2))
                        $("#update-salesorder_amountPaid").empty().text();

                        var amountPaid = parseFloat($("#update-salesorder_amountPaid").text());
                        var totalCharge = parseFloat($("#update-salesorder_totalCharge").text())
                        if (amountPaid > totalCharge) {
                            $("#update-salesorder_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
                        } else {
                            $("#update-salesorder_exchange").empty().text("0.00");
                        }
                    })

                    $(".update-itemQuantity").change(function () {
                        if ($(this).val() > parseInt($(this).attr("max"))) {
                            $(this).val($(this).attr("max"));
                        }

                        if ($(this).val() < parseInt($(this).attr("min"))) {
                            $(this).val($(this).attr("min"));
                        }
                        updateitemBucketTotalPrice($(this).closest("tr").data("id"));
                        updateitemBucketTotalDiscount();
                        updateitemBucketTotalCost();

                    });

                    $(".update-itemDiscount").change(function () {
                        if ($(this).val() > parseInt($(this).attr("max"))) {
                            $(this).val($(this).attr("max"));
                        }

                        if ($(this).val() < parseInt($(this).attr("min"))) {
                            $(this).val($(this).attr("min"));
                        }

                        updateitemBucketTotalPrice($(this).closest("tr").data("id"));
                        updateitemBucketTotalDiscount();
                        updateitemBucketTotalCost();

                    });
                    //}
                    updateitemBucketRemoveItem();
                    // } else {
                    //     $("#salesorder-update-item-search").empty().removeClass("border");
                    //     $("#salesorder-update-search-item").val("");
                    //     failedMessage("Failed", "Item is sold out");
                    // }
                }
            });
        });
    }

    function updateitemBucketTotalPrice(itemID) {
        var itemQuantity = $("[data-id='" + itemID + "']").find(".update-itemQuantity").val();
        var discountAmount = $("[data-id='" + itemID + "']").find(".update-itemDiscount").val();
        var itemPrice = $("[data-id='" + itemID + "']").find(".update-selling_price").text();
        if (discountAmount > 0) {
            itemPrice = itemPrice - (itemPrice * (discountAmount / 100));
        }
        $("[data-id='" + itemID + "']").find(".update-total_price").text((itemQuantity * itemPrice).toFixed(2));
    }

    function updateitemBucketTotalCost() {
        var totalCost = 0.0;

        $.each($(".update-item-row"), function (i, value) {
            var totalPrice = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-total_price").text();
            totalCost += parseFloat(totalPrice);
        })
        $("#salesorder-update-total_cost").empty().html(totalCost.toFixed(2));
        $("#update-salesorder_totalCharge").empty().text(totalCost.toFixed(2));

        if (parseFloat($("#update-salespayment_amountPaid").text()) > parseFloat($("#update-salespayment_totalCharge").text())) {
            $("#update-salespayment_exchange").empty().text((parseFloat($("#update-salespayment_amountPaid").text()) - parseFloat($("#update-salespayment_totalCharge").text())).toFixed(2));
        }

    }

    function updateitemBucketTotalDiscount() {
        var totalDiscount = 0.0;

        $.each($(".update-item-row"), function (i, value) {
            var unit_price = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-selling_price").text();
            var quantity = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemQuantity").val();
            var discount = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemDiscount").val();

            if (discount > 0) {
                totalDiscount += (unit_price * (discount / 100)) * quantity;
            }

        })


        $("#salesorder-update-total_discount").empty().html(totalDiscount.toFixed(2));
    }

    function updateitemBucketRemoveItem() {

        $(".update-deleteItemBtn").click(function () {

            $(this).closest("tr").remove();

            if ($.trim($("#salesorder-update-item-bucket").html()).length == 0) {
                $("#salesorder-update-item-bucket").html(`
                    <tr class="salesorder-update-noResultText">
                        <td colspan="9" class="text-center">
                            <h5>No item added yet</h5>
                        </td>
                    </tr>
                `);
                updateitemBucketTotalDiscount();
                updateitemBucketTotalCost();
                $("#update-salespayment_totalCharge").empty().text("0.00");
            } else {
                updateitemBucketTotalDiscount();
                updateitemBucketTotalCost();
                $("#update-salespayment_totalCharge").empty().text($("#salesorder-update-total_cost").text());
            }
        });
    }


    function updateItemSearchPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#updateitemSearchPageTotal").empty().text(totalPage);
        $("#updateitemSearchCurrentPageNum").attr("max", totalPage);

        $("#updateitemSearchCurrentPageNum").on('input', function () {
            if ($("#updateitemSearchCurrentPageNum").val() == "") {
                console.log("empty update item search");
            } else if ($("#updateitemSearchCurrentPageNum").val() < totalPage)
                updateItemSearchResults($("#updateitemSearchCurrentPageNum").val());
            else
                updateItemSearchResults(totalPage);
        })
    }

    function updateItemSearchCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountItem",
                search: $("#salesorder-update-search-item").val()
            },
            success: function (results) {
                $("#updateitemSearchRowTotal").empty().html(results);
                updateItemSearchPagination(results);
            }
        });
    }

    //add sale payment
    function addSalesPayment() {
        var customer_name = $("#salesorder-update-search-customer_name").val();
        var sale_id = $("#update-salesorder_id").val();
        var payment_method = $("#salesorder-update-payment_mode").val();
        var sale_amount = $("#update-salesorder_totalCharge").text();
        var sale_payment = $("#update-salesorder_amountPaid").text();
        var reference = $("#salesorder-update-reference").val();
        var item_id = [];
        var qty = [];

        $.each($(".update-item-row"), function (i, value) {
            item_id.push($(".update-item-row:nth-child(" + (i + 1) + ")").data("id"));
            qty.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemQuantity").val());
        });

        $.ajax({
            type: "POST",
            url: "./backend/sale/saleOnHold.php",
            data: {
                postType: "payOnHold",
                item_id: item_id,
                qty: qty,
                customer_name: customer_name,
                sale_id: sale_id,
                payment_method: payment_method,
                sale_amount: sale_amount,
                sale_payment: sale_payment,
                reference: reference,
            },
            success: function (results) {
                switch (results) {
                    case ("Some input field is not set."):
                        failedMessage("Failed", results);
                        break;

                    case ("success add payment for on-hold sale order"):
                        $("#editSalesOrderModal").modal("hide");
                        successMessage("Success", "Sale Payment is successfully paid");
                        $(".btnSuccess").click(function () {
                            location.reload();
                        })
                        break;
                }
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        })
    }


    //Add function
    function addSalesOrder(mode) {

        var salesperson = "";
        var sale_subtotal = "";
        var sale_discount_header = "";
        var sale_total_amount = "";
        var payment_method = "";
        var sale_amount = "";
        var sale_payment = "";
        var reference = "";
        var item_id = [];
        var item_no = []
        var description = [];
        var uom = [];
        var qty = [];
        var price = [];
        var discount = [];
        var amount = [];


        if ($("#salesorder-item-bucket").find(".salesorder-noResultText").length > 0) {
            failedMessage("Failed", "Item bucket is empty");
            $(".btnDismiss").click(function () {
                $("#salesorder-search-item").focus();
            })
        } else {

            salesperson = $("#salesorder-salesperson").val();
            sale_subtotal = (parseFloat($("#salesorder-total_cost").text()) + parseFloat($("#salesorder-total_discount").text())).toFixed(2);
            sale_discount_header = $("#salesorder-total_discount").text();
            sale_total_amount = $("#salesorder-total_cost").text();
            payment_method = $("#salespayment-payment_mode").val();
            sale_payment = $("#salespayment_amountPaid").text();
            sale_amount = $("#salespayment_totalCharge").text();
            reference = $("#salespayment-reference").val();

            $.each($(".item-row"), function (i, value) {
                item_id.push($(".item-row:nth-child(" + (i + 1) + ")").data("id"));
                item_no.push($(".item-row:nth-child(" + (i + 1) + ")").find(".item_no").text());
                description.push($(".item-row:nth-child(" + (i + 1) + ")").find(".description").text());
                amount.push($(".item-row:nth-child(" + (i + 1) + ")").find(".selling_price").text());
                qty.push($(".item-row:nth-child(" + (i + 1) + ")").find(".itemQuantity").val());
                price.push($(".item-row:nth-child(" + (i + 1) + ")").find(".total_price").text());
                uom.push($(".item-row:nth-child(" + (i + 1) + ")").find(".itemUnit").val());
                //base_cost.push($(".item-row:nth-child(" + (i + 1) + ")").find(".base_cost").text());
                discount.push($(".item-row:nth-child(" + (i + 1) + ")").find(".itemDiscount").val());
            });

            switch (mode) {
                case ("add"):
                    if (parseFloat($("#salespayment_amountPaid").text()) < parseFloat($("#salespayment_totalCharge").text())) {
                        failedMessage("Failed", "Amount Paid is less than Total Charge");
                    } else {


                        $.ajax({
                            type: "POST",
                            url: "./backend/sale/saleOrder.php",
                            data: {
                                postType: "add",
                                sale_salesperson: salesperson,
                                sale_subtotal: sale_subtotal,
                                sale_discount_header: sale_discount_header,
                                sale_total_amount: sale_total_amount,
                                item_id: item_id,
                                item_no: item_no,
                                description: description,
                                uom: uom,
                                qty: qty,
                                price: price,
                                discount: discount,
                                amount: amount,
                                payment_method: payment_method,
                                sale_amount: sale_amount,
                                sale_payment: sale_payment,
                                reference: reference
                            },
                            success: function (results) {
                                switch (results) {
                                    case ("Some input field is not set."):
                                        failedMessage("Failed", results);
                                        break;

                                    case ("success add"):
                                        $("#addSalesOrderModal").modal("hide");
                                        successMessage("Success", "Sale Order is successfully paid");
                                        $(".btnSuccess").click(function () {
                                            location.reload();
                                        })
                                        break;
                                }

                            },
                            error: function (e) {
                                failedMessage("Failed", "Unexpected error occur : " + e);
                            }
                        });
                    }
                    break;

                case ("onhold"):
                    $.ajax({
                        type: "POST",
                        url: "./backend/sale/saleOnHold.php",
                        data: {
                            postType: "add",
                            sale_salesperson: salesperson,
                            sale_subtotal: sale_subtotal,
                            sale_discount_header: sale_discount_header,
                            sale_total_amount: sale_total_amount,
                            item_id: item_id,
                            item_no: item_no,
                            description: description,
                            uom: uom,
                            qty: qty,
                            price: price,
                            discount: discount,
                            amount: amount
                        },
                        success: function (results) {
                            switch (results) {
                                case ("Some input field is not set."):
                                    failedMessage("Failed", results);
                                    break;

                                case ("success add"):
                                    $("#addSalesOrderModal").modal("hide");
                                    successMessage("Success", "Sale Order is successfully added and it is on hold");
                                    $(".btnSuccess").click(function () {
                                        location.reload();
                                    })
                                    break;
                            }

                        },
                        error: function (e) {
                            failedMessage("Failed", "Unexpected error occur : " + e);
                        }
                    });
                    break;
            }

        }
    }


    //Edit function
    function editSalesOrder(mode) {

        var salesperson = "";
        var sale_subtotal = "";
        var sale_discount_header = "";
        var sale_total_amount = "";
        var customer_name = "";
        var customer_account = "";
        var payment_method = "";
        var sale_amount = "";
        var sale_payment = "";
        var reference = "";
        var item_id = [];
        var item_no = []
        var description = [];
        var uom = [];
        var qty = [];
        var price = [];
        var discount = [];
        var amount = [];

        switch (mode) {
            case ("onhold"):
                if ($("#salesorder-update-item-bucket").find(".salesorder-update-noResultText").length > 0) {
                    failedMessage("Failed", "Item bucket is empty");
                    $(".btnDismiss").click(function () {
                        $("#salesorder-search-item").focus();
                    })
                } else {

                    salesperson = $("#salesorder-update-salesperson").val();
                    sale_subtotal = (parseFloat($("#salesorder-update-total_discount").text()) + parseFloat($("#salesorder-update-total_cost").text())).toFixed(2);
                    sale_discount_header = $("#salesorder-update-total_discount").text();
                    sale_total_amount = $("#salesorder-update-total_cost").text();
                    customer_name = $("#salesorder-update-search-customer_name").val();
                    customer_account = $("#salesorder-update-search-customer_id").val();
                    payment_method = $("#salesorder-update-payment_mode").val();
                    sale_payment = $("#update-salespayment_amountPaid").text();
                    sale_amount = $("#update-salespayment_totalCharge").text();
                    reference = $("#salesorder-update-reference").val();

                    $.each($(".update-item-row"), function (i, value) {
                        item_id.push($(".update-item-row:nth-child(" + (i + 1) + ")").data("id"));
                        item_no.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-item_no").text());
                        description.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-description").text());
                        amount.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-selling_price").text());
                        qty.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemQuantity").val());
                        price.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-total_price").text());
                        uom.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemUnit").val());
                        //base_cost.push($(".item-row:nth-child(" + (i + 1) + ")").find(".base_cost").text());
                        discount.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemDiscount").val());
                    });

                    $.ajax({
                        type: "POST",
                        url: "./backend/sale/saleOnHold.php",
                        data: {
                            postType: "update",
                            sale_id: $("#update-salesorder_id").val(),
                            customer_account: customer_account,
                            customer_name: customer_name,
                            sale_salesperson: salesperson,
                            sale_subtotal: sale_subtotal,
                            sale_discount_header: sale_discount_header,
                            sale_total_amount: sale_total_amount,
                            item_id: item_id,
                            item_no: item_no,
                            description: description,
                            uom: uom,
                            qty: qty,
                            price: price,
                            discount: discount,
                            amount: amount,
                            // payment_method: payment_method,
                            // sale_amount: sale_amount,
                            // sale_payment: sale_payment,
                            // reference: reference
                        },
                        success: function (results) {
                            console.log(results)
                            switch (results) {
                                case ("Some input field is not set."):
                                    $("#addSalesOrderModal").modal("hide");
                                    failedMessage("Failed", results);
                                    break;

                                case ("success edit"):
                                    $("#editSalesOrderModal").modal("hide");
                                    successMessage("Success", "Sale Order is successfully updated");
                                    $(".btnSuccess").click(function () {
                                        location.reload();
                                    })
                                    break;

                                case ("item detail not found"):
                                    failedMessage("Failed", results);
                                    break;
                            }
                        },
                        error: function (e) {
                            failedMessage("Failed", "Unexpected error occur : " + e);
                        }
                    });
                }
                break;

            case ("update"):
                if ($("#salesorder-update-item-bucket").find(".salesorder-update-noResultText").length > 0) {
                    failedMessage("Failed", "Item bucket is empty");

                } else {

                    salesperson = $("#salesorder-update-salesperson").val();
                    sale_subtotal = (parseFloat($("#salesorder-update-total_discount").text()) + parseFloat($("#salesorder-update-total_cost").text())).toFixed(2);
                    sale_discount_header = $("#salesorder-update-total_discount").text();
                    sale_total_amount = $("#salesorder-update-total_cost").text();
                    customer_name = $("#salesorder-update-search-customer_name").val();
                    customer_account = $("#salesorder-update-search-customer_id").val();
                    payment_method = $("#salesorder-update-payment_mode").val();
                    sale_payment = $("#update-salespayment_amountPaid").text();
                    sale_amount = $("#update-salespayment_totalCharge").text();
                    reference = $("#salesorder-update-reference").val();

                    $.each($(".update-item-row"), function (i, value) {
                        item_id.push($(".update-item-row:nth-child(" + (i + 1) + ")").data("id"));
                        item_no.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-item_no").text());
                        description.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-description").text());
                        amount.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-selling_price").text());
                        qty.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemQuantity").val());
                        price.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-total_price").text());
                        uom.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemUnit").val());
                        //base_cost.push($(".item-row:nth-child(" + (i + 1) + ")").find(".base_cost").text());
                        discount.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemDiscount").val());
                    });

                    $.ajax({
                        type: "POST",
                        url: "./backend/sale/saleOrder.php",
                        data: {
                            postType: "update",
                            sale_id: $("#update-salesorder_id").val(),
                            customer_account: customer_account,
                            customer_name: customer_name,
                            sale_salesperson: salesperson,
                            sale_subtotal: sale_subtotal,
                            sale_discount_header: sale_discount_header,
                            sale_total_amount: sale_total_amount,
                            item_id: item_id,
                            item_no: item_no,
                            description: description,
                            uom: uom,
                            qty: qty,
                            price: price,
                            discount: discount,
                            amount: amount,
                            payment_method: payment_method,
                            sale_amount: sale_amount,
                            sale_payment: sale_payment,
                            reference: reference
                        },
                        success: function (results) {
                            switch (results) {
                                case ("Some input field is not set."):
                                    $("#addSalesOrderModal").modal("hide");
                                    failedMessage("Failed", results);
                                    break;

                                case ("success edit"):
                                    $("#editSalesOrderModal").modal("hide");
                                    successMessage("Success", "Sale Order is successfully updated");
                                    $(".btnSuccess").click(function () {
                                        location.reload();
                                    })
                                    break;

                                case ("item detail not found"):
                                    failedMessage("Failed", results);
                                    break;
                            }
                        },
                        error: function (e) {
                            failedMessage("Failed", "Unexpected error occur : " + e);
                        }
                    });
                }
                break;
        }
    }

    //Delete function
    function deleteSalesOrder() {

        $.ajax({
            type: "POST",
            url: "./backend/sale/saleOnHold.php",
            data: {
                postType: "delete",
                sale_id: $("#delete_id").val()
            },
            success: function (results) {
                switch (results) {
                    case ("success delete"):
                        $("#deleteSalesOrderModal").modal("hide");
                        successMessage("Success", "Sale Order is successfully deleted");
                        $(".btnSuccess").click(function () {
                            location.reload();
                        })
                        break;

                    case ("id not found"):
                        $("#deleteSalesOrderModal").modal("hide");
                        failedMessage("Failed", results);
                        break;

                    case ("Some input field is not set."):
                        $("#deleteSalesOrderModal").modal("hide");
                        failedMessage("Failed", results);
                        break;
                }
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });
    }

    function viewSalesOrderDetail(button) {


        $.ajax({
            type: "POST",
            url: "./backend/sale/salePayment.php",
            data: {
                postType: "viewSalePaymentDetail",
                sale_id: $(button).parent().parent().data("salesorder-id")
            },
            success: function (results) {
                var data = JSON.parse(results);
                var salesOrder_results = "";
                var total_amount = 0;
                var total_discount = 0;
                console.log(data);
                $.each(data[2], function (i, item) {

                    $("#salepaymentdetail-sale_payment_date").empty().text(item.sale_payment_date);
                    $("#salepaymentdetail-sale_payment_time").empty().text(item.sale_payment_time);
                    $("#salepaymentdetail-payment_method").empty().text(item.payment_method);
                    $("#salepaymentdetail-reference").empty().text(item.reference);
                    $("#update-salespayment_amountPaid-detail").empty().text(item.sale_payment);
                    $("#update-salespayment_totalCharge-detail").empty().text(item.sale_amount);
                    $("#update-salespayment_exchange-detail").empty().text(parseFloat(item.sale_payment) - parseFloat(item.sale_amount) > 0 ? (parseFloat(item.sale_payment) - parseFloat(item.sale_amount)).toFixed(2) : "0.00")
                });

                $.each(data[0], function (i, item) {

                    $("#saleorderdetail-sale_id").empty().text(item.sale_id);
                    $("#saleorderdetail-customer_account").empty().text(item.customer_account);
                    $("#saleorderdetail-customer_name").empty().text(item.customer_name);
                    $("#saleorderdetail-sale_salesperson").empty().text(item.sale_salesperson);
                    $("#saleorderdetail-sale_subtotal").empty().text(item.sale_subtotal);
                    $("#saleorderdetail-sale_discount_header").empty().text((parseFloat(item.sale_discount_header)).toFixed(2));
                    $("#saleorderdetail-sale_total_amount").empty().text(item.sale_total_amount);
                });

                $.each(data[1], function (i, item) {

                    if (item == "No Result") {
                        failedMessage("Failed", "Could not find any sale order");
                    } else {
                        total_discount += parseFloat(item.amount) * (parseFloat(item.discount) / 100);
                        total_amount += parseFloat(item.price);
                        salesOrder_results += `
                            <tr>
                                <td>${item.item_no}</td>
                                <td>${item.description}</td>
                                <td>${item.qty}</td>
                                <td>${item.uom}</td>
                                <td>${item.amount}</td>
                                <td>${parseInt(item.discount)}</td>
                                <td>${item.price}</td>
                            </tr>
                            `;
                    }
                });
                $("#salesorderdetail-item-bucket").empty().html(salesOrder_results);
                $("#saleorderdetail-total_discount").empty().text(total_discount.toFixed(2));
                $("#saleorderdetail-total_cost").empty().text(total_amount.toFixed(2));
                $("#salesOrderDetailModal").modal("show");
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        })
    }

    //Message
    function failedMessage(headline, body) {
        $("#failedToModal").modal("show");
        $("#failedModalHeadline").empty().append(headline);
        $("#failedModalBody").empty().append(body);
    }

    function successMessage(headline, body) {
        $("#successModalHeadline").empty().append(headline);
        $("#successModalBody").empty().append(body);
        $('#successToModal').modal('show');
    }

    //Generate Main Table function
    function countRow() {
        var totalRowCount;
        $.ajax({
            type: "POST",
            url: "./backend/sale/saleOrder.php",
            data: {
                postType: "countRow",
            },
            async: false,
            success: function (results) {
                $("#salesorder-rowTotal").empty().append(results);
                totalRowCount = results;
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });
        return totalRowCount;
    }

    function paginate(total) {
        var rowperpage = 20;
        var totalPage = Math.ceil(total / rowperpage);
        $("#salesorder-pageTotal").empty().text(totalPage);

        if ($("#salesorder-currentPageNum").val() > totalPage) {
            $("#salesorder-currentPageNum").val(totalPage);
        }

        return totalPage;
    }

    function generateTable() {
        salesordertotalRow = countRow();
        salesordertotalPage = paginate(salesordertotalRow);
        var currentPageNum;
        var postType = "viewSaleHeader";
        var url = "./backend/sale/saleOrder.php";
        var current_filter = $("input[name='showingsalesordermode']:checked").val();

        switch (current_filter) {
            case ("paid"):
                postType = "viewSaleHeader";
                url = "./backend/sale/saleOrder.php";
                break;
            case ("onhold"):
                postType = "viewSaleHeaderOnHold"
                url = "./backend/sale/saleOnHold.php"
                break;

        }

        if ($("#salesorder-currentPageNum").val() != 0) {
            if ($("#salesorder-currentPageNum").val() > salesordertotalPage) {
                currentPageNum = salesordertotalPage;
            } else {
                currentPageNum = $("#salesorder-currentPageNum").val();
            }
        } else {
            currentPageNum = 1;
        }

        $("#salesorder-currentPageNum").val(currentPageNum);

        $.ajax({
            type: "POST",
            url: url,
            data: {
                postType: postType,
                pageNum: currentPageNum
            },
            success: function (results) {
                if (results == "0 results" || results == "No Result") {
                    renderTable("salesorder");
                    tableSetting("salesorder");
                } else {
                    //results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(JSON.parse(results), "salesorder");
                    $(".viewSalesOrderDetailBtn").click(function () {
                        viewSalesOrderDetail($(this));
                    })
                    //Update Sales Order Button
                    $(".editSalesOrderBtn").click(function () {
                        var salesorder = $(this).parent().parent().data("salesorder-id");
                        var tag = $(this).parent().parent();
                        var isPaid = false;
                        switch (tag.find(".payment_status").text()) {
                            case ("Unpaid"):
                                isPaid = false;
                                break;

                            case ("Paid"):
                                isPaid = true;
                                break;
                        }
                        // $("#salesorder-update-payment_mode").val();
                        // $("#update-salespayment_amountPaid").empty().text();
                        $("#update-salesorder_totalCharge").empty().text(tag.find(".sale_total_amount").text());
                        // $("#update-salespayment_exchange").empty().text();
                        $("#update-salesorder_id").val(salesorder);
                        $("#salesorder-update-search-customer_name").val(tag.find(".customer_name").text());
                        $("#salesorder-update-search-customer_id").val(tag.find(".customer_account").text())
                        //$("#salesorder-update-payment_mode").val(tag.find(".payment_mode").text());
                        $("#salesorder-update-salesperson").val(tag.find(".sale_salesperson").text());
                        $("#update-salesorder_payment_status").val(tag.find(".payment_status").text());
                        $("#update-salesorder_isOnHold").val(tag.find(".isOnHold").text());
                        $("#salesorder-update-reference").val(tag.data("reference"));

                        switch (tag.find('.isOnHold').text()) {
                            case ("Yes"):
                                $("#editonholdSalesOrderSubmitBtn").attr("disabled", false);
                                break;

                            case ("No"):
                                $("#editonholdSalesOrderSubmitBtn").attr("disabled", true);
                                break;
                        }

                        if (isPaid) {
                            $("#salesorder-update-search-customer_name").attr("readonly", true);
                            $("#salesorder-update-payment_mode").attr("readonly", true);
                            $("#salesorder-update-salesperson").attr("readonly", true);
                            $("#salesorder-update-search-item").attr("readonly", true);
                        } else {
                            $("#salesorder-update-search-customer_name").attr("readonly", false);
                            $("#salesorder-update-payment_mode").attr("readonly", false);
                            $("#salesorder-update-salesperson").attr("readonly", false);
                            $("#salesorder-update-search-item").attr("readonly", false);
                        }

                        $.ajax({
                            type: "POST",
                            url: "./backend/sale/saleOrder.php",
                            data: {
                                postType: "viewDetail",
                                search: salesorder
                            },
                            success: function (results) {

                                var item_results;
                                var totalCost = 0;
                                var totalDiscount = 0;
                                var max_quantity = 0;
                                if (results == "No Result") {
                                    failedMessage("Failed", "No sales order detail found");
                                } else {
                                    $.each(JSON.parse(results), function (i, value) {

                                        var discount = (value.discount == 0 ? 100 : value.discount) / 100;
                                        var discountPrice = discount == 1 ? 0 : (value.amount * discount) * value.qty;
                                        var newPrice = (value.amount * value.qty) - discountPrice;
                                        totalCost += newPrice;
                                        totalDiscount += discountPrice;
                                        $.ajax({
                                            type: "POST",
                                            url: "./backend/invoice/viewCustmrItem.php",
                                            data: {
                                                postType: "searchRowItemGetQuantity",
                                                itemID: value.item_id
                                            },
                                            async: false,
                                            success: function (results) {
                                                max_quantity = parseInt(results);
                                            },
                                            error: function (e) {
                                                console.log(e);
                                            }
                                        })
                                        item_results += `
                                        <tr class="update-item-row" data-id="${value.item_id}">
                                            <td>
                                                <button class="btn ${isPaid ? "btn-light" : "btn-danger update-deleteItemBtn"} py-md-3 px-md-4 p-sm-3">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                            <td class="update-item_no">${value.item_no}</td>    
                                            <td class="update-description">${value.description}</td>
                                            <td>
                                                <input ${isPaid ? "readonly" : ""} type="number" class="form-control update-itemQuantity" min="1" value="${value.qty}">
                                            </td>
                                            <td>
                                                <input ${isPaid ? "readonly" : ""} type="text" class="form-control update-itemUnit" placeholder="unit" val="${value.uom}">
                                            </td>
                                            <td class="update-selling_price">${value.amount}</td>
                                            <td>
                                                <input ${isPaid ? "readonly" : ""} type="number" class="form-control update-itemDiscount" value="${value.discount}" min="0" max="100" step="1">
                                            </td>
                                            <td class="update-total_price">${ newPrice.toFixed(2) }</td>
                                        </tr>
                                        `;
                                    });


                                    $("#salesorder-update-item-bucket").empty().append(item_results);
                                    $("#salesorder-update-total_discount").empty().text(totalDiscount.toFixed(2));
                                    $("#salesorder-update-total_cost").empty().text(totalCost.toFixed(2));
                                    $(".update-deleteItemBtn").click(function () {

                                        $(this).closest("tr").remove();

                                        if ($.trim($("#salesorder-update-item-bucket").html()).length == 0) {
                                            $("#salesorder-update-item-bucket").html(`
                                                <tr class="salesorder-update-noResultText">
                                                    <td colspan="9" class="text-center">
                                                        <h5>No item added yet</h5>
                                                    </td>
                                                </tr>
                                            `);
                                            updateitemBucketTotalDiscount();
                                            updateitemBucketTotalCost();
                                            $("#update-salespayment_totalCharge").empty().text("0.00");
                                        } else {
                                            updateitemBucketTotalDiscount();
                                            updateitemBucketTotalCost();
                                            $("#update-salespayment_totalCharge").empty().text($("#salesorder-update-total_cost").text());
                                        }
                                    });

                                    $(".update-itemQuantity").change(function () {
                                        if ($(this).val() > parseInt($(this).attr("max"))) {
                                            $(this).val($(this).attr("max"));
                                        }

                                        if ($(this).val() < parseInt($(this).attr("min"))) {
                                            $(this).val($(this).attr("min"));
                                        }
                                        updateitemBucketTotalPrice($(this).closest("tr").data("id"));
                                        updateitemBucketTotalDiscount();
                                        updateitemBucketTotalCost();

                                    });

                                    $(".update-itemDiscount").change(function () {

                                        if ($(this).val() > parseInt($(this).attr("max"))) {
                                            $(this).val($(this).attr("max"));
                                        }

                                        if ($(this).val() < parseInt($(this).attr("min"))) {
                                            $(this).val($(this).attr("min"));
                                        }

                                        updateitemBucketTotalPrice($(this).closest("tr").data("id"));
                                        updateitemBucketTotalDiscount();
                                        updateitemBucketTotalCost();

                                    });

                                    $("#salesorder-update-amount_apply").focusout(function () {
                                        var amount = (parseFloat($(this).val())).toFixed(2);
                                        $(this).val(amount);
                                        console.log("in on click edit button", $(this).val())
                                        $("#update-salesorder_amountPaid").empty().html($(this).val());

                                        var amountPaid = parseFloat($("#update-salesorder_amountPaid").text());
                                        var totalCharge = parseFloat($("#update-salesorder_totalCharge").text())
                                        if (amountPaid > totalCharge) {
                                            $("#update-salesorder_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
                                        } else {
                                            $("#update-salesorder_exchange").empty().text("0.00");
                                        }
                                    })
                                }
                            },
                            error: function (e) {
                                failedMessage("Failed", "Unexpected error occur : " + e);
                            }
                        });
                    })

                    //Delete Sales Order Button
                    $(".deleteSalesOrderBtn").click(function () {
                        var salesorder_id = $(this).parent().parent().data("salesorder-id");
                        var tag = $(this).parent().parent();
                        $("#salesorderDelete_isPaid").val(tag.find(".payment_status").text());
                        $("#delete_id").val(salesorder_id);
                        $("#deleteSalesOrderName").text(salesorder_id);
                        $("#salesorderDelete_isOnHold").val(tag.find(".isOnHold").text());
                    })

                }
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        })
    }

    function tableSetting(type) {
        switch (type) {
            case ("salesorder"):

                var table = $('#salesorderTable').DataTable({
                    searching: false,
                    paginate: false,
                    lengthChange: false,
                    info: false,
                    scrollX: true,
                    scrollY: '1000px',
                    scrollCollapse: true
                }).columns.adjust();

                $('.dataTables_length').addClass('bs-select');
                break;

        }
    }

    function renderTable(type) {
        switch (type) {
            case ("salesorder"):

                $("#salesorder-table").empty().append(
                    '<table id="salesorderTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Sale ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Sale Time</th> ' +
                    ' <th scope="col" class="th-lg">Sale Date</th> ' +
                    ' <th scope="col" class="th-lg">Sale Phone Number</th> ' +
                    ' <th scope="col" class="th-lg">Saleperson</th> ' +
                    ' <th scope="col" class="th-lg">Sale Subtotal</th> ' +
                    ' <th scope="col" class="th-lg">Sale Total Discount</th> ' +
                    ' <th scope="col" class="th-lg">Sale Total Amount</th> ' +
                    ' <th scope="col" class="th-lg">Payment Status</th> ' +
                    ' <th scope="col" class="th-lg">Is On Hold ?</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="salesorderContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Sale ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Sale Time</th> ' +
                    ' <th scope="col" class="th-lg">Sale Date</th> ' +
                    ' <th scope="col" class="th-lg">Sale Phone Number</th> ' +
                    ' <th scope="col" class="th-lg">Saleperson</th> ' +
                    ' <th scope="col" class="th-lg">Sale Subtotal</th> ' +
                    ' <th scope="col" class="th-lg">Sale Total Discount</th> ' +
                    ' <th scope="col" class="th-lg">Sale Total Amount</th> ' +
                    ' <th scope="col" class="th-lg">Payment Status</th> ' +
                    ' <th scope="col" class="th-lg">Is On Hold ?</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                break;
        }
    }

    function renderContent(results, type) {
        switch (type) {
            case ("salesorder"):

                renderTable("salesorder");
                $.each(results, function (i, salesorder) {
                    var splited_time = (salesorder.creation_time).split(':')
                    var time_hour = parseInt(splited_time[0]) > 12 ? parseInt(splited_time[0]) - 12 : parseInt(splited_time[0])
                    var time_minutes = splited_time[1]
                    var time_stamp = parseInt(splited_time[0]) > 12 ? "pm" : "am"
                    var time = time_hour.toString() + ":" + time_minutes + " " + time_stamp;
                    $("#salesorderContent").append(`
                        <tr class="salesorder-row" data-salesorder-id="${salesorder.sale_id}">
                            <th>${++i}</th>
                            <td>
                                ${salesorder.payment_status == "UnPaid" ? 
                                    '<button title="Update Sales Order" class="btn btn-warning editSalesOrderBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editSalesOrderModal"><i class="fas fa-edit"></i></button>' 
                                    : 
                                    '<button title="View Sales Order Detail" class="btn btn-secondary viewSalesOrderDetailBtn py-md-3 px-md-4 p-sm-3"><i class="fas fa-file-invoice"></i> </button>'
                                }
                                ${salesorder.payment_status == "UnPaid" ? '<button title="Delete Sales Order" class="btn btn-danger deleteSalesOrderBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteSalesOrderModal"><i class="fas fa-trash-alt"></i></button>': ''}
                            </td>
                            <td class="sale_id">${salesorder.sale_id}</td>
                            <td class="customer_account">${salesorder.customer_account}</td>
                            <td class="customer_name">${salesorder.customer_name}</td>
                            <td class="sale_time">${time}</td>
                            <td class="sale_date">${salesorder.sale_date}</td>
                            <td class="sale_phone_num">${salesorder.sale_phone_num}</td>
                            <td class="sale_salesperson">${salesorder.sale_salesperson}</td>
                            <td class="sale_subtotal">${salesorder.sale_subtotal}</td>
                            <td class="sale_discount_header">${salesorder.sale_discount_header}</td>
                            <td class="sale_total_amount">${salesorder.sale_total_amount}</td>
                            <td class="payment_status capitalize font-weight-bold ${salesorder.payment_status == "UnPaid" ? "text-danger" : "text-success"}">${salesorder.payment_status}</td>
                            <td class="isOnHold">${salesorder.isOnHold ? "Yes": "No"}</td>
                        </tr>
                    `);
                });

                tableSetting("salesorder");
                break;

        }
    }
};