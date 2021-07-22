$(document).ready(function() {

    var totalRow = countRow();
    var totalPage = paginate(totalRow);
    var timer;
    var isSpinnerOn = false;
    var timerGlobal;
    var isSpinnerOnGlobal = false;
    generateTable();

    $("#total_payment").on("keyup", function() {
        $("#unapply_amount").val($(this).val());
    })


    $("#total_payment").on("focusout", function() {
        var unapply_amount = $("#unapply_amount").val();
        var total_payment = $(this).val();

        var zero = 0.00;
        if ($(this).val() == "") {
            $("#unapply_amount").val(zero);
            $(this).val(zero);
        } else {
            $("#unapply_amount").val(parseFloat(unapply_amount).toFixed(2));
            $(this).val(parseFloat(total_payment).toFixed(2));
        }
    })



    $("#update-total_payment").on("keyup", function() {
        $("#update-unapply_amount").val($(this).val());
    })


    $("#update-total_payment").on("focusout", function() {
        var unapply_amount = $("#update-unapply_amount").val();
        var total_payment = $(this).val();

        var zero = 0.00;
        if ($(this).val() == "") {
            $("#update-unapply_amount").val(zero);
            $(this).val(zero);
        } else {
            $("#update-unapply_amount").val(parseFloat(unapply_amount).toFixed(2));
            $(this).val(parseFloat(total_payment).toFixed(2));
        }
    })

    $("#currentPageNum").focusout(function() {
        if ($("#current_customer_view_text").css("display") == "none") {
            countRow();
            generateTable();
        } else {
            countRowSelectedCustomer();
            filterCustomer($("#curent_customer_payment_history").data("customer-name"));
        }
    });

    $("#global_search_customer_input").on("keyup", function() {
        clearTimeout(timerGlobal);

        if (!isSpinnerOnGlobal) {
            $("#global_search_customer_result").empty().removeClass("bg-white").addClass("border").html(`
            <div class="d-flex justify-content-center bg-white border search-result-spinner">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);
            isSpinnerOnGlobal = true;
        }


        if ($(this).val()) {
            timerGlobal = setTimeout(function() {
                globalCustomerSearchResults(1);
            }, 1000);
        } else {
            generateTable();
            $("#global_search_customer_result").empty().removeClass("border");
            isSpinnerOnGlobal = false;
        }

    });



    $("#search-customer_name, #search-customer_id").on('keyup', function() {
        clearTimeout(timer);
        if (!isSpinnerOn) {
            $("#customer-search").empty().removeClass("bg-white").addClass("border").html(`
            <div class="d-flex justify-content-center bg-white border search-result-spinner">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            `);
            isSpinnerOn = true;
        }


        if ($(this).val()) {
            timer = setTimeout(function() {
                customerSearchResults(1);
            }, 1000);
        } else {
            $("#customer-search").empty().removeClass("border");
            isSpinnerOn = false;
        }

    });


    $("#addModalBtn").click(function() {
        $("#search-customer_name").val("");
        $("#search-customer_id").val("");
        $("#addModalOutstandingInvoiceList").prop("checked", true)
        $("#customer-search").removeClass("border").empty();
        $("#total_payment").val("0.00");
        $("#payment_mode").val("");
        $("#payment_date").val("");
        $("#payment_salesperson").val("");
        $("#payment_remark").val("");
        $("#unapply_amount").val("0.00");
        $("#total_outstanding").val("0.00");
        $("#total_pay").val("0.00");
        $("#currentPageNumSelectedCustomerInvoiceList").val(1);
        $("#payment-bucket").empty().html(`
        <tr class="noResultText">
            <td colspan="11" class="text-center">
                <h5>No payment available</h5>
            </td>
        </tr>
        `);
    });

    $(".editBtn").click(function() {
        $("#update-search-customer_name").val("");
        $("#update-search-customer_id").val("");

        $("#update-customer-search").removeClass("border").empty();
        $("#update-total_payment").val("0.00");
        $("#update-payment_mode").val("");
        $("#update-payment_date").val("");
        $("#update-payment_salesperson").val("");
        $("#update-payment_remark").val("");
        $("#update-unapply_amount").val("0.00");
        $("#update-total_outstanding").val("0.00");
        $("#update-total_pay").val("0.00");

        $("#update-payment-bucket").empty().html(`
        <tr class="noResultText">
            <td colspan="11" class="text-center">
                <h5>No payment available</h5>
            </td>
        </tr>
        `);
    });



    $("[name='addModalInvoice']").click(function() {
        console.log($("[name='addModalInvoice']:checked").val())
        addModalSwitchInvoiceList($("[name='addModalInvoice']:checked").val());
    })

    // $("[name='updateModalInvoice']").click(function() {
    //     updateModalSwitchInvoiceList($("[name='updateModalInvoice']:checked").val());
    // })

    //createInvoiceListOnUpdateModal
    $("#addPaymentSubmitBtn").click(function() {
        addPayment();
    });

    $("#updatePaymentSubmitBtn").click(function() {
        editPayment();
    })

    $("#deletePaymentSubmitBtn").click(function() {
        deletePayment();
    });

    $(".customer_item").click(function() {
        var selected_customer_name = $(this).data("customer-name");
        if (selected_customer_name != "") {
            if (selected_customer_name == "none") {
                generateTable();
                $("#curent_customer_payment_history").text("");
                $("#curent_customer_payment_history").attr(
                    "data-customer-name", "none"
                );
                $("#current_customer_view_text").hide();
            } else {
                filterCustomer(selected_customer_name);
                $("#curent_customer_payment_history").text($(this).text());
                $("#curent_customer_payment_history").attr(
                    "data-customer-name", selected_customer_name
                );
                $("#current_customer_view_text").show();
            }
        }
    });

    function filterCustomer(customer_account) {
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
            url: "./backend/payment/payment.php",
            data: {
                postType: "paymentHistory",
                customer_account: customer_account,
                pageNum: currentPageNum
            },
            success: function(results) {

                if (results == "0 results" || results == "No Result") {

                    renderTable("general");
                    tableSetting("general");

                } else {

                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "general");

                    $(".printBtn").click(function() {
                        var id = $(this).parent().parent().data("id");
                        $("#print_id").val(id);
                        $("#customer_name").val($(this).parent().parent().find(".customer_account").text());
                    })

                    $(".deleteBtn").click(function() {
                        var payment_identifier = $(this).parent().parent().data("id");
                        var payment_id = $(this).parent().parent().data("payment-id");
                        $("#delete_data").attr({
                            "data-payment_identifier": payment_identifier,
                            "data-payment_id": payment_id,
                        });

                    })

                    $(".editBtn").click(function() {
                        var customer_account = $(this).parent().parent().find(".customer_account").text();
                        var customer_name = $(this).parent().parent().find(".customer_name").text();
                        var payment_identifier = $(this).parent().parent().data("id");
                        var payment_id = $(this).parent().parent().data("payment-id");
                        var payment_date = $(this).parent().parent().find(".payment_date").text();
                        var payment_mode = $(this).parent().parent().find(".payment_mode").text();
                        var payment_salesperson = $(this).parent().parent().find(".payment_salesperson").text();
                        var payment_remark = $(this).parent().parent().find(".payment_remark").text();
                        var total_payment_amount = $(this).parent().parent().find(".total_payment_amount").text();
                        fillUpdatePaymentModal(customer_account, customer_name, payment_identifier, payment_id, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount);

                    })
                }
            },
            error: function(e) {
                failedMessage("Failed", "Unexpected error occur : " + e);
            }
        });

    }


    //Global Customer Search
    function globalCustomerSearchResults(pageNum) {

        var timer;
        var searchResult;
        if ($("#global_search_customer_input").val() != "") {

            clearTimeout(timer);

            timer = setTimeout(function() {
                console.log("triggered");
                $.ajax({
                    type: "POST",
                    url: "./backend/invoice/viewCustmrItem.php",
                    data: {
                        postType: "searchRowCustomer",
                        searchCustomerName: $("#global_search_customer_input").val(),
                        searchCustomerID: "",
                        pageNum: pageNum
                    },
                    success: function(results) {
                        console.log(results);
                        if (results == "No result") {
                            if (isSpinnerOnGlobal == true) {
                                $("#global_search_customer_result").addClass("customer-search-nothing").empty().html(`
                                <div class="sticky-top bg-white">
                                    <div class="row px-3 py-2">
                                        <div class="col-6">
                                            <h5>${results}</h5>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>
                                        </div>
                                    </div>
                                </div> 
                                `);
                                isSpinnerOnGlobal = false;
                            }

                        } else if (results == "") {
                            $("#customer-search").empty().removeClass("customer-search-nothing").removeClass("border").removeClass("bg-white");
                            isSpinnerOnGlobal = false;
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
                                            <input type="number" id="globalCustomerSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="${pageNum}">
                                            <p class="my-auto"> of <span id="globalCustomerSearchPageTotal"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="p-0 m-0">
                            </div>
                            <div class="overflow-auto" style="max-height:200px;">
                            `;
                            $.each(JSON.parse(results), function(i, value) {
                                searchResult += `
                                <a class="global_customer-search-results">
                                    <div class="view overlay">
                                        <div class="row px-3 py-2">
                                            <div class="col-12">
                                                <h5 class="my-auto customerName">${value.name}</h5>
                                            </div>
                                            <div class="mask flex-center rgba-grey-slight"> </div>
                                        </div>
                                    </div>
                                </a>
                                <hr class="p-0 m-0">
                                `;
                            });
                            searchResult += `</div>`;
                            $("#global_search_customer_result").removeClass("customer-search-nothing").empty().addClass("bg-white").html(searchResult);
                            isSpinnerOnGlobal = false;
                            globalCustomerSearchResultsCountRow();
                            globalCustomerSearchResultsSelect();
                        }
                    }
                });
            }, 1000);
        } else {
            $("#global_search_customer_result").empty().removeClass("border");
            isSpinnerOnGlobal = false;
        }
    }

    function globalCustomerSearchResultsSelect() {
        $(".global_customer-search-results").click(function() {
            $("#global_search_customer_input").val($(this).find(".customerName").text());
            //$("#search-customer_id").val($(this).find(".customerID").text());
            $("#global_search_customer_result").empty().removeClass("border");
            //addModalSwitchInvoiceList($("[name='addModalInvoice']:checked").val());
            generateTable();
        });
    }

    function globalCustomerSearchResultsPagination(total) {
        var rowperpage = 10;
        var totalPage = Math.ceil(total / rowperpage);
        $("#globalCustomerSearchPageTotal").empty().text(totalPage);
        $("#globalCustomerSearchCurrentPageNum").attr("max", totalPage);

        $("#globalCustomerSearchCurrentPageNum").on('input', function() {
            if ($("#globalCustomerSearchCurrentPageNum").val() == "") {
                console.log("empty customer search");
            } else if ($("#globalCustomerSearchCurrentPageNum").val() < totalPage)
                globalCustomerSearchResults($("#globalCustomerSearchCurrentPageNum").val());
            else
                globalCustomerSearchResults(totalPage);
        })
    }

    function globalCustomerSearchResultsCountRow() {
        $.ajax({
            type: "POST",
            url: "./backend/invoice/viewCustmrItem.php",
            data: {
                postType: "searchRowCountCustomer",
                searchCustomerName: $("#global_search_customer_input").val(),
                searchCustomerID: ""
            },
            success: function(results) {
                $("#globalCustomerSearchRowTotal").empty().html(results);
                globalCustomerSearchResultsPagination(results);
            }
        });
    }

    //Global Customer Search end




    //Add payment modal
    function customerSearchResults(pageNum, isSpinnerOn) {

        var timer;
        var searchResult;
        if ($("#search-customer_name").val() != "" || $("#search-customer_id").val() != "") {

            clearTimeout(timer);

            timer = setTimeout(function() {
                console.log("triggered");
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
                                $("#customer-search").addClass("customer-search-nothing").empty().html(`
                                <div class="sticky-top bg-white">
                                    <div class="row px-3 py-2">
                                        <div class="col-6">
                                            <h5>${results}</h5>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>
                                        </div>
                                    </div>
                                </div> 
                                `);
                                isSpinnerOn = false;
                            }

                        } else if (results == "") {
                            $("#customer-search").empty().removeClass("customer-search-nothing").removeClass("border").removeClass("bg-white");
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
                            $("#customer-search").removeClass("customer-search-nothing").empty().addClass("bg-white").html(searchResult);
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
            addModalSwitchInvoiceList($("[name='addModalInvoice']:checked").val());
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

    //Add modal invoice pagination
    function countRowSelectedCustomerInvoice() {
        var postType = "";

        switch ($("[name='addModalInvoice']:checked").val()) {
            case ("all-invoice"):
                postType = "countRowSelectedCustomerInvoiceAll";
                break;

            case ("outstanding-invoice"):
                postType = "countRowSelectedCustomerInvoiceOutstanding"
                break;
        }
        $.ajax({
            type: "POST",
            url: "./backend/payment/payment.php",
            data: {
                postType: postType,
                customer_account: $("#search-customer_id").val()
            },
            success: function(results) {


                var rowperpage = 20;
                var totalPage = Math.ceil(results / rowperpage);

                $("#pageTotalSelectedCustomerInvoiceList").empty().text(totalPage);
                //$("#currentPageNumSelectedCustomerInvoiceList").attr("max", totalPage);
                // $("#currentPageNumSelectedCustomerInvoiceList").val(1);
                $("#currentPageNumSelectedCustomerInvoiceList").on('focusout', function() {

                    if ($("#currentPageNumSelectedCustomerInvoiceList").val() == "") {
                        console.log("empty invoice search");
                    } else if ($("#currentPageNumSelectedCustomerInvoiceList").val() < totalPage) {
                        console.log("current page num < total page");
                        addModalSwitchInvoiceList($("[name='addModalInvoice']:checked").val());
                    } else {
                        $("#currentPageNumSelectedCustomerInvoiceList").val(totalPage);
                        console.log("current page num > total page");
                        addModalSwitchInvoiceList($("[name='addModalInvoice']:checked").val());
                    }

                })
            }
        });

    }


    //Update Payment modal


    function deletePayment() {

        var payment_identifier = $("#delete_data").data("payment_identifier");
        var payment_id = $("#delete_data").data("payment_id");

        $.ajax({
            type: "POST",
            url: "./backend/payment/payment.php",
            data: {
                postType: "deletePayment",
                payment_identifier: payment_identifier,
                payment_id: payment_id
            },
            success: function(results) {

                switch (results) {
                    case ("success delete payment"):
                        $("#deleteModal").modal("hide");
                        successMessage("Success", "Payment is successfully deleted");
                        $(".btnSuccess").click(function() {
                            location.reload();
                        })
                        break;
                    case ("Some input field is not set."):
                        failedMessage("Failed", results);
                        break;

                }
            }
        });
    }

    function editPayment() {
        var id = [];
        var invoice_id = [];
        var total_amount = [];
        var outstanding = [];
        var payment = [];

        var payment_id = ""
        var payment_identifier = "";
        var payment_mode = "";
        var payment_remark = "";
        var payment_date = "";
        var payment_salesperson = "";

        var total_payment_amount = "";

        var customer_account = "";
        var customer_name = "";

        if ($("#update-payment-bucket").find(".noResultText").length > 0) {
            failedMessage("Failed", "No invoice found");
        } else {
            $.each($(".update-item-row"), function(i, item) {
                var row_id = $(`.update-item-row:eq(${i})`).data('id');
                id.push(row_id);
                invoice_id.push($(`.update-item-row:nth-child(${i+1})`).data('invoice_id'));
                total_amount.push(parseFloat($(`.update-total_amount-${row_id}`).text()));
                outstanding.push(parseFloat($(`.update-outstanding-${row_id}`).text()));
                payment.push(parseFloat($(`.update-payment-${row_id}`).find(".update_payment_per_invoice").val()));

            })

            payment_mode = $("#update-payment_mode").val();
            payment_remark = $('#update-payment_remark').val();
            payment_date = $("#update-payment_date").val();
            payment_salesperson = $("#update-payment_salesperson").val();
            payment_identifier = $("#update_identifier_id").val();
            payment_id = $("#update_payment_id").val();
            customer_account = $("#update-search-customer_id").val();
            customer_name = $("#update-search-customer_name").val();

            total_payment_amount = $("#update-total_pay").val();

            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "updatePayment",
                    id: id,
                    invoice_id: invoice_id,
                    payment_mode: payment_mode,
                    total_amount: total_amount,
                    outstanding: outstanding,
                    payment: payment,
                    payment_identifier: payment_identifier,
                    payment_id: payment_id,
                    payment_date: payment_date,
                    payment_remark: payment_remark,
                    payment_salesperson: payment_salesperson,
                    customer_account: customer_account,
                    customer_name: customer_name,
                    total_payment_amount: total_payment_amount
                },
                success: function(results) {
                    console.log(results);
                    switch (results) {
                        case ("success update payment"):
                            $("#editModal").modal("hide");
                            successMessage("Success", "Payment is successfully updated");
                            $(".btnSuccess").click(function() {
                                location.reload();
                            })
                            break;
                        case ("Some input field is not set."):
                            failedMessage("Failed", results);
                            break;
                    }
                }
            })
        }
    }

    function addModalSwitchInvoiceList(current_selection) {
        console.log(current_selection);
        if ($("#search-customer_name").val() != "") {

            var currentPageNum;
            if ($("#currentPageNumSelectedCustomerInvoiceList").val() != 0) {
                if (parseInt($("#currentPageNumSelectedCustomerInvoiceList").val()) > parseInt($("#pageTotalSelectedCustomerInvoiceList").text())) {
                    currentPageNum = parseInt($("#pageTotalSelectedCustomerInvoiceList").text());
                } else {
                    currentPageNum = parseInt($("#currentPageNumSelectedCustomerInvoiceList").val());
                }
            } else {
                currentPageNum = 1;
            }
            switch (current_selection) {
                case ('all-invoice'):
                    $.ajax({
                        type: "POST",
                        url: "./backend/payment/payment.php",
                        data: {
                            postType: "viewInvoiceAll",
                            customer_account: $("#search-customer_id").val(),
                            pageNum: currentPageNum
                        },
                        success: function(results) {

                            switch (results) {

                                case ("No result"):
                                    $("#payment-bucket").empty().html(`
                                    <tr class="noResultText">
                                        <td colspan="11" class="text-center">
                                            <h5>No payment available</h5>
                                        </td>
                                    </tr>
                                    `);
                                    break;
                                case (""):
                                    $("#payment-bucket").empty().html(`
                                    <tr class="noResultText">
                                        <td colspan="11" class="text-center">
                                            <h5>No payment available</h5>
                                        </td>
                                    </tr>
                                    `);
                                    break;

                                default:
                                    createInvoiceListOnAddModal(results);
                                    countRowSelectedCustomerInvoice();
                                    break;
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    break;

                case ('outstanding-invoice'):
                    $.ajax({
                        type: "POST",
                        url: "./backend/payment/payment.php",
                        data: {
                            postType: "viewInvoiceOutstanding",
                            customer_account: $("#search-customer_id").val(),
                            pageNum: currentPageNum
                        },
                        success: function(results) {
                            switch (results) {

                                case ("No result"):
                                    $("#payment-bucket").empty().html(`
                                    <tr class="noResultText">
                                        <td colspan="11" class="text-center">
                                            <h5>No payment available</h5>
                                        </td>
                                    </tr>
                                    `);
                                    break;
                                case (""):
                                    $("#payment-bucket").empty().html(`
                                    <tr class="noResultText">
                                        <td colspan="11" class="text-center">
                                            <h5>No payment available</h5>
                                        </td>
                                    </tr>
                                    `);
                                    break;

                                default:
                                    createInvoiceListOnAddModal(results);
                                    countRowSelectedCustomerInvoice();
                                    break;
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    break;
            }
        }
    }

    function updateModalSwitchInvoiceList(payment_identifier) {
        $.ajax({
            type: "POST",
            url: "./backend/payment/payment.php",
            data: {
                postType: "viewPaymentUpdateAll",
                payment_identifier: payment_identifier
            },
            success: function(results) {
                console.log(results);
                console.log(payment_identifier);
                switch (results) {
                    case ("payment detail not found"):
                        $("#update-payment-bucket").empty().html(`
                        <tr class="noResultText">
                            <td colspan="11" class="text-center">
                                <h5>No payment available</h5>
                            </td>
                        </tr>
                        `);
                        break;

                    case ("No result"):
                        $("#update-payment-bucket").empty().html(`
                        <tr class="noResultText">
                            <td colspan="11" class="text-center">
                                <h5>No payment available</h5>
                            </td>
                        </tr>
                        `);
                        break;

                    case (""):
                        $("#update-payment-bucket").empty().html(`
                        <tr class="noResultText">
                            <td colspan="11" class="text-center">
                                <h5>No payment available</h5>
                            </td>
                        </tr>
                        `);
                        break;

                    default:
                        createInvoiceListOnUpdateModal(results);
                        break;
                }


            },
            error: function(e) {
                console.log(e);
            }
        });
        // switch (current_selection) {
        //     case ("all-invoice"):
        //         $.ajax({
        //             type: "POST",
        //             url: "./backend/payment/payment.php",
        //             data: {
        //                 postType: "viewPaymentUpdateAll",
        //                 payment_identifier: payment_identifier
        //             },
        //             success: function(results) {
        //                 console.log(results);
        //                 console.log(payment_identifier);
        //                 switch (results) {
        //                     case ("payment detail not found"):

        //                         break;

        //                     case ("No result"):

        //                         break;

        //                     case (""):

        //                         break;

        //                     default:
        //                         createInvoiceListOnUpdateModal(results);
        //                         break;
        //                 }


        //             },
        //             error: function(e) {
        //                 console.log(e);
        //             }
        //         });
        //         break;

        //     case ("outstanding-invoice"):
        //         $.ajax({
        //             type: "POST",
        //             url: "./backend/payment/payment.php",
        //             data: {
        //                 postType: "viewPaymentUpdateOutstanding",
        //                 payment_identifier: payment_identifier
        //             },
        //             success: function(results) {
        //                 console.log(results);
        //                 console.log(payment_identifier);
        //                 switch (results) {
        //                     case ("payment detail not found"):

        //                         break;

        //                     case ("No result"):

        //                         break;

        //                     case (""):

        //                         break;

        //                     default:
        //                         createInvoiceListOnUpdateModal(results);
        //                         break;
        //                 }
        //             },
        //             error: function(e) {
        //                 console.log(e);
        //             }
        //         });
        //         break;
        // }
    }

    function createInvoiceListOnAddModal(results) {
        var invoice_results;
        var total_outstanding = 0.00;
        var totalRowInvoiceAll = 0;
        var totalPageInvoiceAll = 0;
        var totalRowInvoiceOutstanding = 0;
        var totalPageInvoiceOutstanding = 0;
        switch (results) {
            case ("No result"):
                $("#payment-bucket").empty().html(`
                <tr class="noResultText">
                    <td colspan="11" class="text-center">
                        <h5>No payment available</h5>
                    </td>
                </tr>
                `);
                break;

            default:
                $.each(JSON.parse(results), function(i, value) {
                    var status = value.outstanding == 0 ? ["text-success", "paid", "disabled='disabled'", "checked"] : ["text-danger", "unpaid", "", ""];
                    total_outstanding += parseFloat(value.outstanding);
                    invoice_results += `
                    <tr class="item-row" data-id="${value.id}" data-invoice_id=${value.invoice_id}>
                        <td>
                            <button class="btn btn-danger showInvoiceDetailBtn py-md-3 px-md-4 p-sm-3">
                                <i class="fas fa-file-invoice"></i>
                            </button>
                        </td>
                        <td class="doc_no-${value.id}">${value.doc_no}</td>
                        <td class="doc_date-${value.id}">${value.creation_date}</td>
                        <td class="invoice_num-${value.id}">${value.invoice_num}</td>
                        <td class="invoice_date-${value.id}">${value.invoice_date}</td>
                        <td class="due_date-${value.id}">${value.due_date}</td>
                        <td class="total_amount-${value.id}">${value.total_amount}</td>
                        <td class="outstanding-${value.id}">${value.outstanding}</td>
                        <td class="payment-${value.id}">${value.payment}</td>
                        <td class="status-${value.id} ${status[0]} text-capitalize font-weight-bold text-center">${status[1]}</td>
                        <td class="total_price-${value.id} pay_item text-center">
                            <input type="checkbox" class="select_to_pay" data-current-payment-made="0" data-previous-outstanding="${value.outstanding}" data-previous-payment="${value.payment}" aria-label="${value.outstanding == 0 ? "paid" : "unpaid"}" ${status[2]} ${status[3]}/>
                        </td>
                    </tr>
                    `;
                });

                $("#total_outstanding").val(total_outstanding.toFixed(2));
                $("#payment-bucket").empty().html(invoice_results);
                break;
        }


        // $("#currentPageNucurrentPageNumSelectedCustomerInvoiceListmInvoiceAll").focusout(function() {
        //     totalRowInvoiceAll = countRowSelectedCustomerInvoiceAll();
        //     totalPageInvoiceAll = paginateSelectedCustomerInvoiceAll(totalRowInvoiceAll);
        // });


        $(".showInvoiceDetailBtn").click(function() {
            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "viewInvoiceDetail",
                    selected_id: $(this).parent().parent().data("invoice_id")
                },
                success: function(results) {

                    if (results == "No Result") {
                        failedMessage("Failed", "Could not find any invoice results");
                    } else {
                        var invoice_results;
                        var total_amount = 0;
                        var total_discount = 0;
                        $.each(JSON.parse(results), function(i, item) {
                            total_amount += parseFloat(item.amount);
                            total_discount += parseFloat(item.discount);
                            invoice_results += `
                            <tr>
                                <td>${item.item_no}</td>
                                <td>${item.description}</td>
                                <td>${item.quantity}</td>
                                <td>${item.uom}</td>
                                <td>${item.price}</td>
                                <td>${item.base_cost}</td>
                                <td>${item.discount}</td>
                                <td>${item.amount}</td>
                            </tr>
                            `;
                        })

                        $("#item-bucket").empty().html(invoice_results);
                        $("#total_discount").empty().text(total_discount.toFixed(2));
                        $("#total_cost").empty().text(total_amount.toFixed(2));
                        $("#invoiceDetailModal").modal("show");
                    }

                }
            });
        })

        $(".select_to_pay").click(function() {

            var row_item_id = $(this).parent().parent().data("id");
            if (parseFloat($("#total_payment").val()) > 0) {
                if (parseFloat($("#unapply_amount").val()) > 0) {
                    if ($(this).prop('checked') == true) {
                        var current_unapply_amount = parseFloat($("#unapply_amount").val());
                        var current_total_outstanding = parseFloat($("#total_outstanding").val());
                        var current_total_pay = parseFloat($("#total_pay").val());

                        var current_outstanding = parseFloat($(`.outstanding-${row_item_id}`).text());
                        var current_payment = parseFloat($(`.payment-${row_item_id}`).text());

                        var new_outstanding = current_unapply_amount < current_outstanding ? current_outstanding - current_unapply_amount : current_outstanding - current_outstanding;
                        var new_payment = current_unapply_amount < current_outstanding ? current_payment + current_unapply_amount : current_payment + current_outstanding;

                        var new_unapply_amount = current_unapply_amount < current_outstanding ? current_unapply_amount - current_unapply_amount : current_unapply_amount - current_outstanding;
                        var new_total_outstanding = current_unapply_amount < current_outstanding ? current_total_outstanding - current_unapply_amount : current_total_outstanding - current_outstanding;
                        var new_total_pay = current_unapply_amount < current_outstanding ? current_total_pay + current_unapply_amount : current_total_pay + current_outstanding;

                        var payment_made = current_unapply_amount < current_outstanding ? current_unapply_amount : current_outstanding;

                        $(this).attr(
                            "data-current-payment-made", payment_made
                        );

                        $(`.outstanding-${row_item_id}`).empty().text(new_outstanding.toFixed(2))
                        $(`.payment-${row_item_id}`).empty().text(new_payment.toFixed(2))

                        $("#total_pay").val(new_total_pay.toFixed(2))
                        $("#unapply_amount").val(new_unapply_amount.toFixed(2))
                        $("#total_outstanding").val(new_total_outstanding.toFixed(2))


                    } else {

                        var current_unapply_amount = parseFloat($("#unapply_amount").val());
                        var current_total_outstanding = parseFloat($("#total_outstanding").val());
                        var current_total_pay = parseFloat($("#total_pay").val());

                        var current_outstanding = parseFloat($(`.outstanding-${row_item_id}`).text());
                        var current_payment = parseFloat($(`.payment-${row_item_id}`).text());
                        var payment_made = parseFloat($(this).data("current-payment-made"));

                        var new_outstanding = current_outstanding + payment_made;
                        var new_payment = current_payment - payment_made;

                        var new_unapply_amount = current_unapply_amount + payment_made;
                        var new_total_outstanding = current_total_outstanding + payment_made;
                        var new_total_pay = current_total_pay - payment_made;

                        $(this).attr(
                            "data-current-payment-made", 0
                        );


                        $(`.outstanding-${row_item_id}`).empty().text(new_outstanding.toFixed(2))
                        $(`.payment-${row_item_id}`).empty().text(new_payment.toFixed(2))

                        $("#total_pay").val(new_total_pay.toFixed(2))
                        $("#unapply_amount").val(new_unapply_amount.toFixed(2))
                        $("#total_outstanding").val(new_total_outstanding.toFixed(2))


                    }
                } else {
                    if ($(this).prop('checked') == true) {
                        failedMessage("Failed", "Unapply amount currently is 0. Please add some credit in total payment to pay");
                        return false;
                    } else {

                        var current_unapply_amount = parseFloat($("#unapply_amount").val());
                        var current_total_outstanding = parseFloat($("#total_outstanding").val());
                        var current_total_pay = parseFloat($("#total_pay").val());

                        var current_outstanding = parseFloat($(`.outstanding-${row_item_id}`).text());
                        var current_payment = parseFloat($(`.payment-${row_item_id}`).text());
                        var payment_made = parseFloat($(this).data("current-payment-made"));

                        var new_outstanding = current_outstanding + payment_made;
                        var new_payment = current_payment - payment_made;

                        var new_unapply_amount = current_unapply_amount + payment_made;
                        var new_total_outstanding = current_total_outstanding + payment_made;
                        var new_total_pay = current_total_pay - payment_made;

                        $(this).attr(
                            "data-current-payment-made", 0
                        );

                        $(`.outstanding-${row_item_id}`).empty().text(new_outstanding.toFixed(2))
                        $(`.payment-${row_item_id}`).empty().text(new_payment.toFixed(2))

                        $("#total_pay").val(new_total_pay.toFixed(2))
                        $("#unapply_amount").val(new_unapply_amount.toFixed(2))
                        $("#total_outstanding").val(new_total_outstanding.toFixed(2))

                    }
                }
            } else {
                failedMessage("Failed", "Total Payment currently is 0. Please add some credit in total payment to pay");
                return false;
            }
            if (parseFloat($(`.outstanding-${row_item_id}`).text()) > 0) {
                $(`.status-${row_item_id}`).removeClass("text-success").addClass("text-danger").empty().text("unpaid");
            } else {
                $(`.status-${row_item_id}`).removeClass("text-danger").addClass("text-success").empty().text("paid");
            }

            if (parseFloat($("#total_pay").val()) == 0) {
                $("#addPaymentSubmitBtn").prop("disabled", true);
            } else {
                $("#addPaymentSubmitBtn").prop("disabled", false);
            }
        });

        $("#search-customer_id,#search-customer_name").on("keyup", function() {
            if ($("#search-customer_id").val() == "" && $("#search-customer_name").val() == "") {
                var noResult = `                           
                <tr class="noResultText">
                    <td colspan="11" class="text-center">
                        <h5>No payment available</h5>
                    </td>
                </tr>`;
                $("#payment-bucket").empty().html(noResult);
            }
        });

        $("#total_payment").on("focusout", function() {
            if (parseFloat($("#total_pay").val()) > 0) {
                var total_outstanding_deducted = 0;
                $("#total_pay").val("0.00");
                $("#unapply_amount").val($("#total_payment").val());
                $.each($('.item-row'), function(i, item) {
                    if ($(`.select_to_pay:eq(${i})`).attr('aria-label') === "unpaid") {
                        var invoice_id = $(`.item-row:eq(${i})`).data("id");

                        var original_payment = parseFloat($(`.select_to_pay:eq(${i})`).data("previous-payment"));
                        var original_outstanding = parseFloat($(`.select_to_pay:eq(${i})`).data("previous-outstanding"));

                        total_outstanding_deducted += original_outstanding
                        $(`.outstanding-${invoice_id}`).empty().text(original_outstanding.toFixed(2));
                        $(`.payment-${invoice_id}`).empty().text(original_payment.toFixed(2));
                        $(`.status-${invoice_id}`).removeClass("text-success").addClass("text-danger").empty().text("unpaid");
                        $(`.select_to_pay:eq(${i})`).prop("checked", false);

                    }
                });
                $("#total_outstanding").val(total_outstanding_deducted.toFixed(2))
            }
        });
    }

    function createInvoiceListOnUpdateModal(results) {
        var invoice_results;
        var total_outstanding = 0.00;
        var totalRowInvoiceAll = 0;
        var totalPageInvoiceAll = 0;
        var totalRowInvoiceOutstanding = 0;
        var totalPageInvoiceOutstanding = 0;

        switch (results) {
            case ("No result"):
                $("#update-payment-bucket").empty().html(`
                <tr class="noResultText">
                    <td colspan="11" class="text-center">
                        <h5>No payment available</h5>
                    </td>
                </tr>
                `);
                break;

            default:
                console.log(results);
                $.each(JSON.parse(results), function(i, value) {
                    //var status = value.outstanding == 0 ? ["text-success", "paid", "disabled='disabled'", "checked"] : ["text-danger", "unpaid", "", ""];
                    total_outstanding += parseFloat(value.outstanding);
                    invoice_results += `
                            <tr class="update-item-row" data-id="${value.id}" data-invoice_id=${value.invoice_id}>
                                <td>
                                    <button class="btn btn-danger showInvoiceDetailBtn py-md-3 px-md-4 p-sm-3">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                </td>
                                <td class="update-doc_no-${value.id}">${value.doc_no}</td>
                                <td class="update-doc_date-${value.id}">${value.creation_date}</td>
                                <td class="update-invoice_num-${value.id}">${value.invoice_num}</td>
                                <td class="update-invoice_date-${value.id}">${value.invoice_date}</td>
                                <td class="update-due_date-${value.id}">${value.due_date}</td>
                                <td class="update-total_amount-${value.id}">${parseFloat(value.total_amount).toFixed(2)}</td>
                                <td class="update-outstanding update-outstanding-${value.id}" data-original-outstanding="${value.outstanding}">${parseFloat(value.outstanding).toFixed(2)}</td>
                                <td class="update-payment-${value.id}">
                                    <div class="input-group md-form form-sm form-2 pl-0">
                                        <input value="${parseFloat(value.payment).toFixed(2)}" data-original-payment="${value.payment}" class="form-control update_payment_per_invoice update-payment-amount-${value.id}" type="number" min="0" step="0.01"/>
                                        <div class="input-group-append">
                                            <button data-original-payment="${value.payment}" data-new-payment="0.00" class="pageInput input-group-text update_payment_refresh update_payment_refresh-${value.id}">
                                                <i class="fas fa-sync-alt" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            `;
                });

                $("#update-total_outstanding").val(total_outstanding.toFixed(2));
                $("#update-payment-bucket").empty().html(invoice_results);
                break;
        }
        $(".update_payment_per_invoice").on("focusout", function() {
            var new_payment = parseFloat($(this).val());
            var current_id = $(this).parent().parent().parent().data("id");
            var current_amount = parseFloat($(`.update-total_amount-${current_id}`).text());
            var original_outstanding = parseFloat($(`.update-outstanding-${current_id}`).text());
            var original_payment = parseFloat($(this).data("original-payment"));
            var total_outstanding = 0;
            var total_paid = 0;

            if (new_payment > current_amount) {
                $(this).val(current_amount.toFixed(2));
            } else if (new_payment < 0) {
                $(this).val("0.00");
            } else {
                $(this).val(new_payment.toFixed(2));
            }

            $(`.update-outstanding-${current_id}`).text((original_outstanding - (new_payment - original_payment)).toFixed(2));
            $(`.update_payment_refresh-${current_id}`).attr("data-new-payment", new_payment);

            $.each($(".update-item-row"), function(i, item) {
                total_outstanding += parseFloat($(`.update-outstanding:eq(${i})`).text());
                total_paid += parseFloat($(`.update_payment_per_invoice:eq(${i})`).val());
            });

            $("#update-total_outstanding").val(total_outstanding.toFixed(2));
            $("#update-total_pay").val(total_paid.toFixed(2));

        });

        $(".update_payment_refresh").click(function() {

            var total_outstanding = 0;
            var total_paid = 0;
            var current_id = $(this).parent().parent().parent().parent().data("id");
            var original_outstanding = parseFloat($(`.update-outstanding-${current_id}`).data("original-outstanding"));
            var original_payment = parseFloat($(this).data("original-payment"));

            console.log(original_outstanding);

            $(`.update-outstanding-${current_id}`).text(original_outstanding.toFixed(2));
            $(`.update-payment-amount-${current_id}`).val(original_payment.toFixed(2));

            $.each($(".update-item-row"), function(i, item) {
                total_outstanding += parseFloat($(`.update-outstanding:eq(${i})`).text());
                total_paid += parseFloat($(`.update_payment_per_invoice:eq(${i})`).val());
            });

            $("#update-total_outstanding").val(total_outstanding.toFixed(2));
            $("#update-total_pay").val(total_paid.toFixed(2));
        })

        $(".showInvoiceDetailBtn").click(function() {

            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "viewInvoiceHeader",
                    selected_id: $(this).parent().parent().data("invoice_id")
                },
                success: function(results) {

                    if (results == "No Result") {

                    } else {
                        $.each(JSON.parse(results), function(i, item) {
                            $("#detail-invoice_id").text(item.invoice_id);
                            $("#detail-in_account").text(item.in_account);
                            $("#detail-in_name").text(item.in_name);
                            $("#detail-invoice_num").text(item.invoice_num);
                            $("#detail-invoice_date").text(item.invoice_date);
                            $("#detail-invoice_date").text(item.invoice_date);
                            $("#detail-invoice_remark").text(item.invoice_remark);
                            $("#detail-doc_no").text(item.doc_no);
                            $("#detail-due_date").text(item.due_date);
                            $("#detail-subtotal_ex").text(item.subtotal_ex);
                            $("#detail-discount_header").text(item.discount_header);
                            $("#detail-total_amount").text(item.total_amount);
                        });
                    }
                }
            });
            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "viewInvoiceDetail",
                    selected_id: $(this).parent().parent().data("invoice_id")
                },
                success: function(results) {

                    if (results == "No Result") {
                        failedMessage("Failed", "Could not find any invoice results");
                    } else {
                        var invoice_results;
                        var total_amount = 0;
                        var total_discount = 0;
                        $.each(JSON.parse(results), function(i, item) {
                            total_amount += parseFloat(item.amount);
                            total_discount += parseFloat(item.discount);
                            invoice_results += `
                                    <tr>
                                        <td>${item.item_no}</td>
                                        <td>${item.description}</td>
                                        <td>${item.quantity}</td>
                                        <td>${item.uom}</td>
                                        <td>${item.price}</td>
                                        <td>${item.base_cost}</td>
                                        <td>${item.discount}</td>
                                        <td>${item.amount}</td>
                                    </tr>
                                    `;
                        })

                        $("#item-bucket").empty().html(invoice_results);
                        $("#total_discount").empty().text(total_discount.toFixed(2));
                        $("#total_cost").empty().text(total_amount.toFixed(2));
                        $("#invoiceDetailModal").modal("show");
                    }

                }
            });
        })


        $("#update-total_payment").on("focusout", function() {

            if (parseFloat($("#update-total_pay").val()) > 0) {

                var total_outstanding_deducted = 0;
                $("#update-total_pay").val($("#update-total_pay").data("original-payment-made"));
                $.each($('.update-item-row'), function(i, item) {
                    if ($(`.update-select_to_pay:eq(${i})`).attr('aria-label') === "unpaid") {
                        var invoice_id = $(`.update-item-row:eq(${i})`).data("id");

                        var original_payment = parseFloat($(`.update-select_to_pay:eq(${i})`).data("previous-payment"));
                        var original_outstanding = parseFloat($(`.update-select_to_pay:eq(${i})`).data("previous-outstanding"));

                        total_outstanding_deducted += original_outstanding
                        $(`.update-outstanding-${invoice_id}`).empty().text(original_outstanding.toFixed(2));
                        $(`.update-payment-${invoice_id}`).empty().text(original_payment.toFixed(2));
                        $(`.update-status-${invoice_id}`).removeClass("text-success").addClass("text-danger").empty().text("unpaid");
                        $(`.update-select_to_pay:eq(${i})`).prop("checked", false);

                    }
                });
                $("#update-total_outstanding").val(total_outstanding_deducted.toFixed(2))
            }
        });
    }

    function fillUpdatePaymentModal(customer_account, customer_name, payment_identifier, payment_id, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount) {

        $("#update-search-customer_name").val(customer_name);
        $("#update-search-customer_id").val(customer_account);
        $("#update_identifier_id").val(payment_identifier);
        $("#update_payment_id").val(payment_id);
        $("#update-payment_date").val(payment_date);
        $("#update-payment_remark").val(payment_remark);
        $("#update-payment_salesperson").val(payment_salesperson);
        $("#update-payment_mode").val(payment_mode);
        $("#update-total_pay").val(total_payment_amount).attr(
            "data-original-payment-made", total_payment_amount
        );

        updateModalSwitchInvoiceList(payment_identifier);

    }

    function addPayment() {
        var id = [];
        var invoice_id = [];
        var total_amount = [];
        var outstanding = [];
        var payment = [];
        var payment_status = [];

        var payment_mode = "";
        var payment_remark = "";
        var payment_date = "";
        var payment_salesperson = "";
        var total_payment_amount = "";

        var customer_account = "";
        var customer_name = "";

        if ($("#payment-bucket").find(".noResultText").length > 0) {
            failedMessage("Failed", "No invoice found");
        } else {
            $.each($(".item-row"), function(i, item) {
                var row_id = $(`.item-row:nth-child(${i+1})`).data('id');
                //if ($(`.select_to_pay:eq(${i})`).data("current-payment-made") > 0 && $(`.status-${row_id}`).text() === "paid") {
                if ($(`.select_to_pay:eq(${i})`).prop("checked") == true && $(`.select_to_pay:eq(${i})`).data("current-payment-made") > 0) {
                    id.push(row_id);
                    invoice_id.push($(`.item-row:nth-child(${i+1})`).data('invoice_id'));
                    total_amount.push(parseFloat($(`.total_amount-${row_id}`).text()));
                    outstanding.push(parseFloat($(`.outstanding-${row_id}`).text()));
                    payment.push(parseFloat($(`.payment-${row_id}`).text()));
                    payment_status.push($(`.status-${row_id}`).text());
                }
            })
            payment_mode = $("#payment_mode").val();
            payment_remark = $('#payment_remark').val();
            payment_date = $("#payment_date").val();
            payment_salesperson = $("#payment_salesperson").val();
            total_payment_amount = $("#total_pay").val();
            customer_account = $("#search-customer_id").val();
            customer_name = $("#search-customer_name").val();

            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "pay",
                    id: id,
                    invoice_id: invoice_id,
                    total_amount: total_amount,
                    outstanding: outstanding,
                    payment: payment,
                    payment_status: payment_status,
                    payment_mode: payment_mode,
                    payment_date: payment_date,
                    payment_remark: payment_remark,
                    payment_salesperson: payment_salesperson,
                    total_payment_amount: total_payment_amount,
                    customer_account: customer_account,
                    customer_name: customer_name
                },
                success: function(results) {
                    console.log(results);
                    switch (results) {
                        case ("success pay"):
                            $("#addModal").modal("hide");
                            successMessage("Success", "Payment is successfully added");
                            $(".btnSuccess").click(function() {
                                location.reload();
                            })
                            break;
                        case ("Some input field is not set."):
                            failedMessage("Failed", results);
                            break;
                    }
                }
            })
        }
    }

    function countRowSelectedCustomer() {
        var totalRowCount;
        $.ajax({
            type: "POST",
            url: "./backend/payment/payment.php",
            data: {
                postType: "countRowSelectedCustomer",
                customer_account: $("#curent_customer_payment_history").data("customer-name")
            },
            async: false,
            success: function(results) {

                $("#rowTotal").empty().append(results);
                totalRowCount = results;
            }
        });

        return totalRowCount;
    }


    function countRow() {

        var totalRowCount;

        $.ajax({
            type: "POST",
            url: "./backend/payment/payment.php",
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
        var rowperpage = 20;
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
        var currentPageNum = 1;
        var postType = "";
        var customer_search_input = "";
        var customer_account = "";

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

        if ($("#global_search_customer_input").val() != "") {
            postType = "viewPaymentHeaderByCustomer";
            customer_search_input = $("#global_search_customer_input").val();
        } else {
            postType = "viewPaymentHeader";
            customer_account = "";
        }
        console.log(postType);
        console.log(customer_search_input);
        $.ajax({
            type: "POST",
            url: "./backend/payment/payment.php",
            data: {
                postType: postType,
                customer_account: customer_search_input,
                pageNum: currentPageNum
            },
            success: function(results) {
                console.log(results);
                if (results == "0 results" || results == "No Result" || results == "no customer found") {

                    renderTable("general");
                    tableSetting("general");

                } else {

                    results = results.includes("Success") ? JSON.parse(results.replace('Success', '')) : JSON.parse(results);
                    renderContent(results, "general");

                    $(".printBtn").click(function() {
                        var id = $(this).parent().parent().data("id");
                        $("#print_id").val(id);
                        $("#customer_name").val($(this).parent().parent().find(".customer_account").text());
                    })

                    $(".deleteBtn").click(function() {
                        var payment_identifier = $(this).parent().parent().data("id");
                        var payment_id = $(this).parent().parent().data("payment-id");
                        $("#delete_data").attr({
                            "data-payment_identifier": payment_identifier,
                            "data-payment_id": payment_id,
                        });

                    })

                    $(".editBtn").click(function() {
                        var customer_account = $(this).parent().parent().find(".customer_account").text();
                        var customer_name = $(this).parent().parent().find(".customer_name").text();
                        var payment_identifier = $(this).parent().parent().data("id");
                        var payment_id = $(this).parent().parent().data("payment-id");
                        var payment_date = $(this).parent().parent().find(".payment_date").text();
                        var payment_mode = $(this).parent().parent().find(".payment_mode").text();
                        var payment_salesperson = $(this).parent().parent().find(".payment_salesperson").text();
                        var payment_remark = $(this).parent().parent().find(".payment_remark").text();
                        var total_payment_amount = $(this).parent().parent().find(".total_payment_amount").text();
                        fillUpdatePaymentModal(customer_account, customer_name, payment_identifier, payment_id, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount);

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
                    ' <th scope="col" class="th-lg">Payment Identifier</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Payment Date</th> ' +
                    ' <th scope="col" class="th-lg">Payment Mode</th> ' +
                    ' <th scope="col" class="th-lg">Payment Sales Person</th> ' +
                    ' <th scope="col" class="th-lg">Payment Remark</th> ' +
                    ' <th scope="col" class="th-lg">Total Payment Amount</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="generalContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Payment Identifier</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Customer Name</th> ' +
                    ' <th scope="col" class="th-lg">Payment Date</th> ' +
                    ' <th scope="col" class="th-lg">Payment Mode</th> ' +
                    ' <th scope="col" class="th-lg">Payment Sales Person</th> ' +
                    ' <th scope="col" class="th-lg">Payment Remark</th> ' +
                    ' <th scope="col" class="th-lg">Total Payment Amount</th> ' +
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
                $.each(results, function(i, payment) {
                    $("#generalContent").append(`
                        <tr class="payment_row" data-payment-id="${payment.payment_id}" data-id="${payment.payment_identifier}">
                            <th>${++i}</th>
                            <td>
                                <button class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-secondary printBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#printModal">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                            <td class="payment_identifier">${payment.payment_identifier}</td>
                            <td class="customer_account">${payment.customer_account}</td>
                            <td class="customer_name">${payment.customer_name}</td>
                            <td class="payment_date">${payment.payment_date}</td>
                            <td class="payment_mode">${payment.payment_mode}</td>
                            <td class="payment_salesperson">${payment.payment_salesperson}</td>
                            <td class="payment_remark">${payment.payment_remark}</td>
                            <td class="total_payment_amount">${payment.total_payment_amount}</td>
                        </tr>
                    `);
                });
                tableSetting("general");
                break;
        }
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
});