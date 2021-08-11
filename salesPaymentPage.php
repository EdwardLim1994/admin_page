<div class="container my-4">

    <!-- Add Sales payment button -->
    <div class="row">
        <div class="text-right col-12">
            <button id="addSalesPaymentModalBtn" class="btn btn-danger py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addSalesPaymentModal">
                <span class="textBreak">Add Sales Payment</span>
                <span class="iconBreak"><i class="fas fa-file-invoice"></i></span>
            </button>
        </div>
    </div>
    <!-- Total row -->
    <!-- Pagination -->
    <div class="row">
        <div class="text-right col-12 d-flex flex-column justify-content-end ">
            <div class="pb-4 rowResults">
                <h6 class="my-auto">Total rows in database: <span class="font-weight-bold" id="salespayment-rowTotal"></span></h6>
            </div>
            <div class="mt-4 pageWrapper">
                <h5>Page : </h5>
                <input type="number" id="salespayment-currentPageNum" class="form-control pageNumInput" min="1" value="<?= isset($_SESSION['currPage']) ? $_SESSION['currPage'] : 1 ?>">
                <h5> of <span id="salespayment-pageTotal"></span></h5>
            </div>
        </div>
    </div>


    <!-- Table -->
    <div class="my-3 row">
        <div class="col-12">
            <div id="salespayment-table" class='table-responsive'></div>
        </div>
    </div>

    <!-- Add sales payment modal -->
    <div class="modal fade" id="addSalesPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">

                    <div class="modal-header">
                        <p class="heading lead">Add Sales Payment</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-end">
                        <button id="addSalesPaymentSubmitBtn" class="btn btn-info ">Add</button>

                    </div>
                </div>
                <div class="modal-body">

                    <div class="form-group">

                        <h3>Payment Information</h3>
                        <div class="row">
                            <div class="col-4">
                                <label for="salespayment-amount_apply">Payment Amount</label>
                                <input type="number" value="0.00" min="0" step="0.01" class="form-control" id="salespayment-amount_apply" placeholder="">

                            </div>

                            <div class="col-4">
                                <label for="salespayment-payment_mode">Payment Mode</label>
                                <select class="browser-default custom-select" name="customer_account" id="salespayment-payment_mode">
                                    <option value="cash" selected="selected">Cash</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="salespayment-reference">Reference</label>
                                <input class="form-control" type="text" id="salespayment-reference">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group ">

                        <h3>Sales Order Information</h3>

                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative">
                                    <label for="salespayment-search-salesorder">Sales Order ID or Customer Name:</label>
                                    <input type="text" class="form-control" id="salespayment-search-salesorder" placeholder="">

                                    <!-- Item search result -->
                                    <div id="salespayment-salesorder-search" class="m-0 bg-white w-100 position-absolute" style="z-index:5;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="pb-4 row ">
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
                        <div class="overflow-auto">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="grey white-text">
                                    <tr>
                                        <th class="text-center th-sm">Action</th>
                                        <th class="text-center th-sm">Sale ID
                                        </th>
                                        <th class="text-center th-sm">Customer Name
                                        </th>
                                        <th class="text-center th-sm">Sales Person
                                        </th>
                                        <th class="text-center th-sm">Sale Date
                                        </th>
                                        <th class="text-center th-sm">Subtotal(RM)
                                        </th>
                                        <th class="text-center th-sm">Discount(%)
                                        </th>
                                        <th class="text-center th-sm">Total Amount(RM)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="salespayment-salesorder-bucket">
                                    <tr class="salespayment-noResultText">
                                        <td colspan="9" class="text-center">
                                            <h5>No order added yet</h5>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="grey white-text">
                                    <tr>
                                        <th colspan="7" class="text-right"><strong>Total Amount : </strong></th>
                                        <th id="salespayment-total_cost"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update sales payment modal -->

    <div class="modal fade" id="editSalesPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <input hidden="true" type="text" id="update-salespayment_id">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">

                    <div class="modal-header">
                        <p class="heading lead">Update Sales Payment</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-end">
                        <button id="editSalesPaymentSubmitBtn" class="btn btn-info">Update</button>

                    </div>
                </div>
                <div class="modal-body">

                    <div class="form-group">

                        <h3>Payment Information</h3>
                        <div class="row">
                            <div class="col-4">
                                <label for="update-salespayment-amount_apply">Payment Amount</label>
                                <input type="number" value="0.00" min="0" step="0.01" class="form-control" id="update-salespayment-amount_apply" placeholder="">

                            </div>

                            <div class="col-4">
                                <label for="update-salespayment-payment_mode">Payment Mode</label>
                                <select class="browser-default custom-select" name="customer_account" id="update-salespayment-payment_mode">
                                    <option value="cash" selected="selected">Cash</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="update-salespayment-reference">Reference</label>
                                <input class="form-control" type="text" id="update-salespayment-reference">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group ">

                        <h3>Sales Order Information</h3>

                        <div class="pb-5 row ">
                            <div class="col-12">
                                <div class="position-relative">
                                    <label for="update-salesorder-search-salesorder">Sales Order ID or Customer Name:</label>
                                    <input type="text" class="form-control" id="update-salesorder-search-salesorder" placeholder="">

                                    <!-- Item search result -->
                                    <div id="update-salesorder-salesorder-search" class="m-0 bg-white w-100 position-absolute" style="z-index:5;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-auto">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="grey white-text">
                                    <tr>
                                        <th class="text-center th-sm">Action</th>
                                        <th class="text-center th-sm">Customer Account
                                        </th>
                                        <th class="text-center th-sm">Customer Name
                                        </th>
                                        <th class="text-center th-sm">Sales Person
                                        </th>
                                        <th class="text-center th-sm">Subtotal(RM)
                                        </th>
                                        <th class="text-center th-sm">Selling Price(RM)
                                        </th>
                                        <th class="text-center th-sm">Discount(%)
                                        </th>
                                        <th class="text-center th-sm">Total Amount(RM)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="update-salespayment-salesorder-bucket">
                                    <tr class="update-salespayment-noResultText">
                                        <td colspan="9" class="text-center">
                                            <h5>No order added yet</h5>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="grey white-text">
                                    <tr>
                                        <th colspan="7" class="text-right"><strong>Total Amount : </strong></th>
                                        <th id="update-salesorder-total_cost"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Sales payment modal -->
    <div class="modal fade" id="printSalesPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-notify modal-warning" role="document">
            <!--Content-->
            <form action="./backend/payment/printPayment.php" method="POST">
                <!--Header-->
                <input hidden type="text" name="postType" value="printPayment">
                <input hidden type="text" name="payment_identifier" id="print_id">
                <input hidden type="text" name="customer_account" id="customer_name">
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading">Print Sales Payment</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <p>Do you want to print current sales payment?</p>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <button type="submit" id="printPaymentSubmitButton" class="btn btn-warning">Yes</button>
                        <a type="button" id="printPaymentExitBtn" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Nevermind</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="./salePaymentPage.js"></script>