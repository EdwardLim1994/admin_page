<!-- Sale Order Section -->
<div class="container my-4">
    <!-- Add Sales order button -->
    <div class="row">
        <div class="text-right col-12">
            <!-- <button id="onholdSalesPaymentModalBtn" class="btn btn-warning py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#onholdSalesPaymentModal">
                <span>View OnHold Payment</span>
                <span class="iconBreak"><i class="fas fa-file-invoice"></i></span>
            </button> -->
            <button id="addSalesOrderModalBtn" class="btn btn-danger py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addSalesOrderModal">
                <span>Add Sales Order</span>
                <!-- <span class="iconBreak"><i class="fas fa-file-invoice"></i></span> -->
            </button>
        </div>
    </div>

    <!-- Total row -->
    <!-- Pagination -->
    <div class="row">
        <div class="col-4 d-flex flex-column justify-content-end">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="paid" id="salesorderShowingPaid" name="showingsalesordermode" checked>
                <label for="salesorderShowingPaid" class="custom-control-label">Show Paid Sale Order</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="onhold" id="salesorderShowingOnhold" name="showingsalesordermode">
                <label for="salesorderShowingOnhold" class="custom-control-label">Show Onhold Sale Order</label>
            </div>

            <!-- <label class="text-left w-100 h5-responsive" for="salesorder_filter_select">Showing Onhold Payment: </label>
            <select class="mt-2 browser-default custom-select" id="salesorder_filter_select">
                <option value="all" selected>No</option>
                <option value="onhold">Yes</option>
            </select> -->
        </div>
        <div class="text-right col-8 d-flex flex-column justify-content-end ">
            <div class="pb-4 rowResults">
                <h6 class="my-auto">Total rows in database: <span class="font-weight-bold" id="salesorder-rowTotal"></span></h6>
            </div>
            <div class="mt-4 pageWrapper">
                <h5>Page : </h5>
                <input type="number" id="salesorder-currentPageNum" class="form-control pageNumInput" min="1" value="<?= isset($_SESSION['currPage']) ? $_SESSION['currPage'] : 1 ?>">
                <h5> of <span id="salesorder-pageTotal"></span></h5>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="my-3 row">
        <div class="col-12">
            <div id="salesorder-table" class='table-responsive'></div>
        </div>
    </div>

    <!-- Add sales order modal -->
    <div class="modal fade" id="addSalesOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">

                    <div class="modal-header">
                        <p class="heading lead">Add Sales Order</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <div class="modal-footer w-100 justify-content-end">
                        <button id="onholdSalesOrderSubmitBtn" class="btn btn-warning">On Hold</button>
                        <button id="addSalesOrderSubmitBtn" class="btn btn-info">Pay</button>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Amount Paid</h3>
                                <h5>RM <span id="salespayment_amountPaid">0.00</span></h5>
                            </div>
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Total Charge</h3>
                                <h5>RM <span id="salespayment_totalCharge">0.00</span></h5>
                            </div>
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Change</h3>
                                <h5>RM <span id="salespayment_exchange">0.00</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group ">

                        <h3>Item Information</h3>

                        <div class="pb-5 row ">
                            <div class="col-12">
                                <div class="position-relative">
                                    <label for="salesorder-search-item">Item Name or Barcode:</label>
                                    <input type="text" autocomplete="off" class="form-control" id="salesorder-search-item" placeholder="">

                                    <!-- Item search result -->
                                    <div id="salesorder-item-search" class="m-0 bg-white w-100 position-absolute" style="z-index:5;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-auto">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="grey white-text">
                                    <tr>
                                        <th class="text-center th-sm">Action</th>
                                        <th class="text-center th-sm">Barcode
                                        </th>
                                        <th class="text-center th-sm">Description
                                        </th>
                                        <th class="text-center th-sm">Qty
                                        </th>
                                        <th class="text-center th-sm">UOM
                                        </th>
                                        <th class="text-center th-sm">Selling Price(RM)
                                        </th>
                                        <th class="text-center th-sm">Discount(%)
                                        </th>
                                        <th class="text-center th-sm">Amount(RM)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="salesorder-item-bucket">
                                    <tr class="salesorder-noResultText">
                                        <td colspan="9" class="text-center">
                                            <h5>No item added yet</h5>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="grey white-text">
                                    <tr>
                                        <th colspan="7" class="text-right"><strong>Discount : </strong></th>
                                        <th id="salesorder-total_discount"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="7" class="text-right"><strong>Total Amount : </strong></th>
                                        <th id="salesorder-total_cost"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">

                        <h3>Payment Information</h3>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="salespayment-amount_apply">Payment Amount</label>
                                    <input type="number" value="0.00" min="0" step="0.01" class="form-control" id="salespayment-amount_apply" placeholder="">

                                </div>

                                <div class="col-6">
                                    <label for="salespayment-payment_mode">Payment Mode</label>
                                    <select class="browser-default custom-select" name="customer_account" id="salespayment-payment_mode">
                                        <option value="cash" selected="selected">Cash</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="salesorder-salesperson">Salesperson:</label>
                                <input type="text" class="form-control" name="customer_account" id="salesorder-salesperson" placeholder="">

                            </div>
                            <div class="col-6">
                                <label for="salespayment-reference">Reference</label>
                                <input class="form-control" type="text" id="salespayment-reference">
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="form-group position-relative">
                        <h3>Customer Information</h3>
                        <div class="row">
                            <div class="col-6">
                                <label for="salesorder-search-customer_name">Customer Name</label>
                                <input type="text" autocomplete="off" class="form-control" name="customer_account" id="salesorder-search-customer_name" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="edit-customer_account">Account Number</label>
                                <input type="text" autocomplete="off" class="form-control" name="customer_account" id="salesorder-search-customer_id" placeholder="">
                            </div>
                        </div>

                        <!-- Customer search result -->
                        <div id="salesorder-customer-search" class="m-0 bg-white w-100 position-absolute" style="z-index:5;"></div>
                    </div>
                    <hr>


                </div>
            </div>
        </div>
    </div>

    <!-- Update sales order modal -->
    <div class="modal fade" id="editSalesOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <!--Content-->
            <input hidden="true" type="text" id="update-salesorder_id">
            <input hidden="true" type="text" id="update-salesorder_payment_status">
            <input hidden="true" type="text" id="update-salesorder_isOnHold">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">

                    <div class="modal-header">
                        <p class="heading lead">Update Sales Order</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-end">

                        <button id="editSalesOrderSubmitBtn" class="btn btn-warning">Update</button>
                        <button id="editonholdSalesOrderSubmitBtn" class="btn btn-info">Pay</button>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Amount Paid</h3>
                                <h5>RM <span id="update-salesorder_amountPaid">0.00</span></h5>
                            </div>
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Total Charge</h3>
                                <h5>RM <span id="update-salesorder_totalCharge">0.00</span></h5>
                            </div>
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Change</h3>
                                <h5>RM <span id="update-salesorder_exchange">0.00</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group ">

                        <h3>Item Information</h3>

                        <div class="pb-5 row ">
                            <div class="col-12">
                                <div class="position-relative">
                                    <label for="salesorder-update-search-item">Item Name or Barcode:</label>
                                    <input type="text" autocomplete="off" class="form-control" id="salesorder-update-search-item" placeholder="">

                                    <!-- Item search result -->
                                    <div id="salesorder-update-item-search" class="m-0 bg-white w-100 position-absolute" style="z-index:5;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-auto">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="grey white-text">
                                    <tr>
                                        <th class="text-center th-sm">Action</th>
                                        <th class="text-center th-sm">Barcode
                                        </th>
                                        <th class="text-center th-sm">Description
                                        </th>
                                        <th class="text-center th-sm">Qty
                                        </th>
                                        <th class="text-center th-sm">UOM
                                        </th>
                                        <th class="text-center th-sm">Selling Price(RM)
                                        </th>
                                        <th class="text-center th-sm">Discount(%)
                                        </th>
                                        <th class="text-center th-sm">Amount(RM)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="salesorder-update-item-bucket">
                                    <tr class="salesorder-update-noResultText">
                                        <td colspan="9" class="text-center">
                                            <h5>No item added yet</h5>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="grey white-text">
                                    <tr>
                                        <th colspan="7" class="text-right"><strong>Discount : </strong></th>
                                        <th id="salesorder-update-total_discount"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="7" class="text-right"><strong>Total Amount : </strong></th>
                                        <th id="salesorder-update-total_cost"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">

                        <h3>Receive Information</h3>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="salesorder-update-amount_apply">Payment Amount</label>
                                    <input type="number" value="0.00" min="0" step="0.01" class="form-control" id="salesorder-update-amount_apply" placeholder="">

                                </div>

                                <div class="col-6">
                                    <label for="salesorder-update-payment_mode">Payment Mode</label>
                                    <select class="browser-default custom-select" name="customer_account" id="salesorder-update-payment_mode">
                                        <option value="cash" selected="selected">Cash</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="salesorder-update-salesperson">Salesperson:</label>
                                <input type="text" class="form-control" name="customer_account" id="salesorder-update-salesperson" placeholder="">

                            </div>
                            <div class="col-6">
                                <label for="salesorder-update-reference">Reference</label>
                                <input class="form-control" type="text" id="salesorder-update-reference">
                            </div>

                        </div>

                    </div>
                    <div class="form-group position-relative">
                        <div class="row">
                            <div class="col-6">
                                <label for="salesorder-search-customer_name">Customer Name</label>
                                <input type="text" autocomplete="off" class="form-control" name="customer_account" id="salesorder-update-search-customer_name" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="salesorder-update-search-customer_id">Account Number</label>
                                <input type="text" autocomplete="off" class="form-control" name="customer_account" id="salesorder-update-search-customer_id" placeholder="">
                            </div>
                        </div>

                        <!-- Customer search result -->
                        <div id="salesorder-update-customer-search" class="m-0 bg-white w-100 position-absolute" style="z-index:5;"></div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>
    </div>
    <!-- Delete Sales order modal -->
    <div class="modal fade" id="deleteSalesOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-notify modal-warning" role="document">

            <input hidden="true" type="text" name="invoice_id" id="delete_id">
            <input hidden="true" type="text" name="invoice_id" id="salesorderDelete_isPaid">
            <input hidden="true" type="text" id="salesorderDelete_isOnHold">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading">Delete Sales Order</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <p>Are you want to delete <span id="deleteSalesOrderName"></span>?</p>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <button id="deleteSalesOrderSubmitButton" class="btn btn-warning">Yes</button>
                    <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Nevermind</a>
                </div>
            </div>
            <!-- </form> -->
        </div>
    </div>
    <!-- Move view sale order  class="font-weight-bold" modal trigger to main sale payment table -->
    <!-- View Sales Order Detail modal -->
    <div class="modal fade" id="salesOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">
                    <!--Header-->

                    <div class="modal-header">
                        <p class="heading lead">Information</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group ">
                            <div class="form-group">
                                <div class="pb-2 row ">
                                    <div class="text-center col-4">
                                        <h3 class="font-weight-bold">Amount Paid</h3>
                                        <h5>RM <span id="update-salespayment_amountPaid-detail">0.00</span></h5>
                                    </div>
                                    <div class="text-center col-4">
                                        <h3 class="font-weight-bold">Total Charge</h3>
                                        <h5>RM <span id="update-salespayment_totalCharge-detail">0.00</span></h5>
                                    </div>
                                    <div class="text-center col-4">
                                        <h3 class="font-weight-bold">Change</h3>
                                        <h5>RM <span id="update-salespayment_exchange-detail">0.00</span></h5>
                                    </div>
                                </div>
                            </div>
                            <hr>



                            <div class="row">
                                <div class="col-6">
                                    <h3>Sales Order Detail</h3>
                                    <table class="p-3 m-3">
                                        <tr>
                                            <td class="font-weight-bold">Sale Order ID</td>
                                            <td>: <span id="saleorderdetail-sale_id"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Customer Account</td>
                                            <td>: <span id="saleorderdetail-customer_account"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Customer Name</td>
                                            <td>: <span id="saleorderdetail-customer_name"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Salesperson</td>
                                            <td>: <span id="saleorderdetail-sale_salesperson"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Subtotal (RM)</td>
                                            <td>: <span id="saleorderdetail-sale_subtotal"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Discount (RM)</td>
                                            <td>: <span id="saleorderdetail-sale_discount_header"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Amount (RM)</td>
                                            <td>: <span id="saleorderdetail-sale_total_amount"></span></td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-6">
                                    <h3>Payment Information</h3>
                                    <table class="p-3 m-3">
                                        <tr>
                                            <td class="font-weight-bold">Payment Date</td>
                                            <td>: <span id="salepaymentdetail-sale_payment_date"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Payment Time</td>
                                            <td>: <span id="salepaymentdetail-sale_payment_time"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Payment Method</td>
                                            <td>: <span id="salepaymentdetail-payment_method"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Reference</td>
                                            <td>: <span id="salepaymentdetail-reference"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="grey white-text">
                                        <tr>
                                            <th class="text-center th-sm">Item No
                                            </th>
                                            <th class="text-center th-sm">Description
                                            </th>
                                            <th class="text-center th-sm">Qty
                                            </th>
                                            <th class="text-center th-sm">UOM
                                            </th>
                                            <th class="text-center th-sm">Selling Price(RM)
                                            </th>
                                            <th class="text-center th-sm">Discount(%)
                                            </th>
                                            <th class="text-center th-sm">Amount(RM)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="salesorderdetail-item-bucket">
                                    </tbody>
                                    <tfoot class="grey white-text">
                                        <tr>
                                            <th colspan="6" class="text-right"><strong>Discount : </strong></th>
                                            <th id="saleorderdetail-total_discount"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-right"><strong>Total Amount : </strong></th>
                                            <th id="saleorderdetail-total_cost"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="./dist/js/saleOrderPage.prod.js"></script>
<!-- <script src="./saleOrderPage.js"></script> -->