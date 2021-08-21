<div class="container my-4">


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

 
    <div class="modal fade" id="editSalesPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <input hidden="true" type="text" id="update-salespayment_id">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">

                    <div class="modal-header">
                        <p class="heading lead">Sales Payment Detail</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>
<!-- 
                    <div class="modal-footer justify-content-end">
                        <button id="editSalesPaymentSubmitBtn" class="btn btn-info">Update</button>

                    </div> -->
                </div>
                <div class="modal-body">

                    <div class="form-group">

                        <h3>Payment Information</h3>
                        <div class="row">
                            <div class="col-4">
                                <label for="update-salespayment-amount_apply">Payment Amount</label>
                                <input readonly type="number" value="0.00" min="0" step="0.01" class="form-control" id="update-salespayment-amount_apply" placeholder="">

                            </div>

                            <div class="col-4">
                                <label for="update-salespayment-payment_mode">Payment Mode</label>
                                <input readonly type="text" class="form-control" id="update-salespayment-payment_mode" placeholder="">
                            </div>
                            <div class="col-4">
                                <label for="update-salespayment-reference">Reference</label>
                                <input readonly class="form-control" type="text" id="update-salespayment-reference">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group ">

                        <h3>Sales Order Information</h3>

                        <div class="pb-4 row ">
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Amount Paid</h3>
                                <h5>RM <span id="update-salespayment_amountPaid">0.00</span></h5>
                            </div>
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Total Charge</h3>
                                <h5>RM <span id="update-salespayment_totalCharge">0.00</span></h5>
                            </div>
                            <div class="text-center col-4">
                                <h3 class="font-weight-bold">Change</h3>
                                <h5>RM <span id="update-salespayment_exchange">0.00</span></h5>
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
                                        <th id="update-salespayment-total_cost"></th>
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
            <form action="./backend/sale/printSalePayment.php" method="POST">
                <!--Header-->
                <input hidden type="text" name="postType" value="printSalePayment">
                <input hidden type="text" name="sale_payment_id" id="print_salepayment_id" value="" />
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

    <!-- Move view sale order detail modal trigger to main sale payment table -->
    <!-- View Sales Order Detail modal -->
    <div class="modal fade" id="viewSalesOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
            <div class="modal-content">
                <div class="p-0 m-0 bg-white sticky-top border-bottom">
                    <!--Header-->

                    <div class="modal-header">
                        <p class="heading lead">Invoice Details</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group ">
                            <h3>Item Information</h3>

                            <div class="overflow-auto">
                                <table class="p-3 m-3">
                                    <tr>
                                        <td class="font-weight-bold">Sale ID</td>
                                        <td>: <span id="salepaymentdetail-sale_id"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Customer Account</td>
                                        <td>: <span id="salepaymentdetail-customer_account"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Customer Name</td>
                                        <td>: <span id="salepaymentdetail-customer_name"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Salesperson</td>
                                        <td>: <span id="salepaymentdetail-sale_salesperson"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Subtotal (RM)</td>
                                        <td>: <span id="salepaymentdetail-sale_subtotal"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Discount (%)</td>
                                        <td>: <span id="salepaymentdetail-sale_discount_header"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Total Amount (RM)</td>
                                        <td>: <span id="salepaymentdetail-sale_total_amount"></span></td>
                                    </tr>

                                </table>
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
                                    <tbody id="salespaymentdetail-item-bucket">
                                    </tbody>
                                    <tfoot class="grey white-text">
                                        <tr>
                                            <th colspan="6" class="text-right"><strong>Discount : </strong></th>
                                            <th id="salepaymentdetail-total_discount"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-right"><strong>Total Amount : </strong></th>
                                            <th id="salepaymentdetail-total_cost"></th>
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
<script src="./dist/js/salePaymentPage.prod.js"></script>
<!-- <script src="./salePaymentPage.js"></script> -->