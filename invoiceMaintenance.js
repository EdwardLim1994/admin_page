$(document).ready(function() {


    var totalRow = countRow();
    var totalPage = paginate(totalRow);
    generateTable();


    $("#currentPageNum").focusout(function() {
        if ($("#searchRow").val() != "") {
            searchTable();
        } else {
            generateTable();
        }
    });

    $("#search-customer_name").on('keyup', function() {
        customerSearchResults(1);
    });
    $("#search-customer_id").on('keyup', function() {
        customerSearchResults(1);
    });

    $("#search-item").on("keyup", function() {
        itemSearchResults(1);
    });

    // $("#search-customer_name").focusout(function(){
    //     $("#customer-search").hide();
    // })

    // $("#search-customer_id").focusout(function(){
    //     $("#customer-search").hide();
    // })

    // $("#search-item").focusout(function(){
    //     $("#item-search").hide()
    // })

    // $("#search-customer_name").focus(function(){
    //     if($(this).val() != "")
    //         $("#customer-search").show();
    // })

    // $("#search-customer_id").focus(function(){
    //     if($(this).val() != "")
    //         $("#customer-search").show();
    // })

    // $("#search-item").focus(function(){
    //     if($(this).val() != "")
    //         $("#item-search").show()
    // })


    $("#update-search-customer_name").on('keyup', function() {
        updatecustomerSearchResults(1);
    });
    $("#update-search-customer_id").on('keyup', function() {
        updatecustomerSearchResults(1);
    });

    $("#update-search-item").on("keyup", function() {
        updateitemSearchResults(1);
    });

    // $("#update-search-customer_name").focusout(function(){
    //     $("#update-customer-search").hide();
    // })

    // $("#update-search-customer_id").focusout(function(){
    //     $("#update-customer-search").hide();
    // })

    // $("#update-search-item").focusout(function(){
    //     $("#update-item-search").hide()
    // })

    // $("#update-search-customer_name").focus(function(){
    //     if($(this).val() != "")
    //         $("#update-customer-search").show();
    // })

    // $("#update-search-customer_id").focus(function(){
    //     if($(this).val() != "")
    //         $("#update-customer-search").show();
    // })

    // $("#update-search-item").focus(function(){
    //     if($(this).val() != "")
    //         $("#update-item-search").show()
    // })

    $("#addModalBtn").click(function() {
        $("#search-customer_name").val("");
        $("#search-customer_id").val("");
        $("#invoice_number").val("");
        $("#doc_no").val("");
        $("#invoice_date").val("");
        $("#due_date").val("");
        $("#invoice_remark").val("");
        $("#search-item").val("");

        $("#customer-search").removeClass("border").empty();
        $("#item-search").removeClass("border").empty();

        $("#item-bucket").empty().html(`
            <tr class="noResultText">
                <td colspan="9" class="text-center">
                    <h5>No item added yet</h5>
                </td>
            </tr>
        `);
    });

    $("#addInvoiceSubmitBtn").click(function() {
        addInvoice();
    });

    $("#updateInvoiceSubmitBtn").click(function() {
        updateInvoice();
    });

    $("#deleteInvoiceSubmitButton").click(function() {
        deleteInvoice();
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
            timer = setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowCustomer",
                        searchCustomerName: $("#search-customer_name").val(),
                        searchCustomerID: $("#search-customer_id").val(),
                        pageNum: pageNum
                    },
                    success: function(results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#customer-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>
                                    </div>
                                </div>
                                    
                                `);
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
                            $.each(JSON.parse(results), function(i, value) {
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
        $(".customer-search-results").click(function() {
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

        $("#customerSearchCurrentPageNum").on('input', function() {
            if ($("#customerSearchCurrentPageNum").val() == "") {
                console.log("empty customer search");
            } else if ($("#customerSearchCurrentPageNum").val() < totalPage)
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
            success: function(results) {
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

            timer = setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowItem",
                        search: $("#search-item").val(),
                        pageNum: pageNum
                    },
                    success: function(results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#item-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./itemMaintenance.php">Go add new item</a>
                                    </div>
                                </div>
                                `);
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
                            $.each(JSON.parse(results), function(i, value) {
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

    function itemSearchResultsSelect() {
        $(".item-search-results").click(function() {
            $.ajax({
                type: "POST",
                url: "./backend/invoice/viewCustmrItem.php",
                data: {
                    postType: "searchRowItemAdd",
                    itemID: $(this).data("id")
                },
                success: function(results) {
                    var item_results;
                    var isItemSoldOut = false;
                    var itemID;
                    $.each(JSON.parse(results), function(i, value) {
                            itemID = value.item_id;
                            //if (value.qty_available > 0) {
                            //   isItemSoldOut = false;
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
                                    <td>
                                        <input type="number" class="form-control itemQuantity" min="1" value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control itemUnit" value="unit">
                                    </td>
                                    <td class="selling_price">${value.selling_price1}</td>
                                    <td class="unit_cost">${value.unit_cost}</td>
                                    <td>
                                        <input type="number" class="form-control itemDiscount" value="0" min="0" max="100" step="1">
                                    </td>
                                    <td class="total_price"></td>
                                </tr>
                                `;
                            }
                            //} else {
                            //    isItemSoldOut = true;
                            //}
                        })
                        //if (isItemSoldOut == false) {
                    if ($("#item-bucket").find(".noResultText").length > 0) {
                        $("#item-bucket").empty();
                    }
                    if (item_results != "") {
                        $("#item-bucket").append(item_results);
                    }
                    $("#item-search").empty().removeClass("border");
                    $("#search-item").val("");
                    itemBucketTotalPrice(itemID);
                    itemBucketTotalDiscount();
                    itemBucketTotalCost();


                    $(".itemQuantity").change(function() {
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

                    $(".itemDiscount").change(function() {
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

        $.each($(".item-row"), function(i, value) {
            var totalPrice = $(".item-row:nth-child(" + (i + 1) + ")").find(".total_price").text();
            totalCost += parseFloat(totalPrice);
        })

        // if (parseFloat($("#total_discount").text()) > 0) {
        //     totalCost = totalCost - parseFloat($("#total_discount").text());
        // }

        $("#total_cost").empty().html(totalCost.toFixed(2));

    }

    function itemBucketTotalDiscount() {
        var totalDiscount = 0.0;

        $.each($(".item-row"), function(i, value) {
            var unit_price = $(".item-row:nth-child(" + (i + 1) + ")").find(".selling_price").text();
            var quantity = $(".item-row:nth-child(" + (i + 1) + ")").find(".itemQuantity").val();
            var discount = $(".item-row:nth-child(" + (i + 1) + ")").find(".itemDiscount").val();

            if (discount > 0) {
                totalDiscount += (unit_price * (discount / 100)) * quantity;
            }
        })
        $("#total_discount").empty().html(totalDiscount.toFixed(2));
    }

    function itemBucketRemoveItem() {

        $(".deleteItemBtn").click(function() {
            $(this).closest("tr").remove();

            if ($.trim($("#item-bucket").html()).length == 0) {
                $("#item-bucket").html(`
                    <tr class="noResultText">
                        <td colspan="9" class="text-center">
                            <h5>No item added yet</h5>
                        </td>
                    </tr>
                `);
            }
        });
    }


    function itemSearchResultsPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#itemSearchPageTotal").empty().text(totalPage);
        $("#itemSearchCurrentPageNum").attr("max", totalPage);

        $("#itemSearchCurrentPageNum").on('input', function() {
            if ($("#itemSearchCurrentPageNum").val() == "") {
                console.log("empty item search");
            } else if ($("#itemSearchCurrentPageNum").val() < totalPage)
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
            success: function(results) {
                $("#itemSearchRowTotal").empty().html(results);
                itemSearchResultsPagination(results);
            }
        });
    }

    //Update invoice

    //customer name or customer id on input
    //show dropdown result
    //after choose result
    //both customer name and id will set value in input

    function updatecustomerSearchResults(pageNum) {

        var timer;
        var isSpinnerOn;
        var searchResult;

        if ($("#update-search-customer_name").val() != "" || $("#update-search-customer_id").val() != "") {

            clearTimeout(timer);
            $("#update-customer-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);

            isSpinnerOn = true;
            timer = setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowCustomer",
                        searchCustomerName: $("#update-search-customer_name").val(),
                        searchCustomerID: $("#update-search-customer_id").val(),
                        pageNum: pageNum
                    },
                    success: function(results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#update-customer-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>
                                    </div>
                                </div>
                                `);
                                isSpinnerOn = false;
                            }

                        } else if (results == "") {
                            $("#update-customer-search").empty().removeClass("border");
                            isSpinnerOn = false;
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
                            $.each(JSON.parse(results), function(i, value) {
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
                            $("#update-customer-search").empty().html(searchResult);
                            isSpinnerOn = false;
                            updatecustomerSearchResultsCountRow();
                            updatecustomerSearchResultsSelect();
                        }
                    }
                });
            }, 1000);
        } else {
            $("#update-customer-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    }

    function updatecustomerSearchResultsSelect() {
        $(".update-customer-search-results").click(function() {
            $("#update-search-customer_name").val($(this).find(".customerName").text());
            $("#update-search-customer_id").val($(this).find(".customerID").text());
            $("#update-customer-search").empty().removeClass("border");
        });
    }

    function updatecustomerSearchResultsPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#updatecustomerSearchPageTotal").empty().text(totalPage);
        $("#updatecustomerSearchCurrentPageNum").attr("max", totalPage);

        $("#updatecustomerSearchCurrentPageNum").on('input', function() {
            if ($("#updatecustomerSearchCurrentPageNum").val() == "") {
                console.log("Empty update customer search");
            } else if ($("#updatecustomerSearchCurrentPageNum").val() < totalPage)
                updatecustomerSearchResults($("#updatecustomerSearchCurrentPageNum").val());
            else
                updatecustomerSearchResults(totalPage);
        })
    }

    function updatecustomerSearchResultsCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountCustomer",
                searchCustomerName: $("#update-search-customer_name").val(),
                searchCustomerID: $("#update-search-customer_id").val()
            },
            success: function(results) {
                $("#update-customerSearchRowTotal").empty().html(results);
                updatecustomerSearchResultsPagination(results);
            }
        });
    }

    //when search item input is searching item name or barcode
    //show dropdown results with item name, barcode and quantity
    //when select one of the result, search input will be clean
    //item will be added into bucket as json

    function updateitemSearchResults(pageNum) {

        var timer;
        var isSpinnerOn;
        var searchResult;

        if ($("#update-search-item").val() != "") {
            clearTimeout(timer);
            $("#update-item-search").empty().addClass("border").html(`
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);

            isSpinnerOn = true;

            timer = setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowItem",
                        search: $("#update-search-item").val(),
                        pageNum: pageNum
                    },
                    success: function(results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#update-item-search").empty().html(`
                                <div class="row">
                                    <div class="col-6">
                                        <h5>${results}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="btn btn-primary" href="./itemMaintenance.php">Go add new item</a>
                                    </div>
                                </div>
                                `);
                                isSpinnerOn = false;
                            }

                        } else if (results == "") {
                            $("#update-item-search").empty().removeClass("border");
                            isSpinnerOn = false;
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
                            $.each(JSON.parse(results), function(i, value) {
                                var isItemSoldOut = false;
                                // if (value.qty_available == 0) {
                                //     isItemSoldOut = true
                                // } else {
                                //     isItemSoldOut = false;
                                // }
                                searchResult += `
                                <a class="update-item-search-results" data-id="${value.item_id}">
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
                            $("#update-item-search").empty().html(searchResult);

                            isSpinnerOn = false;
                            updateitemSearchResultsCountRow();
                            updateitemSearchResultsSelect();

                        }
                    }
                });
            }, 1000);

        } else {
            $("#update-item-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    }

    function updateitemSearchResultsSelect() {
        $(".update-item-search-results").click(function() {
            $.ajax({
                type: "POST",
                url: "./backend/invoice/viewCustmrItem.php",
                data: {
                    postType: "searchRowItemAdd",
                    itemID: $(this).data("id")
                },
                success: function(results) {
                    var item_results;
                    var isItemSoldOut = false;
                    var itemID;
                    $.each(JSON.parse(results), function(i, value) {
                            itemID = value.item_id;
                            //if (value.qty_available > 0) {
                            //isItemSoldOut = false;
                            if (value.item_id == $(".update-item-row").data("id")) {
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
                                        <input type="number" class="form-control update-itemQuantity" min="1"  value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control update-itemUnit" value="unit">
                                    </td>
                                    <td class="update-selling_price">${value.selling_price1}</td>
                                    <td class="update-unit_cost">${value.unit_cost}</td>
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
                    if ($("#update-item-bucket").find(".update-noResultText").length > 0) {
                        $("#update-item-bucket").empty();
                    }
                    if (item_results != "") {
                        $("#update-item-bucket").append(item_results);
                    }
                    $("#update-item-search").empty().removeClass("border");
                    $("#update-search-item").val("");
                    updateitemBucketTotalPrice(itemID);
                    updateitemBucketTotalDiscount();
                    updateitemBucketTotalCost();


                    $(".update-itemQuantity").change(function() {
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

                    $(".update-itemDiscount").change(function() {
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
                }
            });
        })
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

        $.each($(".update-item-row"), function(i, value) {
            var totalPrice = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-total_price").text();
            totalCost += parseFloat(totalPrice);
        })

        // if (parseFloat($("#update-total_discount").text()) > 0) {
        //     totalCost = totalCost - parseFloat($("#update-total_discount").text());
        // }

        $("#update-total_cost").empty().html(totalCost.toFixed(2));

    }

    function updateitemBucketTotalDiscount() {
        var totalDiscount = 0.0;
        console.log("triggered");

        $.each($(".update-item-row"), function(i, value) {
            var unit_price = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-selling_price").text();
            var quantity = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemQuantity").val();
            var discount = $(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemDiscount").val();

            if (discount > 0) {
                totalDiscount += (unit_price * (discount / 100)) * quantity;
            }
        })
        $("#update-total_discount").empty().html(totalDiscount.toFixed(2));
    }

    function updateitemBucketRemoveItem() {

        $(".update-deleteItemBtn").click(function() {
            $(this).closest("tr").remove();

            if ($.trim($("#update-item-bucket").html()).length == 0) {
                $("#update-item-bucket").html(`
                    <tr class="update-noResultText">
                        <td colspan="9" class="text-center">
                            <h5>No item added yet</h5>
                        </td>
                    </tr>
                `);
            }
        });
    }


    function updateitemSearchResultsPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#updateitemSearchPageTotal").empty().text(totalPage);
        $("#updateitemSearchCurrentPageNum").attr("max", totalPage);

        $("#updateitemSearchCurrentPageNum").on('input', function() {
            if ($("#updateitemSearchCurrentPageNum").val() == "") {
                console.log("empty update item search");
            } else if ($("#updateitemSearchCurrentPageNum").val() < totalPage)
                updateitemSearchResults($("#updateitemSearchCurrentPageNum").val());
            else
                updateitemSearchResults(totalPage);
        })
    }

    function updateitemSearchResultsCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountItem",
                search: $("#update-search-item").val()
            },
            success: function(results) {
                $("#updateitemSearchRowTotal").empty().html(results);
                updateitemSearchResultsPagination(results);
            }
        });
    }



    function addInvoice() {
        var item_id = [];
        var item_no = [];
        var description = [];
        var selling_price = [];
        var itemQuantity = [];
        var uom = [];
        var base_cost = [];
        var discount = [];
        var total_price = [];
        var customer_name;
        var account_num;
        var invoice_no;
        var doc_no;
        var invoice_date;
        var due_date;
        var remark;
        var total_cost;
        var subtotal_ex;
        var discount_header;

        if ($("#item-bucket").find(".noResultText").length > 0) {
            failedMessage("Failed", "Item bucket is empty");
        } else {

            customer_name = $("#search-customer_name").val();
            account_num = $("#search-customer_id").val();
            invoice_no = $("#invoice_number").val();
            doc_no = $("#doc_no").val();
            invoice_date = $("#invoice_date").val();
            due_date = $("#due_date").val();
            remark = $("#invoice_remark").val();
            total_cost = $("#total_cost").text();
            discount_header = $("#total_discount").text();
            subtotal_ex = total_cost + discount_header;


            $.each($(".item-row"), function(i, value) {
                item_id.push($(".item-row:nth-child(" + (i + 1) + ")").data("id"));
                item_no.push($(".item-row:nth-child(" + (i + 1) + ")").find(".item_no").text());
                description.push($(".item-row:nth-child(" + (i + 1) + ")").find(".description").text());
                selling_price.push($(".item-row:nth-child(" + (i + 1) + ")").find(".selling_price").text());
                itemQuantity.push($(".item-row:nth-child(" + (i + 1) + ")").find(".itemQuantity").val());
                total_price.push($(".item-row:nth-child(" + (i + 1) + ")").find(".total_price").text());
                uom.push($(".item-row:nth-child(" + (i + 1) + ")").find(".itemUnit").val());
                base_cost.push($(".item-row:nth-child(" + (i + 1) + ")").find(".base_cost").text());
                discount.push($(".item-row:nth-child(" + (i + 1) + ")").find(".itemDiscount").val());
            });

            $.ajax({
                type: "POST",
                url: "./backend/invoice/invoice.php",
                data: {
                    postType: "add",
                    in_account: account_num,
                    in_name: customer_name,
                    invoice_num: invoice_no,
                    invoice_date: invoice_date,
                    invoice_remark: remark,
                    doc_no: doc_no,
                    due_date: due_date,
                    subtotal_ex: subtotal_ex,
                    discount_header: discount_header,
                    total_amount: total_cost,
                    item_id: item_id,
                    item_no: item_no,
                    description: description,
                    quantity: itemQuantity,
                    uom: uom,
                    price: selling_price,
                    discount: discount,
                    amount: total_price,
                    base_cost: base_cost,
                },
                success: function(results) {
                    console.log(results);
                    switch (results) {
                        case ("success add"):
                            $("#addModal").modal("hide");
                            successMessage("Success", "Invoice is successfully added");
                            $("#general-table").empty();
                            $("#currentPageNum").val(1);
                            totalPage = paginate(totalRow);
                            generateTable();
                            break;
                        case ("Some input field is not set."):
                            $("#addModal").modal("hide");
                            failedMessage("Failed", results);
                            break;
                    }
                }
            })
        }
    }

    function updateInvoice() {
        var item_id = [];
        var item_no = [];
        var description = [];
        var selling_price = [];
        var itemQuantity = [];
        var uom = [];
        var base_cost = [];
        var discount = [];
        var total_price = [];
        var customer_name;
        var account_num;
        var invoice_no;
        var doc_no;
        var invoice_date;
        var due_date;
        var remark;
        var total_cost;
        var subtotal_ex;
        var discount_header;

        if ($("#update-item-bucket").find(".update-noResultText").length > 0) {
            failedMessage("Failed", "Item bucket is empty");
        } else {

            customer_name = $("#update-search-customer_name").val();
            account_num = $("#update-search-customer_id").val();
            invoice_no = $("#update-invoice_number").val();
            doc_no = $("#update-doc_no").val();
            invoice_date = $("#update-invoice_date").val();
            due_date = $("#update-due_date").val();
            remark = $("#update-invoice_remark").val();
            total_cost = $("#update-total_cost").text();
            discount_header = $("#update-total_discount").text();
            subtotal_ex = total_cost + discount_header;


            $.each($(".update-item-row"), function(i, value) {

                item_id.push($(".update-item-row:nth-child(" + (i + 1) + ")").data("id"));
                item_no.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-item_no").text());
                description.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-description").text());
                selling_price.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-selling_price").text());
                itemQuantity.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemQuantity").val());
                total_price.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-total_price").text());
                uom.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemUnit").val());
                base_cost.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-base_cost").text());
                discount.push($(".update-item-row:nth-child(" + (i + 1) + ")").find(".update-itemDiscount").val());
            });

            $.ajax({
                type: "POST",
                url: "./backend/invoice/invoice.php",
                data: {
                    postType: "update",
                    invoice_id: $("#update-invoice_id").val(),
                    in_account: account_num,
                    in_name: customer_name,
                    invoice_num: invoice_no,
                    invoice_date: invoice_date,
                    invoice_remark: remark,
                    doc_no: doc_no,
                    due_date: due_date,
                    subtotal_ex: subtotal_ex,
                    discount_header: discount_header,
                    total_amount: total_cost,
                    item_id: item_id,
                    item_no: item_no,
                    description: description,
                    quantity: itemQuantity,
                    uom: uom,
                    price: selling_price,
                    discount: discount,
                    amount: total_price,
                    base_cost: base_cost,
                },
                success: function(results) {
                    switch (results) {
                        case ("success edit"):
                            $("#editModal").modal("hide");
                            successMessage("Success", "Invoice is successfully updated");
                            $("#general-table").empty();
                            $("#currentPageNum").val(1);
                            totalPage = paginate(totalRow);
                            generateTable();
                            break;
                        case ("Some input field is not set."):
                            $("#editModal").modal("hide");
                            failedMessage("Failed", results);
                            break;
                    }
                }
            })
        }
    }

    function deleteInvoice() {

        $.ajax({
            type: "POST",
            url: "./backend/invoice/invoice.php",
            data: {
                postType: "deleteHeader",
                invoice_id: $("#delete_id").val()
            },
            success: function(results) {
                console.log(results);
                switch (results) {

                    case ("success delete"):
                        $("#deleteModal").modal("hide");
                        successMessage("Success", "Invoice is successfully updated");
                        $("#general-table").empty();
                        $("#currentPageNum").val(1);
                        totalPage = paginate(totalRow);
                        generateTable();
                        break;
                    case ("Some input field is not set."):
                        $("#deleteModal").modal("hide");
                        failedMessage("Failed", results);
                        break;
                    case ("id not found"):
                        $("#deleteModal").modal("hide");
                        failedMessage("Failed", results);
                        break;
                }
            },
            error: function(e) {
                console.log(e);
            }
        })

    }

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


    function countRow() {

        var totalRowCount;

        $.ajax({
            type: "POST",
            url: "./backend/invoice/invoice.php",
            data: {
                postType: "countRow",
            },
            async: false,
            success: function(results) {
                $("#rowTotal").empty().append(results);
                totalRowCount = results;

            }
        });

        return totalRowCount;
    }

    function paginate(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#pageTotal").empty().text(totalPage);

        if ($("#currentPageNum").val() > totalPage) {
            $("#currentPageNum").val(totalPage);
        }

        return totalPage;
    }


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
            url: "./backend/invoice/invoice.php",
            data: {
                postType: "viewHeader",
                pageNum: currentPageNum
            },
            //dataType: "json",
            success: function(results) {


                if (results == "0 results" || results == "No Result") {

                    renderTable("general");
                    tableSetting("general");

                } else {
                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "general");

                    $(".editBtn").click(function() {
                        var current_index_edit = $(this).attr('id');
                        var current_index = current_index_edit.split('-');


                        $("#update-invoice_id").val(current_index[1]);
                        $("#update-search-customer_name").val($("#in_name-" + current_index[1]).text());
                        $("#update-search-customer_id").val($("#in_account-" + current_index[1]).text());
                        $("#update-invoice_number").val($("#invoice_num-" + current_index[1]).text());
                        $("#update-doc_no").val($("#doc_no-" + current_index[1]).text());
                        $("#update-invoice_date").val($("#invoice_date-" + current_index[1]).text());
                        $("#update-due_date").val($("#due_date-" + current_index[1]).text());
                        $("#update-invoice_remark").val($("#invoice_remark-" + current_index[1]).text());

                        $.ajax({
                            type: "POST",
                            url: "./backend/invoice/invoice.php",
                            data: {
                                postType: "viewDetail",
                                invoice_id: current_index[1]
                            },
                            success: function(results) {
                                var item_results;
                                var totalCost = 0;
                                var totalDiscount = 0;
                                $.each(JSON.parse(results), function(i, value) {

                                    var discount = (value.discount == 0 ? 100 : value.discount) / 100;
                                    var discountPrice = discount == 1 ? 0 : value.price * discount;
                                    var newPrice = value.price - discountPrice;
                                    totalCost += newPrice;
                                    totalDiscount += discountPrice;

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
                                            <input type="number" class="form-control update-itemQuantity" min="1" value="${value.quantity}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control update-itemUnit" placeholder="unit" val="${value.uom}">
                                        </td>
                                        <td class="update-selling_price">${value.price}</td>
                                        <td class="update-unit_cost">${value.base_cost}</td>
                                        <td>
                                            <input type="number" class="form-control update-itemDiscount" value="${value.discount}" min="0" max="100" step="1">
                                        </td>
                                        <td class="update-total_price">${ newPrice.toFixed(2) }</td>
                                    </tr>
                                    `;
                                });


                                $("#update-item-bucket").empty().append(item_results);
                                $("#update-total_discount").empty().text(totalDiscount.toFixed(2));
                                $("#update-total_cost").empty().text(totalCost.toFixed(2));
                                $(".update-deleteItemBtn").click(function() {
                                    $(this).closest("tr").remove();

                                    if ($.trim($("#update-item-bucket").html()).length == 0) {
                                        $("#update-item-bucket").html(`
                                            <tr class="update-noResultText">
                                                <td colspan="7" class="text-center">
                                                    <h5>No item added yet</h5>
                                                </td>
                                            </tr>
                                        `);
                                    }
                                });

                                $(".update-itemQuantity").change(function() {
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

                                $(".update-itemDiscount").change(function() {
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

                            }
                        })
                    });

                    $(".deleteBtn").click(function() {
                        var current_index_edit = $(this).attr('id');
                        var current_index = current_index_edit.split('-');

                        $("#delete_id").val(current_index[1]);
                        $("#deleteInvoiceName").empty().text(current_index[1]);
                    });

                    $(".printBtn").click(function() {
                        var current_index_edit = $(this).attr('id');
                        var current_index = current_index_edit.split('-');
                        $("#print_id").val(current_index[1]);
                        $("#printInvoiceName").empty().text(current_index[1]);
                    })

                }
            },
            error: function(e) {
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
                    ' <th scope="col" class="th-lg">Invoice ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Invoice Number</th> ' +
                    ' <th scope="col" class="th-lg">Doc No</th> ' +
                    ' <th scope="col" class="th-lg">Issue Date</th> ' +
                    ' <th scope="col" class="th-lg">Due Date</th> ' +
                    ' <th scope="col" class="th-lg">Subtotal Exclude Discount</th> ' +
                    ' <th scope="col" class="th-lg">Total Discount</th> ' +
                    ' <th scope="col" class="th-lg">Total Cost</th> ' +
                    ' <th scope="col" class="th-lg">Remark</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="generalContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Invoice ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer ID</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Invoice Number</th> ' +
                    ' <th scope="col" class="th-lg">Doc No</th> ' +
                    ' <th scope="col" class="th-lg">Issue Date</th> ' +
                    ' <th scope="col" class="th-lg">Due Date</th> ' +
                    ' <th scope="col" class="th-lg">Subtotal Exclude Discount</th> ' +
                    ' <th scope="col" class="th-lg">Total Discount</th> ' +
                    ' <th scope="col" class="th-lg">Total Cost</th> ' +
                    ' <th scope="col" class="th-lg">Remark</th> ' +
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
                $.each(results, function(i, invoice) {
                    i++;
                    $("#generalContent").append(
                        "<tr>" +
                        ' <th scope="row">' + i + "</th>" +
                        ' <td>' +
                        ' <button id="edit-' + invoice.invoice_id + '" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">' +
                        ' <i class="fas fa-edit"></i>' +
                        ' </button>' +
                        ' <button id="delete-' + invoice.invoice_id + '" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">' +
                        ' <i class="fas fa-trash-alt"></i>' +
                        ' <button id="print-' + invoice.invoice_id + '" class="btn btn-secondary printBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#printModal">' +
                        ' <i class="fas fa-print"></i>' +
                        ' </button>' +
                        ' </td>' +

                        " <td id='invoice_id-" + invoice.invoice_id + "'>" + invoice.invoice_id + '</td>' +
                        " <td id='in_account-" + invoice.invoice_id + "'>" + invoice.in_account + '</td>' +
                        " <td id='in_name-" + invoice.invoice_id + "'>" + invoice.in_name + '</td>' +
                        " <td id='invoice_num-" + invoice.invoice_id + "'>" + invoice.invoice_num + '</td>' +
                        " <td id='doc_no-" + invoice.invoice_id + "'>" + invoice.doc_no + '</td>' +
                        " <td id='invoice_date-" + invoice.invoice_id + "'>" + invoice.invoice_date + '</td>' +
                        " <td id='due_date-" + invoice.invoice_id + "'>" + invoice.due_date + '</td>' +
                        " <td id='subtotal_ex-" + invoice.invoice_id + "'>" + invoice.subtotal_ex + '</td>' +
                        " <td id='discount_header-" + invoice.invoice_id + "'>" + invoice.discount_header + '</td>' +
                        " <td id='total_amount-" + invoice.invoice_id + "'>" + invoice.total_amount + '</td>' +
                        " <td id='invoice_remark-" + invoice.invoice_id + "'>" + invoice.invoice_remark + '</td>' +
                        '</tr>'
                    );
                });

                tableSetting("general");
                break;

        }
    }
});