$(document).ready(function () {
    console.log("sales payment page script");
    var salespaymenttotalRow = countRow();
    var salespaymenttotalPage = paginate(salespaymenttotalRow);
    var timer;
    var isSpinnerOn = false;
    var timerUpdate;
    var isSpinnerOnUpdate = false;
    generateTable();

    //Pagination Input
    $("#salespayment-currentPageNum").focusout(function () {
        generateTable();
    });

    //Search Customer Input for Add Modal
    $("#salespayment-search-salesorder").on("keyup", function () {
        clearTimeout(timer);
        if (!isSpinnerOn) {
            $("#salespayment-salesorder-search").empty().addClass("border").html(`
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                `);
            isSpinnerOn = true;
        }

        if ($(this).val()) {
            timer = setTimeout(function () {
                salespaymentSearchResults(1);
            }, 1000);
        } else {
            $("#salespayment-salesorder-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    })

    //Search Customer Input for Update Modal
    $("#update-salespayment-search-salesorder").on("keyup", function () {
        clearTimeout(timerUpdate);
        if (!isSpinnerOnUpdate) {
            $("#update-salespayment-salesorder-search").empty().addClass("border").html(`
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    `);
            isSpinnerOnUpdate = true;
        }

        if ($(this).val()) {
            timeUpdater = setTimeout(function () {
                updateSalespaymentSearchResults(1);
            }, 1000);
        } else {
            $("#update-salespayment-salesorder-search").empty().removeClass("border");
            isSpinnerOnUpdate = false;
        }
    })

    //clear add modal input
    $("#addSalesPaymentModalBtn").click(function () {
        $("#salespayment-amount_apply").val("0.00");
        $("#salespayment-payment_mode").val("cash");
        $("#salespayment-reference").val("");
        $("#salespayment_amountPaid").empty().text("0.00");
        $("#salespayment_totalCharge").empty().text("0.00");
        $("#salespayment_exchange").empty().text("0.00");
        $("#salespayment-search-salesorder").attr("readonly", false);
        $("#salespayment-total_cost").empty();
        $("#salespayment-salesorder-bucket").empty().html(`
        <tr class="salespayment-noResultText">
            <td colspan="9" class="text-center">
                <h5>No sales order added yet</h5>
            </td>
        </tr>
    `);
    })




    //add sale payment modal
    $("#addSalesPaymentSubmitBtn").click(function () {
        if (parseFloat($("#salespayment-amount_apply").val()) <= 0) {
            failedMessage("Failed", "Current payment amount is 0");
        } else if(parseFloat($("#salespayment_totalCharge").text()) > parseFloat($("#salespayment-amount_apply").val())){
            failedMessage("Failed", "Amount paid is not enough to fulfill current charge");
        } else if($("#salespayment-salesorder-bucket").find(".salespayment-noResultText").length > 0){
            failedMessage("Failed", "No sales order added yet");
        }
        else {
            addSalesPayment();
        }
    })

    //edit sale payment modal
    $("#editSalesPaymentSubmitBtn").click(function () {
        if (parseFloat($("#update-salespayment-amount_apply").val()) <= 0) {
            failedMessage("Failed", "Current payment amount is 0");
        } else if(parseFloat($("#update-salespayment_totalCharge").text()) > parseFloat($("#update-salespayment-amount_apply").val())){
            failedMessage("Failed", "Amount paid is not enough to fulfill current charge");
        } else if($("#update-salespayment-salesorder-bucket").find(".update-salespayment-noResultText").length > 0){
            failedMessage("Failed", "No sales order added yet");
        } else {
            editSalesPayment();
        }
    })

    $("#salespayment-amount_apply").change(function () {
        var amount = (parseFloat($(this).val())).toFixed(2);
        $(this).val(amount);
        $("#salespayment_amountPaid").empty().text(amount);
    })


    //For Add Modal
    //search sale order
    function salespaymentSearchResults(pageNum) {
        var timer;
        var searchResult;

        if ($("#salespayment-search-salesorder").val() != "") {
            clearTimeout(timer);
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/sale/salePayment.php",
                    data: {
                        postType: "salesorderSearch",
                        searchSalesOrder: $("#salespayment-search-salesorder").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#salespayment-salesorder-search").empty().html(`
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
                            $("#salespayment-salesorder-search").empty().removeClass("border");
                            isSpinnerOn = false;

                        } else {
                            searchResult = `
                            <div class="sticky-top bg-white">
                                <div class="row px-3 py-2 ">
                                    <div class=" col-6 py-2 py-md-0">
                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="salespaymentSearchRowTotal"></span></p>
                                    </div>
                                    <div class=" col-6 py-2 py-md-0">
                                        <div class="d-flex flex-row justify-content-end">
                                            <p class="my-auto">Page : </p>
                                            <input type="number" id="salespaymentSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="salespaymentSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;

                            $.each(JSON.parse(results), function (i, value) {
                                searchResult += `
                                <a class="salespayment-search-results" data-id="${value.sale_id}">
                                    <div class="view overlay  ${value.payment_status == "Unpaid" ? "" : "green lighten-4"}">
                                        <div class="row px-3 py-2">
                                            <div class="col-8 d-flex flex-row">
                                                <h5 class="my-auto">${value.sale_id}</h5>
                                                <small class="my-auto px-2 text-muted">${value.customer_name}</small>
                                            </div>
                                            <div class="col-4 d-flex flex-row justify-content-end">
                                                <strong class="my-auto">Status</strong>
                                                <p class="my-auto px-1 font-weight-bold ${value.payment_status == "Unpaid" ? 'text-danger' : 'text-success'}">${value.payment_status}</p>
                                            </div>
                                            <div class="mask flex-center ${value.payment_status == "Unpaid" ? "rgba-grey-slight" : "rgba-green-strong"}"></div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="p-0 m-0">
                                `;
                                searchResult += `</div>`;

                                $("#salespayment-salesorder-search").empty().html(searchResult);
                                isSpinnerOn = false;
                                salespaymentSearchCountRow();
                                salespaymentSearchSelect();

                                $("#salespaymentSearchCurrentPageNum").focusout(function () {
                                    salespaymentsearchResults(parseInt($(this).val()));
                                })
                            });
                        }
                    },
                    error: function (e) {
                        failedMessage("Failed", "Unexpected error occur : " + e);
                    }
                });
            }, 1000);
        } else {
            $("#salespayment-salesorder-search").empty().removeClass("border");
            isSpinnerOn = false;
        }

    }


    //Select sales order
    function salespaymentSearchSelect() {
        $(".salespayment-search-results").click(function () {
            $.ajax({
                type: "POST",
                url: "./backend/sale/salePayment.php",
                data: {
                    postType: "searchSalesOrderSelect",
                    saleID: $(this).data("id")
                },
                success: function (results) {
                    var salesorderResult = "";
                    var total_charge = 0;

                    $.each(JSON.parse(results), function (i, value) {
                        if (value.sale_id != $(".salespayment-row").data("id")) {
                            total_charge += parseFloat(value.sale_total_amount);
                            salesorderResult += `
                            <tr class="salespayment-row" data-id="${value.sale_id}">
                                <td>
                                    <button class="btn btn-danger deleteSalesOrderBtn py-md-3 px-md-4 p-sm-3">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-secondary viewSalesOrderBtn py-md-3 px-md-4 p-sm-3">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                </td>
                                <td class="sale_id">${value.sale_id}</td>
                                <td class="customer_name">${value.customer_name}</td>
                                <td class="sale_salesperson">${value.sale_salesperson}</td>
                                <td class="sale_date">${value.sale_date}</td>
                                <td class="sale_subtotal">${value.sale_subtotal}</td>
                                <td class="sale_discount_header">${value.sale_discount_header}</td>
                                <td class="sale_total_amount">${value.sale_total_amount}</td>
                            </tr>
                        `;
                        } else {
                            total_charge += parseFloat(value.sale_total_amount);
                        }
                    });
                    if ($("#salespayment-salesorder-bucket").find(".salespayment-noResultText").length > 0) {
                        $("#salespayment-salesorder-bucket").empty();
                        $("#salespayment-search-salesorder").attr("readonly", true);
                    }

                    $("#salespayment-salesorder-search").empty().removeClass("border");
                    $("#salespayment-search-salesorder").val("");
                    if (salesorderResult != "") {
                        $("#salespayment-salesorder-bucket").append(salesorderResult);
                    }

                    $(".deleteSalesOrderBtn").click(function () {
                        $(this).closest("tr").remove();

                        var amount = parseFloat($(this).parent().parent().find(".sale_total_amount").text())
                        var total_amount = parseFloat($("#salespayment_totalCharge").text());
                        //salespayment_totalCharge
                        //salespayment-total_cost
                        $("#salespayment-search-salesorder").attr("readonly", false);
                        $("#salespayment-total_cost, #salespayment_totalCharge").empty().text((total_amount - amount).toFixed(2))

                        if ($.trim($("#salespayment-salesorder-bucket").html()).length == 0) {
                            $("#salespayment-salesorder-bucket").html(`
                                <tr class="salespayment-noResultText">
                                    <td colspan="9" class="text-center">
                                        <h5>No sales order added yet</h5>
                                    </td>
                                </tr>
                            `);
                        }
                    });

                    $("#salespayment_totalCharge, #salespayment-total_cost").empty().text(total_charge.toFixed(2));

                    var amountPaid = parseFloat($("#salespayment_amountPaid").text());
                    var totalCharge = parseFloat($("#salespayment_totalCharge").text())
                    if (amountPaid > totalCharge) {
                        $("#salespayment_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
                    } else {
                        $("#salespayment_exchange").empty().text("0.00");
                    }

                    salespaymentCalculation();
                    salespaymentViewSalesOrderDetail();
                },
                error: function (e) {
                    failedMessage("Failed", "Unexpected error occur : " + e);
                }
            });
        })
    }

    //search sale order pagination
    function salespaymentSearchPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#salespaymentSearchPageTotal").empty().text(totalPage);
        $("#salespaymentSearchCurrentPageNum").attr("max", totalPage);

        $("#salespaymentSearchCurrentPageNum").on('input', function () {
            if ($("#salespaymentSearchCurrentPageNum").val() == "") {
                console.log("empty item search");
            } else if ($("#salespaymentSearchCurrentPageNum").val() < totalPage)
                salespaymentSearchResults($("#salespaymentSearchCurrentPageNum").val());
            else
                salespaymentSearchResults(totalPage);
        })
    }

    //search sale order count row
    function salespaymentSearchCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/sale/salePayment.php",
            data: {
                postType: "salesorderCountRow",
                searchSalesOrder: $("#salespayment-search-salesorder").val(),
            },
            success: function (results) {
                $("#salespaymentSearchPageTotal").empty().html(results);
                salespaymentSearchPagination(results);
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
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

     //View Sales order detail
    function salespaymentViewSalesOrderDetail(){
        $(".viewSalesOrderBtn").click(function(){
            $.ajax({
                type: "POST",
                url: "./backend/sale/salePayment.php",
                data: {
                    postType: "viewSalePaymentDetail",
                    sale_id : $(this).parent().parent().data("id")
                },
                success: function (results) {
                    var data = JSON.parse(results);
                    var salesOrder_results = "";
                    var total_amount = 0;
                    var total_discount = 0;
                    console.log(data);

                    $.each(data[0], function(i, item){

                        $("#salepaymentdetail-sale_id").empty().text(item.sale_id);
                        $("#salepaymentdetail-customer_account").empty().text(item.customer_account);
                        $("#salepaymentdetail-customer_name").empty().text(item.customer_name);
                        $("#salepaymentdetail-sale_salesperson").empty().text(item.sale_salesperson);
                        $("#salepaymentdetail-sale_subtotal").empty().text(item.sale_subtotal);
                        $("#salepaymentdetail-sale_discount_header").empty().text(item.sale_discount_header);
                        $("#salepaymentdetail-sale_total_amount").empty().text(item.sale_total_amount);
                    });

                    $.each(data[1], function(i, item){

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
                                <td>${item.discount}</td>
                                <td>${item.price}</td>
                            </tr>
                            `;
                        }
                    });
                    $("#salespaymentdetail-item-bucket").empty().html(salesOrder_results);
                    $("#salepaymentdetail-total_discount").empty().text(total_discount.toFixed(2));
                    $("#salepaymentdetail-total_cost").empty().text(total_amount.toFixed(2));
                    $("#viewSalesOrderDetailModal").modal("show");
                },
                error: function(e){
                    failedMessage("Failed", "Unexpected error occur : " + e);
                }
            })
        })
    }

    //For update Modal
    //search sale order
    function updateSalespaymentSearchResults(pageNum) {
        var timer;
        var searchResult;

        if ($("#update-salespayment-search-salesorder").val() != "") {
            clearTimeout(timer);
            timer = setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: "./backend/sale/salePayment.php",
                    data: {
                        postType: "salesorderSearch",
                        searchSalesOrder: $("#update-salespayment-search-salesorder").val(),
                        pageNum: pageNum
                    },
                    success: function (results) {
                        if (results == "No result") {
                            if (isSpinnerOn == true) {
                                $("#update-salespayment-salesorder-search").empty().html(`
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
                            $("#update-salespayment-salesorder-search").empty().removeClass("border");
                            isSpinnerOn = false;

                        } else {
                            searchResult = `
                            <div class="sticky-top bg-white">
                                <div class="row px-3 py-2 ">
                                    <div class=" col-6 py-2 py-md-0">
                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="update-salespaymentSearchRowTotal"></span></p>
                                    </div>
                                    <div class=" col-6 py-2 py-md-0">
                                        <div class="d-flex flex-row justify-content-end">
                                            <p class="my-auto">Page : </p>
                                            <input type="number" id="update-salespaymentSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="update-salespaymentSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;

                            $.each(JSON.parse(results), function (i, value) {
                                searchResult += `
                                <a class="update-salespayment-search-results" data-id="${value.sale_id}">
                                    <div class="view overlay  ${value.payment_status == "Unpaid" ? "" : "green lighten-4"}">
                                        <div class="row px-3 py-2">
                                            <div class="col-8 d-flex flex-row">
                                                <h5 class="my-auto">${value.sale_id}</h5>
                                                <small class="my-auto px-2 text-muted">${value.customer_name}</small>
                                            </div>
                                            <div class="col-4 d-flex flex-row justify-content-end">
                                                <strong class="my-auto">Status</strong>
                                                <p class="my-auto px-1 ${value.payment_status == "Unpaid" ? '' : 'text-success'}">${value.payment_status}</p>
                                            </div>
                                            <div class="mask flex-center ${value.payment_status == "Unpaid" ? "rgba-grey-slight" : "rgba-green-strong"}"></div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="p-0 m-0">
                                `;
                                searchResult += `</div>`;

                                $("#update-salespayment-salesorder-search").empty().html(searchResult);
                                isSpinnerOn = false;
                                updateSalespaymentSearchCountRow();
                                updateSalespaymentSearchSelect();

                                $("#update-salespaymentSearchCurrentPageNum").focusout(function () {
                                    updateSalespaymentsearchResults(parseInt($(this).val()));
                                })
                            });
                        }
                    },
                    error: function (e) {
                        failedMessage("Failed", "Unexpected error occur : " + e);
                    }
                });
            }, 1000);
        } else {
            $("#update-salespayment-salesorder-search").empty().removeClass("border");
            isSpinnerOn = false;
        }
    }


    //Select sales order
    function updateSalespaymentSearchSelect() {
        $(".update-salespayment-search-results").click(function () {
            $.ajax({
                type: "POST",
                url: "./backend/sale/salePayment.php",
                data: {
                    postType: "searchSalesOrderSelect",
                    saleID: $(this).data("id")
                },
                success: function (results) {
                    var salesorderResult = "";
                    var total_charge = 0;

                    $.each(JSON.parse(results), function (i, value) {
                        if (value.sale_id != $(".salespayment-row").data("id")) {
                            total_charge += parseFloat(value.sale_total_amount);
                            salesorderResult += `
                            <tr class="update-salespayment-row" data-id="${value.sale_id}">
                                <td>
                                    <button class="btn btn-danger deleteSalesOrderBtn py-md-3 px-md-4 p-sm-3">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-secondary viewSalesOrderBtn py-md-3 px-md-4 p-sm-3">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                </td>
                                <td class="sale_id">${value.sale_id}</td>
                                <td class="customer_name">${value.customer_name}</td>
                                <td class="sale_salesperson">${value.sale_salesperson}</td>
                                <td class="sale_date">${value.sale_date}</td>
                                <td class="sale_subtotal">${value.sale_subtotal}</td>
                                <td class="sale_discount_header">${value.sale_discount_header}</td>
                                <td class="sale_total_amount">${value.sale_total_amount}</td>
                            </tr>
                        `;
                        } else {
                            total_charge += parseFloat(value.sale_total_amount);
                        }
                    });
                    if ($("#update-salespayment-salesorder-bucket").find(".update-salespayment-noResultText").length > 0) {
                        $("#update-salespayment-salesorder-bucket").empty();
                        $("#update-salespayment-search-salesorder").attr("readonly", true);
                    }

                    $("#update-salespayment-salesorder-search").empty().removeClass("border");
                    $("#update-salespayment-search-salesorder").val("");
                    if (salesorderResult != "") {
                        $("#update-salespayment-salesorder-bucket").append(salesorderResult);
                    }

                    $(".deleteSalesOrderBtn").click(function () {
                        $(this).closest("tr").remove();

                        var amount = parseFloat($(this).parent().parent().find(".sale_total_amount").text())
                        var total_amount = parseFloat($("#update-salespayment_totalCharge").text());
                        //salespayment_totalCharge
                        //salespayment-total_cost
                        $("#update-salespayment-search-salesorder").attr("readonly", false);
                        $("#update-salespayment-total_cost, #update-salespayment_totalCharge").empty().text((total_amount - amount).toFixed(2))

                        if ($.trim($("#update-salespayment-salesorder-bucket").html()).length == 0) {
                            $("#update-salespayment-salesorder-bucket").html(`
                                <tr class="update-salespayment-noResultText">
                                    <td colspan="9" class="text-center">
                                        <h5>No sales order added yet</h5>
                                    </td>
                                </tr>
                            `);
                        }
                    });

                    $("#update-salespayment_totalCharge, #update-salespayment-total_cost").empty().text(total_charge.toFixed(2));

                    var amountPaid = parseFloat($("#update-salespayment_amountPaid").text());
                    var totalCharge = parseFloat($("#update-salespayment_totalCharge").text())
                    if (amountPaid > totalCharge) {
                        $("#update-salespayment_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
                    } else {
                        $("#update-salespayment_exchange").empty().text("0.00");
                    }

                    salespaymentViewSalesOrderDetail();
                    updatesalespaymentCalculation();

                },
                error: function (e) {
                    failedMessage("Failed", "Unexpected error occur : " + e);
                }
            });
        })
    }

    //search sale order pagination
    function updateSalespaymentSearchPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#salespaymentSearchPageTotal").empty().text(totalPage);
        $("#salespaymentSearchCurrentPageNum").attr("max", totalPage);

        $("#salespaymentSearchCurrentPageNum").on('input', function () {
            if ($("#salespaymentSearchCurrentPageNum").val() == "") {
                console.log("empty item search");
            } else if ($("#salespaymentSearchCurrentPageNum").val() < totalPage)
                updateSalespaymentSearchResults($("#salespaymentSearchCurrentPageNum").val());
            else
                updateSalespaymentSearchResults(totalPage);
        })
    }

    //search sale order count row
    function updateSalespaymentSearchCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/sale/salePayment.php",
            data: {
                postType: "salesorderCountRow",
                searchSalesOrder: $("#update-salespayment-search-salesorder").val(),
            },
            success: function (results) {       
                $("#update-salespaymentSearchPageTotal").empty().html(results);
                updateSalespaymentSearchPagination(results);
            },
            error: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });
    }


    function updatesalespaymentCalculation() {
        $("#update-salespayment-amount_apply").change(function () {
            var amount = (parseFloat($(this).val())).toFixed(2);
            $(this).val(amount);
            $("#update-salespayment_amountPaid").empty().text(amount);

            var amountPaid = parseFloat($("#update-salespayment_amountPaid").text());
            var totalCharge = parseFloat($("#update-salespayment_totalCharge").text())
            if (amountPaid > totalCharge) {
                $("#update-salespayment_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
            } else {
                $("#update-salespayment_exchange").empty().text("0.00");
            }
        })
    }


    //add sale payment
    function addSalesPayment() {
        var customer_name = $("#salespayment-salesorder-bucket").find(".salespayment-row").find(".customer_name").text();
        var sale_id = $("#salespayment-salesorder-bucket").find(".salespayment-row").data("id");
        var payment_method = $("#salespayment-payment_mode").val();
        var sale_amount = $("#salespayment_totalCharge").text();
        var sale_payment = $("#salespayment_amountPaid").text();
        var reference = $("#salespayment-reference").val();

        $.ajax({
            type: "POST",
            url: "./backend/sale/salePayment.php",
            data: {
                postType: "addSalePayment",
                customer_name: customer_name,
                sale_id: sale_id,
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

                    case ("success add payment"):
                        $("#addSalesPaymentModal").modal("hide");
                        successMessage("Success", "Sale Payment is successfully added");
                        $("#salespayment-table").empty();
                        $("#salespayment-currentPageNum").val(1);
                        salespaymenttotalPage = paginate(salespaymenttotalRow);
                        $(".btnSuccess").click(function () {
                            location.reload();
                        })
                        break;
                }
            },
            error: function(e){
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        })
    }
    //update sale payment
    function editSalesPayment() {
        var sale_payment_id = $("#update-salespayment_id").val();
        var payment_method = $("#update-salespayment-payment_mode").val();
        var sale_payment = $("#update-salespayment-amount_apply").val()
        var reference = $("#update-salespayment-reference").val();

        $.ajax({
            type: "POST",
            url: "./backend/sale/salePayment.php",
            data: {
                postType: "updateSalePayment",
                sale_payment_id: sale_payment_id,
                payment_method: payment_method,
                sale_payment: sale_payment,
                reference: reference
            },
            success: function(results){
                switch (results) {
                    case ("Some input field is not set."):
                        failedMessage("Failed", results);
                        break;

                    case ("success edit payment"):
                        $("#editSalesPaymentModal").modal("hide");
                        successMessage("Success", "Sale Payment is successfully updated");
                        $("#salespayment-table").empty();
                        $("#salespayment-currentPageNum").val(1);
                        salespaymenttotalPage = paginate(salespaymenttotalRow);
                        $(".btnSuccess").click(function () {
                            location.reload();
                        })
                        break;
                }
            },
            error: function(e){
                console.log(e)
                failedMessage("Failed", "Unexpected error occur : " + e);
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
            url: "./backend/sale/salePayment.php",
            data: {
                postType: "countRow",
            },
            async: false,
            success: function (results) {
                $("#salespayment-rowTotal").empty().append(results);
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
        $("#salespayment-pageTotal").empty().text(totalPage);

        if ($("#salespayment-currentPageNum").val() > totalPage) {
            $("#salespayment-currentPageNum").val(totalPage);
        }

        return totalPage;
    }


    function generateTable() {
        salespaymenttotalRow = countRow();
        salespaymenttotalPage = paginate(salespaymenttotalRow);
        var currentPageNum;

        if ($("#salespayment-currentPageNum").val() != 0) {
            if ($("#salespayment-currentPageNum").val() > salespaymenttotalPage) {
                currentPageNum = salespaymenttotalPage;
            } else {
                currentPageNum = $("#salespayment-currentPageNum").val();
            }
        } else {
            currentPageNum = 1;
        }

        $("#salespayment-currentPageNum").val(currentPageNum);

        $.ajax({
            type: "POST",
            url: "./backend/sale/salePayment.php",
            data: {
                postType: 'viewSalePayment',
                pageNum: currentPageNum
            },
            success: function (results) {
                if (results == "0 results" || results == "No Result") {
                    renderTable("salespayment");
                    tableSetting("salespayment");
                } else {
                    //results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(JSON.parse(results), "salespayment");

                    //update button modal
                    $(".editSalesPaymentBtn").click(function () {
                        var tag = $(this).parent().parent();
                        var reference = tag.find(".reference").text();
                        var payment_method = tag.find(".payment_method").text();
                        var sale_payment = tag.find(".sale_payment").text();
                        var sale_id_header = tag.find(".sale_id_header").text();

                        $("#update-salespayment-amount_apply").val(sale_payment);
                        $("#update-salespayment-payment_mode").val(payment_method);
                        $("#update-salespayment-reference").val(reference);
                        $("#update-salespayment_amountPaid").empty().text(sale_payment);
                        $("#update-salespayment_id").val(tag.data("salespayment-id"));

                        
                        console.log(sale_id_header);
                        $.ajax({
                            type: "POST",
                            url: "./backend/sale/salePayment.php",
                            data: {
                                postType: "searchSalesOrderSelect",
                                saleID: sale_id_header
                            },
                            success: function (results) {
                                var salesorderResult = "";
                                var total_charge = 0;

                                $.each(JSON.parse(results), function (i, value) {
                                    if (value.sale_id != $(".salespayment-row").data("id")) {
                                        total_charge += parseFloat(value.sale_total_amount);
                                        salesorderResult += `
                                            <tr class="update-salespayment-row" data-id="${value.sale_id}">
                                                <td>
                                                    <button class="btn btn-danger deleteSalesOrderBtn py-md-3 px-md-4 p-sm-3">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <button class="btn btn-secondary viewSalesOrderBtn py-md-3 px-md-4 p-sm-3">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </button>
                                                </td>
                                                <td class="sale_id">${value.sale_id}</td>
                                                <td class="customer_name">${value.customer_name}</td>
                                                <td class="sale_salesperson">${value.sale_salesperson}</td>
                                                <td class="sale_date">${value.sale_date}</td>
                                                <td class="sale_subtotal">${value.sale_subtotal}</td>
                                                <td class="sale_discount_header">${value.sale_discount_header}</td>
                                                <td class="sale_total_amount">${value.sale_total_amount}</td>
                                            </tr>
                                        `;
                                    } else {
                                        total_charge += parseFloat(value.sale_total_amount);
                                    }
                                });
                                if ($("#update-salespayment-salesorder-bucket").find(".update-salespayment-noResultText").length > 0) {
                                    $("#update-salespayment-salesorder-bucket").empty();
                                    $("#update-salespayment-search-salesorder").attr("readonly", true);
                                }

                                $("#update-salespayment-salesorder-search").empty().removeClass("border");
                                $("#update-salespayment-search-salesorder").val("");
                                if (salesorderResult != "") {
                                    $("#update-salespayment-salesorder-bucket").empty().html(salesorderResult);
                                }

                                $(".deleteSalesOrderBtn").click(function () {
                                    $(this).closest("tr").remove();

                                    var amount = parseFloat($(this).parent().parent().find(".sale_total_amount").text())
                                    var total_amount = parseFloat($("#update-salespayment_totalCharge").text());
                                    //salespayment_totalCharge
                                    //salespayment-total_cost
                                    $("#update-salespayment-search-salesorder").attr("readonly", false);
                                    $("#update-salespayment-total_cost, #update-salespayment_totalCharge").empty().text((total_amount - amount).toFixed(2))

                                    if ($.trim($("#update-salespayment-salesorder-bucket").html()).length == 0) {
                                        $("#update-salespayment-salesorder-bucket").html(`
                                            <tr class="update-salespayment-noResultText">
                                                <td colspan="9" class="text-center">
                                                    <h5>No sales order added yet</h5>
                                                </td>
                                            </tr>
                                        `);
                                    }
                                });

                                $("#update-salespayment_totalCharge, #update-salespayment-total_cost").empty().text(total_charge.toFixed(2));

                                var amountPaid = parseFloat($("#update-salespayment_amountPaid").text());
                                var totalCharge = parseFloat($("#update-salespayment_totalCharge").text())
                                if (amountPaid > totalCharge) {
                                    $("#update-salespayment_exchange").empty().text((amountPaid - totalCharge).toFixed(2));
                                } else {
                                    $("#update-salespayment_exchange").empty().text("0.00");
                                }

                                salespaymentViewSalesOrderDetail(); 
                                updatesalespaymentCalculation();

                            },
                            error: function (e) {
                                failedMessage("Failed", "Unexpected error occur : " + e);
                            }
                        });



                    })

                    //print button modal
                    $(".printSalesPaymentBtn").click(function () {
                        $("#print_salepayment_id").val($(this).parent().parent().data("salespayment-id"));
                    })
                }

            },
            failed: function (e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        })
    }

    function tableSetting(type) {
        switch (type) {
            case ("salespayment"):

                var table = $('#salespaymentTable').DataTable({
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
            case ("salespayment"):

                $("#salespayment-table").empty().append(
                    '<table id="salespaymentTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" > ' +
                    ' <thead class="grey lighten-2  "> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Sale Payment ID</th> ' +
                    ' <th scope="col" class="th-lg">Sale Header ID</th> ' +
                    ' <th scope="col" class="th-lg">Payment Date</th> ' +
                    ' <th scope="col" class="th-lg">Payment Time</th> ' +
                    ' <th scope="col" class="th-lg">Payment Method</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Sale Amount</th> ' +
                    ' <th scope="col" class="th-lg">Sale Payment</th> ' +
                    ' <th scope="col" class="th-lg">Reference</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="salespaymentContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Sale Payment ID</th> ' +
                    ' <th scope="col" class="th-lg">Sale Header ID</th> ' +
                    ' <th scope="col" class="th-lg">Payment Date</th> ' +
                    ' <th scope="col" class="th-lg">Payment Time</th> ' +
                    ' <th scope="col" class="th-lg">Payment Method</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Sale Amount</th> ' +
                    ' <th scope="col" class="th-lg">Sale Payment</th> ' +
                    ' <th scope="col" class="th-lg">Reference</th> ' +
                    ' </tr> ' +
                    ' </tfoot> ' +
                    ' </table>'
                );

                break;
        }
    }

    function renderContent(results, type) {
        switch (type) {
            case ("salespayment"):

                renderTable("salespayment");
                $.each(results, function (i, salespayment) {
                    $("#salespaymentContent").append(`
                        <tr class="salespayment-row" data-salespayment-id="${salespayment.sale_payment_id}">
                            <th>${++i}</th>
                            <td>
                                <button class="btn btn-warning editSalesPaymentBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editSalesPaymentModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-secondary printSalesPaymentBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#printSalesPaymentModal">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                            <td class="sale_payment_id">${salespayment.sale_payment_id}</td>
                            <td class="sale_id_header">${salespayment.sale_id_header}</td>
                            <td class="sale_payment_date">${salespayment.sale_payment_date}</td>
                            <td class="sale_payment_time">${salespayment.sale_payment_time}</td>
                            <td class="payment_method">${salespayment.payment_method}</td>
                            <td class="customer_name">${salespayment.customer_name}</td>
                            <td class="sale_amount">${salespayment.sale_amount}</td>
                            <td class="sale_payment">${salespayment.sale_payment}</td>
                            <td class="reference">${salespayment.reference}</td>
                        </tr>
                    `);
                });

                tableSetting("salespayment");
                break;

        }
    }
});