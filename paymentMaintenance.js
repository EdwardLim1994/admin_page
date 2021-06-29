$(document).ready(function() {

    var totalRow = countRow();
    var totalPage = paginate(totalRow);
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

    $("#addPaymentSubmitBtn").click(function() {
        if (parseFloat($("#total_payment").val()) != 0)
            addPayment();
        else
            failedMessage("Failed", "Total Payment currently is 0. Please add some credit in total payment to pay");
    });


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
            $("#customer-search").empty().removeClass("bg-white").addClass("border").html(`
            <div class="d-flex justify-content-center bg-white border search-result-spinner">
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
                            $("#customer-search").empty().removeClass("border").removeClass("bg-white");
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
                            $("#customer-search").empty().addClass("bg-white").html(searchResult);
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

            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "viewInvoiceAll",
                    account_num: $(this).find(".customerID").text(),
                    pageNum: 1
                },
                success: function(results) {
                    var invoice_results;
                    var total_outstanding = 0.00;
                    if (results != "") {
                        $.each(JSON.parse(results), function(i, value) {
                            var status = value.outstanding == 0 ? ["text-success", "paid", "disabled", "checked"] : ["text-danger", "unpaid", "", ""];
                            total_outstanding += parseFloat(value.outstanding);
                            invoice_results += `
                            <tr class="item-row" data-id="${value.id}" data-invoice_id=${value.invoice_id}>
                                <td>
                                    <button class="btn btn-danger showInvoiceDetailBtn py-md-3 px-md-4 p-sm-3">
                                        <i class="fas fa-trash-alt"></i>
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
                                <td class="total_price-${value.id} text-center">
                                    <input type="checkbox" class="select_to_pay" ${status[2]} ${status[3]}/>
                                </td>
                            </tr>
                            `;
                        })

                        $("#total_outstanding").val(total_outstanding.toFixed(2));
                        $("#payment-bucket").empty().html(invoice_results);
                    }

                    $(".showInvoiceDetailBtn").click(function() {
                        $.ajax({
                            type: "POST",
                            url: "./backend/payment/payment.php",
                            data: {
                                postType: "viewInvoiceDetail",
                                selected_id: $(this).parent().parent().data("invoice_id")
                            },
                            success: function(results) {
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
                        });
                    })

                    $(".select_to_pay").click(function() {
                        //TODO: finish select to pay logic
                        var row_item_id = $(this).parent().parent().data("id");

                        var unapply_amount = parseFloat($("#unapply_amount").val());
                        var current_total_outstanding = parseFloat($("#total_outstanding").val());

                        var current_outstanding = parseFloat($(`.outstanding-${row_item_id}`).text());
                        var current_payment = parseFloat($(`.payment-${row_item_id}`).text());
                        var new_outstanding = unapply_amount - current_outstanding < 0 ? current_outstanding - unapply_amount : 0.00;
                        var new_payment = unapply_amount - current_outstanding < 0 ? unapply_amount : current_outstanding;

                        var deducted_outstanding = current_outstanding - new_outstanding;


                        $(`.outstanding-${row_item_id}`).text(new_outstanding.toFixed(2));
                        $(`.payment-${row_item_id}`).text(current_payment + new_payment);
                        $("#unapply_amount").val(parseFloat(new_unapply_amount).toFixed(2));
                        $("#total_pay").val((parseFloat($("#total_pay").val()) + new_payment).toFixed(2));
                        $("#total_outstanding").val(current_total_outstanding + deducted_outstanding)

                        if (parseFloat($("#total_payment").val()) > 0) {
                            if (parseFloat($("#unapply_amount").val()) > 0) {
                                if ($(this).prop('checked') == true) {

                                    $(`.outstanding-${row_item_id}`).text(new_outstanding.toFixed(2));
                                    $(`.payment-${row_item_id}`).text((current_payment + new_payment).toFixed(2));

                                    $("#unapply_amount").val(parseFloat(unapply_amount - new_payment).toFixed(2));
                                    $("#total_pay").val((parseFloat($("#total_pay").val()) + new_payment).toFixed(2));
                                    $("#total_outstanding").val(parseFloat(current_total_outstanding + deducted_outstanding).toFixed(2));

                                    if (outstanding == 0) {
                                        $(`.status-${row_item_id}`).removeClass("text-danger").addClass("text-success").empty().text("paid");
                                    }
                                } else {
                                    $(`.outstanding-${row_item_id}`).text((parseFloat($(`.payment-${row_item_id}`).text()) + parseFloat($(`.outstanding-${row_item_id}`).text())).toFixed(2));
                                    $(`.payment-${row_item_id}`).text((parseFloat($(`.payment-${row_item_id}`).text()) - payment).toFixed(2));

                                    $("#unapply_amount").val((parseFloat($("#unapply_amount").val()) + payment).toFixed(2));
                                    $("#total_pay").val((parseFloat($("#total_pay").val()) - payment).toFixed(2));

                                    $(`.outstanding-${row_item_id}`).text(new_outstanding.toFixed(2));
                                    $(`.payment-${row_item_id}`).text((current_payment + new_payment).toFixed(2));

                                    $("#unapply_amount").val(parseFloat(unapply_amount - new_payment).toFixed(2));
                                    $("#total_pay").val((parseFloat($("#total_pay").val()) + new_payment).toFixed(2));
                                    $("#total_outstanding").val(parseFloat(current_total_outstanding + deducted_outstanding).toFixed(2));

                                    if (outstanding == 0) {
                                        $(`.status-${row_item_id}`).removeClass("text-success").addClass("text-danger").empty().text("unpaid");
                                    }
                                }
                                return true
                            } else {

                                if ($(this).prop('checked') == false) {
                                    $("#unapply_amount").val(parseFloat(unapply_amount - new_payment).toFixed(2));
                                    $("#total_pay").val((parseFloat($("#total_pay").val()) + new_payment).toFixed(2));
                                    $("#total_outstanding").val(current_total_outstanding + deducted_outstanding);

                                    $(`.outstanding-${row_item_id}`).text(new_outstanding.toFixed(2));
                                    $(`.payment-${row_item_id}`).text("0.00");

                                    if (outstanding == 0) {
                                        $(`.status-${row_item_id}`).removeClass("text-success").addClass("text-danger").empty().text("unpaid");
                                    }
                                } else {
                                    failedMessage("Failed", "Unapply amount currently is 0. Please add some credit in total payment to pay");
                                    return false;
                                }
                            }
                        } else {
                            failedMessage("Failed", "Total Payment currently is 0. Please add some credit in total payment to pay");
                            return false;
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
                        $.each($(".item-row"), function(i, item) {
                            var invoice_id = $(`.item-row:nth-child(${i+1})`).data("id");
                            $(`.total_price-${invoice_id}>.select_to_pay`).prop('checked', false);
                            if ($(`.status-${invoice_id}`).text() === "unpaid" && parseFloat($(`.payment-${invoice_id}`).text()) == 0) {


                                $(`.outstanding-${invoice_id}`).empty().text($(`.total_amount-${invoice_id}`).text());
                                $(`.payment-${invoice_id}`).empty().text("0.00");
                                $(`.status-${invoice_id}`).removeClass("text-success").addClass("text-danger").empty().text("unpaid");
                            }
                        });
                    });
                },
                error: function(e) {
                    console.log(e);
                }
            });
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

        if ($("#payment-bucket").find(".noResultText").length > 0) {
            failedMessage("Failed", "No invoice found");
        } else {
            $.each($(".item-row"), function(i, item) {
                var row_id = $(`.item-row:nth-child(${i+1})`).data('id');
                id.push(row_id);
                invoice_id.push($(`.item-row:nth-child(${i+1})`).data('invoice_id'));
                total_amount.push(parseFloat($(`.total_amount-${row_id}`).text()));
                outstanding.push(parseFloat($(`.outstanding-${row_id}`).text()));
                payment.push(parseFloat($(`.payment-${row_id}`).text()));
                payment_status.push($(`.status-${row_id}`).text());
            })
            payment_mode = $("#payment_mode").val();
            payment_remark = $('#payment_remark').val();
            payment_date = $("#payment_date").val();
            payment_salesperson = $("#payment_salesperson").val();

            $.ajax({
                type: "POST",
                url: "./backend/payment/payment.php",
                data: {
                    postType: "pay",
                    id: id,
                    invoice_id: invoice_id,
                    payment_mode: payment_mode,
                    total_amount: total_amount,
                    outstanding: outstanding,
                    payment: payment,
                    payment_status: payment_status,
                    payment_date: payment_date,
                    payment_remark: payment_remark,
                    payment_salesperson: payment_salesperson
                },
                success: function(results) {
                    console.log(results);
                    switch (results) {
                        case ("success pay"):
                            $("#addModal").modal("hide");
                            successMessage("Success", "Invoice is successfully added");
                            $("#general-table").empty();
                            $("#currentPageNum").val(1);
                            $(".btnSuccess").click(function() {
                                window.reload();
                            })
                        case ("Some input field is not set."):
                            $("#addModal").modal("hide");
                            failedMessage("Failed", results);
                            break;
                    }
                }
            })
        }
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
            url: "./backend/payment/printPayment.php",
            data: {
                postType: "paymentList",
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

                    $(".printBtn").click(function() {
                        var id = $(this).parent().parent().data("id");
                        $("#print_id").val(id);
                        $("#customer_name").val($(this).parent().parent().find(".customer_account").text());
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
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Payment Date</th> ' +
                    ' <th scope="col" class="th-lg">Invoice ID</th> ' +
                    ' </tr> ' +
                    ' </thead> ' +
                    ' <tbody id="generalContent"> ' +
                    ' </tbody> ' +
                    ' <tfoot class="grey lighten-2"> ' +
                    ' <tr> ' +
                    ' <th scope="col">#</th> ' +
                    ' <th scope="col" class="text-center th-lg">Action</th> ' +
                    ' <th scope="col" class="th-lg">Customer Account</th> ' +
                    ' <th scope="col" class="th-lg">Payment Date</th> ' +
                    ' <th scope="col" class="th-lg">Invoice ID</th> ' +
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
                        <tr class="payment_row" data-id="${payment.payment_identifier}">
                            <th>${++i}</th>
                            <td>
                                <button class="btn btn-secondary printBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#printModal">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                            <td class="customer_account">${payment.customer_account}</td>
                            <td class="payment_date">${payment.payment_date}</td>
                            <td class="invoice_id">${payment.invoice_id}</td>
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