"use strict";$(document).ready(function(){var e=s(),n=d(e);function a(t){var a;e=s(),n=d(e),a=0!=$("#currentPageNum").val()?$("#currentPageNum").val()>n?n:$("#currentPageNum").val():1,$("#currentPageNum").val(a),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"paymentHistory",customer_account:t,pageNum:a},success:function(t){"0 results"==t||"No Result"==t?(i("general"),l("general")):(r(t=t.includes("Success")?JSON.parse(t.replace("Success","")):JSON.parse(t),"general"),$(".printBtn").click(function(){var t=$(this).parent().parent().data("id");$("#print_id").val(t),$("#customer_name").val($(this).parent().parent().find(".customer_account").text())}),$(".deleteBtn").click(function(){var t=$(this).parent().parent().data("id"),a=$(this).parent().parent().data("payment-id");$("#delete_data").attr({"data-payment_identifier":t,"data-payment_id":a})}),$(".editBtn").click(function(){o($(this).parent().parent().find(".customer_account").text(),$(this).parent().parent().find(".customer_name").text(),$(this).parent().parent().data("id"),$(this).parent().parent().data("payment-id"),$(this).parent().parent().find(".payment_date").text(),$(this).parent().parent().find(".payment_mode").text(),$(this).parent().parent().find(".payment_salesperson").text(),$(this).parent().parent().find(".payment_remark").text(),$(this).parent().parent().find(".total_payment_amount").text())}))},error:function(t){_("Failed","Unexpected error occur : "+t)}})}function c(a){var t,e,n;""!=$("#search-customer_name").val()||""!=$("#search-customer_id").val()?(clearTimeout(t),$("#customer-search").empty().removeClass("bg-white").addClass("border").html('\n            <div class="d-flex justify-content-center bg-white border search-result-spinner">\n                <div class="spinner-border" role="status">\n                    <span class="sr-only">Loading...</span>\n                </div>\n            </div>\n            '),e=!0,t=setTimeout(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCustomer",searchCustomerName:$("#search-customer_name").val(),searchCustomerID:$("#search-customer_id").val(),pageNum:a},success:function(t){"No result"==t?1==e&&($("#customer-search").addClass("customer-search-nothing").empty().html('\n                                <div class="sticky-top bg-white">\n                                    <div class="row px-3 py-2">\n                                        <div class="col-6">\n                                            <h5>'.concat(t,'</h5>\n                                        </div>\n                                        <div class="col-6 text-right">\n                                            <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>\n                                        </div>\n                                    </div>\n                                </div> \n                                ')),e=!1):""==t?($("#customer-search").empty().removeClass("customer-search-nothing").removeClass("border").removeClass("bg-white"),e=!1):(n='\n                            <div class="sticky-top bg-white">\n                                <div class="row px-3 py-2">\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="customerSearchRowTotal"></span></p>\n                                    </div>\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <div class="d-flex flex-row justify-content-end">\n                                            <p class="my-auto">Page : </p>\n                                            <input type="number" id="customerSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="'.concat(a,'">\n                                            <p class="my-auto"> of <span id="customerSearchPageTotal"></span></p>\n                                        </div>\n                                    </div>\n                                </div>\n                                <hr class="p-0 m-0">\n                            </div>\n                            <div class="overflow-auto" style="max-height:200px;">\n                            '),$.each(JSON.parse(t),function(t,a){n+='\n                                <a class="customer-search-results">\n                                    <div class="view overlay">\n                                        <div class="row px-3 py-2">\n                                            <div class="col-6">\n                                                <h5 class="my-auto customerName">'.concat(a.name,'</h5>\n                                            </div>\n                                            <div class="col-6 text-right">\n                                                <p class="my-auto customerID">').concat(a.customer_account,'</p>\n                                            </div>\n                                            <div class="mask flex-center rgba-grey-slight"> </div>\n                                        </div>\n                                    </div>\n                                </a>\n                                <hr class="p-0 m-0">\n                                ')}),n+="</div>",$("#customer-search").removeClass("customer-search-nothing").empty().addClass("bg-white").html(n),e=!1,$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCountCustomer",searchCustomerName:$("#search-customer_name").val(),searchCustomerID:$("#search-customer_id").val()},success:function(t){var a,e;$("#customerSearchRowTotal").empty().html(t),a=t,e=Math.ceil(a/10),$("#customerSearchPageTotal").empty().text(e),$("#customerSearchCurrentPageNum").attr("max",e),$("#customerSearchCurrentPageNum").on("input",function(){""==$("#customerSearchCurrentPageNum").val()?console.log("empty customer search"):$("#customerSearchCurrentPageNum").val()<e?c($("#customerSearchCurrentPageNum").val()):c(e)})}}),$(".customer-search-results").click(function(){$("#search-customer_name").val($(this).find(".customerName").text()),$("#search-customer_id").val($(this).find(".customerID").text()),$("#customer-search").empty().removeClass("border"),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"viewInvoiceAll",customer_account:$(this).find(".customerID").text(),pageNum:1},success:function(t){var n,c=0;""!=t&&"No result"!=t&&($.each(JSON.parse(t),function(t,a){var e=0==a.outstanding?["text-success","paid","disabled='disabled'","checked"]:["text-danger","unpaid","",""];c+=parseFloat(a.outstanding),n+='\n                            <tr class="item-row" data-id="'.concat(a.id,'" data-invoice_id=').concat(a.invoice_id,'>\n                                <td>\n                                    <button class="btn btn-danger showInvoiceDetailBtn py-md-3 px-md-4 p-sm-3">\n                                        <i class="fas fa-trash-alt"></i>\n                                    </button>\n                                </td>\n                                <td class="doc_no-').concat(a.id,'">').concat(a.doc_no,'</td>\n                                <td class="doc_date-').concat(a.id,'">').concat(a.creation_date,'</td>\n                                <td class="invoice_num-').concat(a.id,'">').concat(a.invoice_num,'</td>\n                                <td class="invoice_date-').concat(a.id,'">').concat(a.invoice_date,'</td>\n                                <td class="due_date-').concat(a.id,'">').concat(a.due_date,'</td>\n                                <td class="total_amount-').concat(a.id,'">').concat(a.total_amount,'</td>\n                                <td class="outstanding-').concat(a.id,'">').concat(a.outstanding,'</td>\n                                <td class="payment-').concat(a.id,'">').concat(a.payment,'</td>\n                                <td class="status-').concat(a.id," ").concat(e[0],' text-capitalize font-weight-bold text-center">').concat(e[1],'</td>\n                                <td class="total_price-').concat(a.id,' pay_item text-center">\n                                    <input type="checkbox" class="select_to_pay" data-current-payment-made="0" data-previous-outstanding="').concat(a.outstanding,'" data-previous-payment="').concat(a.payment,'" aria-label="').concat(0==a.outstanding?"paid":"unpaid",'" ').concat(e[2]," ").concat(e[3],"/>\n                                </td>\n                            </tr>\n                            ")}),$("#total_outstanding").val(c.toFixed(2)),$("#payment-bucket").empty().html(n)),$(".showInvoiceDetailBtn").click(function(){$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"viewInvoiceDetail",selected_id:$(this).parent().parent().data("invoice_id")},success:function(t){var e,n,c;"No Result"==t?_("Failed","Could not find any invoice results"):(c=n=0,$.each(JSON.parse(t),function(t,a){n+=parseFloat(a.amount),c+=parseFloat(a.discount),e+="\n                                        <tr>\n                                            <td>".concat(a.item_no,"</td>\n                                            <td>").concat(a.description,"</td>\n                                            <td>").concat(a.quantity,"</td>\n                                            <td>").concat(a.uom,"</td>\n                                            <td>").concat(a.price,"</td>\n                                            <td>").concat(a.base_cost,"</td>\n                                            <td>").concat(a.discount,"</td>\n                                            <td>").concat(a.amount,"</td>\n                                        </tr>\n                                        ")}),$("#item-bucket").empty().html(e),$("#total_discount").empty().text(c.toFixed(2)),$("#total_cost").empty().text(n.toFixed(2)),$("#invoiceDetailModal").modal("show"))}})}),$(".select_to_pay").click(function(){var t=$(this).parent().parent().data("id");if(!(0<parseFloat($("#total_payment").val())))return _("Failed","Total Payment currently is 0. Please add some credit in total payment to pay"),!1;if(0<parseFloat($("#unapply_amount").val())){1==$(this).prop("checked")?(e=parseFloat($("#unapply_amount").val()),n=parseFloat($("#total_outstanding").val()),c=parseFloat($("#total_pay").val()),o=parseFloat($(".outstanding-".concat(t)).text()),s=parseFloat($(".payment-".concat(t)).text()),d=e<o?o-e:o-o,p=e<o?s+e:s+o,l=e<o?e-e:e-o,i=e<o?n-e:n-o,r=e<o?c+e:c+o,a=e<o?e:o,$(this).attr("data-current-payment-made",a)):(e=parseFloat($("#unapply_amount").val()),n=parseFloat($("#total_outstanding").val()),c=parseFloat($("#total_pay").val()),o=parseFloat($(".outstanding-".concat(t)).text()),s=parseFloat($(".payment-".concat(t)).text()),d=o+(a=parseFloat($(this).data("current-payment-made"))),p=s-a,l=e+a,i=n+a,r=c-a,$(this).attr("data-current-payment-made",0)),$(".outstanding-".concat(t)).empty().text(d.toFixed(2)),$(".payment-".concat(t)).empty().text(p.toFixed(2)),$("#total_pay").val(r.toFixed(2)),$("#unapply_amount").val(l.toFixed(2)),$("#total_outstanding").val(i.toFixed(2))}else{if(1==$(this).prop("checked"))return _("Failed","Unapply amount currently is 0. Please add some credit in total payment to pay"),!1;var a,e=parseFloat($("#unapply_amount").val()),n=parseFloat($("#total_outstanding").val()),c=parseFloat($("#total_pay").val()),o=parseFloat($(".outstanding-".concat(t)).text()),s=parseFloat($(".payment-".concat(t)).text()),d=o+(a=parseFloat($(this).data("current-payment-made"))),p=s-a,l=e+a,i=n+a,r=c-a;$(this).attr("data-current-payment-made",0),$(".outstanding-".concat(t)).empty().text(d.toFixed(2)),$(".payment-".concat(t)).empty().text(p.toFixed(2)),$("#total_pay").val(r.toFixed(2)),$("#unapply_amount").val(l.toFixed(2)),$("#total_outstanding").val(i.toFixed(2))}0<parseFloat($(".outstanding-".concat(t)).text())?$(".status-".concat(t)).removeClass("text-success").addClass("text-danger").empty().text("unpaid"):$(".status-".concat(t)).removeClass("text-danger").addClass("text-success").empty().text("paid"),0==parseFloat($("#total_pay").val())?$("#addPaymentSubmitBtn").prop("disabled",!0):$("#addPaymentSubmitBtn").prop("disabled",!1)}),$("#search-customer_id,#search-customer_name").on("keyup",function(){""==$("#search-customer_id").val()&&""==$("#search-customer_name").val()&&$("#payment-bucket").empty().html('                           \n                            <tr class="noResultText">\n                                <td colspan="11" class="text-center">\n                                    <h5>No payment available</h5>\n                                </td>\n                            </tr>')}),$("#total_payment").on("focusout",function(){var o;0<parseFloat($("#total_pay").val())&&(o=0,$("#total_pay").val("0.00"),$.each($(".item-row"),function(t,a){var e,n,c;"unpaid"===$(".select_to_pay:eq(".concat(t,")")).attr("aria-label")&&(e=$(".item-row:eq(".concat(t,")")).data("id"),n=parseFloat($(".select_to_pay:eq(".concat(t,")")).data("previous-payment")),c=parseFloat($(".select_to_pay:eq(".concat(t,")")).data("previous-outstanding")),o+=c,$(".outstanding-".concat(e)).empty().text(c.toFixed(2)),$(".payment-".concat(e)).empty().text(n.toFixed(2)),$(".status-".concat(e)).removeClass("text-success").addClass("text-danger").empty().text("unpaid"),$(".select_to_pay:eq(".concat(t,")")).prop("checked",!1))}),$("#total_outstanding").val(o.toFixed(2)))})},error:function(t){console.log(t)}})}))}})},1e3)):($("#customer-search").empty().removeClass("border"),e=!1)}function o(t,a,e,n,c,o,s,d,p){$("#update-search-customer_name").val(a),$("#update-search-customer_id").val(t),$("#update_identifier_id").val(e),$("#update_payment_id").val(n),$("#update-payment_date").val(c),$("#update-payment_remark").val(d),$("#update-payment_salesperson").val(s),$("#update-payment_mode").val(o),$("#update-total_pay").val(p).attr("data-original-payment-made",p),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"viewInvoiceAll",customer_account:t,pageNum:1},success:function(t){var n,c=0;""!=t&&($.each(JSON.parse(t),function(t,a){var e=0==a.outstanding?["text-success","paid","disabled='disabled'","checked"]:["text-danger","unpaid","",""];c+=parseFloat(a.outstanding),n+='\n                        <tr class="update-item-row" data-id="'.concat(a.id,'" data-invoice_id=').concat(a.invoice_id,'>\n                            <td>\n                                <button class="btn btn-danger showInvoiceDetailBtn py-md-3 px-md-4 p-sm-3">\n                                    <i class="fas fa-file-invoice"></i>\n                                </button>\n                            </td>\n                            <td class="update-doc_no-').concat(a.id,'">').concat(a.doc_no,'</td>\n                            <td class="update-doc_date-').concat(a.id,'">').concat(a.creation_date,'</td>\n                            <td class="update-invoice_num-').concat(a.id,'">').concat(a.invoice_num,'</td>\n                            <td class="update-invoice_date-').concat(a.id,'">').concat(a.invoice_date,'</td>\n                            <td class="update-due_date-').concat(a.id,'">').concat(a.due_date,'</td>\n                            <td class="update-total_amount-').concat(a.id,'">').concat(a.total_amount,'</td>\n                            <td class="update-outstanding-').concat(a.id,'">').concat(a.outstanding,'</td>\n                            <td class="update-payment-').concat(a.id,'"><input class="form-control" type="number" /></td>\n                            <td class="update-status-').concat(a.id," ").concat(e[0],' text-capitalize font-weight-bold text-center">').concat(e[1],'</td>\n                            <td class="update-total_price-').concat(a.id,' pay_item text-center">\n                                <input type="checkbox" class="update-select_to_pay" data-current-payment-made="0" data-previous-outstanding="').concat(a.outstanding,'" data-previous-payment="').concat(a.payment,'" aria-label="').concat(0==a.outstanding?"paid":"unpaid",'" ').concat(e[2]," ").concat(e[3],"/>\n                            </td>\n                        </tr>\n                        ")}),$("#update-total_outstanding").val(c.toFixed(2)),$("#update-payment-bucket").empty().html(n)),$(".showInvoiceDetailBtn").click(function(){$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"viewInvoiceHeader",selected_id:$(this).parent().parent().data("invoice_id")},success:function(t){"No Result"==t||$.each(JSON.parse(t),function(t,a){$("#detail-invoice_id").text(a.invoice_id),$("#detail-in_account").text(a.in_account),$("#detail-in_name").text(a.in_name),$("#detail-invoice_num").text(a.invoice_num),$("#detail-invoice_date").text(a.invoice_date),$("#detail-invoice_date").text(a.invoice_date),$("#detail-invoice_remark").text(a.invoice_remark),$("#detail-doc_no").text(a.doc_no),$("#detail-due_date").text(a.due_date),$("#detail-subtotal_ex").text(a.subtotal_ex),$("#detail-discount_header").text(a.discount_header),$("#detail-total_amount").text(a.total_amount)})}}),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"viewInvoiceDetail",selected_id:$(this).parent().parent().data("invoice_id")},success:function(t){var e,n,c;"No Result"==t?_("Failed","Could not find any invoice results"):(c=n=0,$.each(JSON.parse(t),function(t,a){n+=parseFloat(a.amount),c+=parseFloat(a.discount),e+="\n                                    <tr>\n                                        <td>".concat(a.item_no,"</td>\n                                        <td>").concat(a.description,"</td>\n                                        <td>").concat(a.quantity,"</td>\n                                        <td>").concat(a.uom,"</td>\n                                        <td>").concat(a.price,"</td>\n                                        <td>").concat(a.base_cost,"</td>\n                                        <td>").concat(a.discount,"</td>\n                                        <td>").concat(a.amount,"</td>\n                                    </tr>\n                                    ")}),$("#item-bucket").empty().html(e),$("#total_discount").empty().text(c.toFixed(2)),$("#total_cost").empty().text(n.toFixed(2)),$("#invoiceDetailModal").modal("show"))}})}),$(".update-select_to_pay").click(function(){var t=$(this).parent().parent().data("id");if(!(0<parseFloat($("#update-total_payment").val())))return _("Failed","Total Payment currently is 0. Please add some credit in total payment to pay"),!1;if(0<parseFloat($("#update-unapply_amount").val())){1==$(this).prop("checked")?(e=parseFloat($("#update-unapply_amount").val()),n=parseFloat($("#update-total_outstanding").val()),c=parseFloat($("#update-total_pay").val()),o=parseFloat($(".update-outstanding-".concat(t)).text()),s=parseFloat($(".update-payment-".concat(t)).text()),d=e<o?o-e:o-o,p=e<o?s+e:s+o,l=e<o?e-e:e-o,i=e<o?n-e:n-o,r=e<o?c+e:c+o,a=e<o?e:o,$(this).attr("data-current-payment-made",a)):(e=parseFloat($("#update-unapply_amount").val()),n=parseFloat($("#update-total_outstanding").val()),c=parseFloat($("#update-total_pay").val()),o=parseFloat($(".update-outstanding-".concat(t)).text()),s=parseFloat($(".update-payment-".concat(t)).text()),d=o+(a=parseFloat($(this).data("current-payment-made"))),p=s-a,l=e+a,i=n+a,r=c-a,$(this).attr("data-current-payment-made",0)),$(".update-outstanding-".concat(t)).empty().text(d.toFixed(2)),$(".update-payment-".concat(t)).empty().text(p.toFixed(2)),$("#update-total_pay").val(r.toFixed(2)),$("#update-unapply_amount").val(l.toFixed(2)),$("#update-total_outstanding").val(i.toFixed(2))}else{if(1==$(this).prop("checked"))return _("Failed","Unapply amount currently is 0. Please add some credit in total payment to pay"),!1;var a,e=parseFloat($("#update-unapply_amount").val()),n=parseFloat($("#update-total_outstanding").val()),c=parseFloat($("#update-total_pay").val()),o=parseFloat($(".update-outstanding-".concat(t)).text()),s=parseFloat($(".update-payment-".concat(t)).text()),d=o+(a=parseFloat($(this).data("current-payment-made"))),p=s-a,l=e+a,i=n+a,r=c-a;$(this).attr("data-current-payment-made",0),$(".update-outstanding-".concat(t)).empty().text(d.toFixed(2)),$(".update-payment-".concat(t)).empty().text(p.toFixed(2)),$("#update-total_pay").val(r.toFixed(2)),$("#update-unapply_amount").val(l.toFixed(2)),$("#update-total_outstanding").val(i.toFixed(2))}0<parseFloat($(".update-outstanding-".concat(t)).text())?$(".update-status-".concat(t)).removeClass("text-success").addClass("text-danger").empty().text("unpaid"):$(".update-status-".concat(t)).removeClass("text-danger").addClass("text-success").empty().text("paid"),0==parseFloat($("#update-total_pay").val())?$("#updatePaymentSubmitBtn").prop("disabled",!0):$("#updatePaymentSubmitBtn").prop("disabled",!1)}),$("#update-total_payment").on("focusout",function(){var o;0<parseFloat($("#update-total_pay").val())&&(o=0,$("#update-total_pay").val($("#update-total_pay").data("original-payment-made")),$.each($(".update-item-row"),function(t,a){var e,n,c;"unpaid"===$(".update-select_to_pay:eq(".concat(t,")")).attr("aria-label")&&(e=$(".update-item-row:eq(".concat(t,")")).data("id"),n=parseFloat($(".update-select_to_pay:eq(".concat(t,")")).data("previous-payment")),c=parseFloat($(".update-select_to_pay:eq(".concat(t,")")).data("previous-outstanding")),o+=c,$(".update-outstanding-".concat(e)).empty().text(c.toFixed(2)),$(".update-payment-".concat(e)).empty().text(n.toFixed(2)),$(".update-status-".concat(e)).removeClass("text-success").addClass("text-danger").empty().text("unpaid"),$(".update-select_to_pay:eq(".concat(t,")")).prop("checked",!1))}),$("#update-total_outstanding").val(o.toFixed(2)))})},error:function(t){console.log(t)}})}function s(){var a;return $.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"countRow"},async:!1,success:function(t){$("#rowTotal").empty().append(t),a=t}}),a}function d(t){var a=Math.ceil(+t);return $("#pageTotal").empty().text(a),$("#currentPageNum").val()>a&&$("#currentPageNum").val(a),a}function p(){var t;e=s(),n=d(e),t=0!=$("#currentPageNum").val()?$("#currentPageNum").val()>n?n:$("#currentPageNum").val():1,$("#currentPageNum").val(t),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"viewPaymentHeader",pageNum:t},success:function(t){"0 results"==t||"No Result"==t?(i("general"),l("general")):(r(t=t.includes("Success")?JSON.parse(t.replace("Success","")):JSON.parse(t),"general"),$(".printBtn").click(function(){var t=$(this).parent().parent().data("id");$("#print_id").val(t),$("#customer_name").val($(this).parent().parent().find(".customer_account").text())}),$(".deleteBtn").click(function(){var t=$(this).parent().parent().data("id"),a=$(this).parent().parent().data("payment-id");$("#delete_data").attr({"data-payment_identifier":t,"data-payment_id":a})}),$(".editBtn").click(function(){o($(this).parent().parent().find(".customer_account").text(),$(this).parent().parent().find(".customer_name").text(),$(this).parent().parent().data("id"),$(this).parent().parent().data("payment-id"),$(this).parent().parent().find(".payment_date").text(),$(this).parent().parent().find(".payment_mode").text(),$(this).parent().parent().find(".payment_salesperson").text(),$(this).parent().parent().find(".payment_remark").text(),$(this).parent().parent().find(".total_payment_amount").text())}))},error:function(t){_("Failed","Unexpected error occur : "+t)}})}function l(t){switch(t){case"general":$("#generalTable").DataTable({searching:!1,paginate:!1,lengthChange:!1,info:!1,scrollX:!0,scrollY:"1000px",scrollCollapse:!0}).columns.adjust();$(".dataTables_length").addClass("bs-select")}}function i(t){switch(t){case"general":$("#general-table").empty().append('<table id="generalTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" >  <thead class="grey lighten-2  ">  <tr>  <th scope="col">#</th>  <th scope="col" class="text-center th-lg">Action</th>  <th scope="col" class="th-lg">Payment Identifier</th>  <th scope="col" class="th-lg">Customer Account</th>  <th scope="col" class="th-lg">Customer Name</th>  <th scope="col" class="th-lg">Payment Date</th>  <th scope="col" class="th-lg">Payment Mode</th>  <th scope="col" class="th-lg">Payment Sales Person</th>  <th scope="col" class="th-lg">Payment Remark</th>  <th scope="col" class="th-lg">Total Payment Amount</th>  </tr>  </thead>  <tbody id="generalContent">  </tbody>  <tfoot class="grey lighten-2">  <tr>  <th scope="col">#</th>  <th scope="col" class="text-center th-lg">Action</th>  <th scope="col" class="th-lg">Payment Identifier</th>  <th scope="col" class="th-lg">Customer Account</th>  <th scope="col" class="th-lg">Customer Name</th>  <th scope="col" class="th-lg">Payment Date</th>  <th scope="col" class="th-lg">Payment Mode</th>  <th scope="col" class="th-lg">Payment Sales Person</th>  <th scope="col" class="th-lg">Payment Remark</th>  <th scope="col" class="th-lg">Total Payment Amount</th>  </tr>  </tfoot>  </table>')}}function r(t,a){switch(a){case"general":i("general"),$.each(t,function(t,a){$("#generalContent").append('\n                        <tr class="payment_row" data-payment-id="'.concat(a.payment_id,'" data-id="').concat(a.payment_identifier,'">\n                            <th>').concat(++t,'</th>\n                            <td>\n                                <button class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal">\n                                    <i class="fas fa-edit"></i>\n                                </button>\n                                <button class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal">\n                                    <i class="fas fa-trash-alt"></i>\n                                </button>\n                                <button class="btn btn-secondary printBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#printModal">\n                                    <i class="fas fa-print"></i>\n                                </button>\n                            </td>\n                            <td class="payment_identifier">').concat(a.payment_identifier,'</td>\n                            <td class="customer_account">').concat(a.customer_account,'</td>\n                            <td class="customer_name">').concat(a.customer_name,'</td>\n                            <td class="payment_date">').concat(a.payment_date,'</td>\n                            <td class="payment_mode">').concat(a.payment_mode,'</td>\n                            <td class="payment_salesperson">').concat(a.payment_salesperson,'</td>\n                            <td class="payment_remark">').concat(a.payment_remark,'</td>\n                            <td class="total_payment_amount">').concat(a.total_payment_amount,"</td>\n                        </tr>\n                    "))}),l("general")}}function _(t,a){$("#failedToModal").modal("show"),$("#failedModalHeadline").empty().append(t),$("#failedModalBody").empty().append(a)}function h(t,a){$("#successModalHeadline").empty().append(t),$("#successModalBody").empty().append(a),$("#successToModal").modal("show")}p(),$("#total_payment").on("keyup",function(){$("#unapply_amount").val($(this).val())}),$("#total_payment").on("focusout",function(){var t=$("#unapply_amount").val(),a=$(this).val();""==$(this).val()?($("#unapply_amount").val(0),$(this).val(0)):($("#unapply_amount").val(parseFloat(t).toFixed(2)),$(this).val(parseFloat(a).toFixed(2)))}),$("#update-total_payment").on("keyup",function(){$("#update-unapply_amount").val($(this).val())}),$("#update-total_payment").on("focusout",function(){var t=$("#update-unapply_amount").val(),a=$(this).val();""==$(this).val()?($("#update-unapply_amount").val(0),$(this).val(0)):($("#update-unapply_amount").val(parseFloat(t).toFixed(2)),$(this).val(parseFloat(a).toFixed(2)))}),$("#currentPageNum").focusout(function(){"none"==$("#current_customer_view_text").css("display")?(s(),p()):($.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"countRowSelectedCustomer",customer_account:$("#curent_customer_payment_history").data("customer-name")},async:!1,success:function(t){$("#rowTotal").empty().append(t),0}}),a($("#curent_customer_payment_history").data("customer-name")))}),$("#search-customer_name").on("keyup",function(){c(1)}),$("#search-customer_id").on("keyup",function(){c(1)}),$("#addModalBtn").click(function(){$("#search-customer_name").val(""),$("#search-customer_id").val(""),$("#customer-search").removeClass("border").empty(),$("#total_payment").val("0.00"),$("#payment_mode").val(""),$("#payment_date").val(""),$("#payment_salesperson").val(""),$("#payment_remark").val(""),$("#unapply_amount").val("0.00"),$("#total_outstanding").val("0.00"),$("#total_pay").val("0.00"),$("#payment-bucket").empty().html('\n        <tr class="noResultText">\n            <td colspan="11" class="text-center">\n                <h5>No payment available</h5>\n            </td>\n        </tr>\n        ')}),$(".editBtn").click(function(){$("#update-search-customer_name").val(""),$("#update-search-customer_id").val(""),$("#update-customer-search").removeClass("border").empty(),$("#update-total_payment").val("0.00"),$("#update-payment_mode").val(""),$("#update-payment_date").val(""),$("#update-payment_salesperson").val(""),$("#update-payment_remark").val(""),$("#update-unapply_amount").val("0.00"),$("#update-total_outstanding").val("0.00"),$("#update-total_pay").val("0.00"),$("#update-payment-bucket").empty().html('\n        <tr class="noResultText">\n            <td colspan="11" class="text-center">\n                <h5>No payment available</h5>\n            </td>\n        </tr>\n        ')}),$("#addPaymentSubmitBtn").click(function(){var n,c,o,s,d,p,t,a,e,l,i,r,u;n=[],c=[],o=[],s=[],d=[],p=[],u=r=i=l=e=a=t="",0<$("#payment-bucket").find(".noResultText").length?_("Failed","No invoice found"):($.each($(".item-row"),function(t,a){var e=$(".item-row:nth-child(".concat(t+1,")")).data("id");1==$(".select_to_pay:eq(".concat(t,")")).prop("checked")&&0<$(".select_to_pay:eq(".concat(t,")")).data("current-payment-made")&&(n.push(e),c.push($(".item-row:nth-child(".concat(t+1,")")).data("invoice_id")),o.push(parseFloat($(".total_amount-".concat(e)).text())),s.push(parseFloat($(".outstanding-".concat(e)).text())),d.push(parseFloat($(".payment-".concat(e)).text())),p.push($(".status-".concat(e)).text()))}),t=$("#payment_mode").val(),a=$("#payment_remark").val(),e=$("#payment_date").val(),l=$("#payment_salesperson").val(),i=$("#total_pay").val(),r=$("#search-customer_id").val(),u=$("#search-customer_name").val(),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"pay",id:n,invoice_id:c,total_amount:o,outstanding:s,payment:d,payment_status:p,payment_mode:t,payment_date:e,payment_remark:a,payment_salesperson:l,total_payment_amount:i,customer_account:r,customer_name:u},success:function(t){switch(t){case"success pay":$("#addModal").modal("hide"),h("Success","Payment is successfully added"),$(".btnSuccess").click(function(){location.reload()});break;case"Some input field is not set.":_("Failed",t)}}}))}),$("#updatePaymentSubmitBtn").click(function(){var n,c,o,s,d,p,t,a,e,l,i,r,u,m,y;n=[],c=[],o=[],s=[],d=[],p=[],y=m=u=r=i=l=e=a=t="",0<$("#update-payment-bucket").find(".noResultText").length?_("Failed","No invoice found"):($.each($(".update-item-row"),function(t,a){var e=$(".update-item-row:nth-child(".concat(t+1,")")).data("id");1==$(".update-select_to_pay:eq(".concat(t,")")).prop("checked")&&0<$(".update-select_to_pay:eq(".concat(t,")")).data("current-payment-made")&&(n.push(e),c.push($(".update-item-row:nth-child(".concat(t+1,")")).data("invoice_id")),o.push(parseFloat($(".update-total_amount-".concat(e)).text())),s.push(parseFloat($(".update-outstanding-".concat(e)).text())),d.push(parseFloat($(".update-payment-".concat(e)).text())),p.push($(".update-status-".concat(e)).text()))}),e=$("#update-payment_mode").val(),l=$("#update-payment_remark").val(),i=$("#update-payment_date").val(),r=$("#update-payment_salesperson").val(),a=$("#update_identifier_id").val(),t=$("#update_payment_id").val(),m=$("#update-search-customer_id").val(),y=$("#update-search-customer_name").val(),u=$("#update-total_pay").val(),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"updatePayment",id:n,invoice_id:c,payment_mode:e,total_amount:o,outstanding:s,payment:d,payment_identifier:a,payment_id:t,payment_status:p,payment_date:i,payment_remark:l,payment_salesperson:r,customer_account:m,customer_name:y,total_payment_amount:u},success:function(t){switch(console.log(t),t){case"success update payment":$("#editModal").modal("hide"),h("Success","Payment is successfully updated"),$(".btnSuccess").click(function(){location.reload()});break;case"Some input field is not set.":_("Failed",t)}}}))}),$("#deletePaymentSubmitBtn").click(function(){var t,a;t=$("#delete_data").data("payment_identifier"),a=$("#delete_data").data("payment_id"),$.ajax({type:"POST",url:"./backend/payment/payment.php",data:{postType:"deletePayment",payment_identifier:t,payment_id:a},success:function(t){switch(t){case"success delete payment":$("#deleteModal").modal("hide"),h("Success","Payment is successfully deleted"),$(".btnSuccess").click(function(){location.reload()});break;case"Some input field is not set.":_("Failed",t)}}})}),$(".customer_item").click(function(){var t=$(this).data("customer-name");""!=t&&("none"==t?(p(),$("#curent_customer_payment_history").text(""),$("#curent_customer_payment_history").attr("data-customer-name","none"),$("#current_customer_view_text").hide()):(a(t),$("#curent_customer_payment_history").text($(this).text()),$("#curent_customer_payment_history").attr("data-customer-name",t),$("#current_customer_view_text").show()))})});