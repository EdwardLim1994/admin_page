"use strict";$(document).ready(function(){_(countRow());var t,e,a,s,n=!1,c=!1,i=!1,l=!1;function o(e){var t,a;""!=$("#search-customer_name").val()||""!=$("#search-customer_id").val()?(clearTimeout(t),t=setTimeout(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCustomer",searchCustomerName:$("#search-customer_name").val(),searchCustomerID:$("#search-customer_id").val(),pageNum:e},success:function(t){"No result"==t?1==n&&($("#customer-search").empty().html('\n                                <div class="row">\n                                    <div class="col-6">\n                                        <h5>'.concat(t,'</h5>\n                                    </div>\n                                    <div class="col-6 text-right">\n                                        <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>\n                                    </div>\n                                </div>\n                                    \n                                ')),n=!1):""==t?($("#customer-search").empty().removeClass("border"),n=!1):(a='\n                            <div class="sticky-top bg-white">\n                                <div class="row px-3 py-2">\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="customerSearchRowTotal"></span></p>\n                                    </div>\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <div class="d-flex flex-row justify-content-end">\n                                            <p class="my-auto">Page : </p>\n                                            <input type="number" id="customerSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="'.concat(e,'">\n                                            <p class="my-auto"> of <span id="customerSearchPageTotal"></span></p>\n                                        </div>\n                                    </div>\n                                </div>\n                                <hr class="p-0 m-0">\n                            </div>\n                            <div class="overflow-auto" style="max-height:200px;">\n                            '),$.each(JSON.parse(t),function(t,e){a+='\n                                <a class="customer-search-results">\n                                    <div class="view overlay">\n                                        <div class="row px-3 py-2">\n                                            <div class="col-6">\n                                                <h5 class="my-auto customerName">'.concat(e.name,'</h5>\n                                            </div>\n                                            <div class="col-6 text-right">\n                                                <p class="my-auto customerID">').concat(e.customer_account,'</p>\n                                            </div>\n                                            <div class="mask flex-center rgba-grey-slight"> </div>\n                                        </div>\n                                    </div>\n                                </a>\n                                <hr class="p-0 m-0">\n                                ')}),a+="</div>",$("#customer-search").empty().html(a),n=!1,$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCountCustomer",searchCustomerName:$("#search-customer_name").val(),searchCustomerID:$("#search-customer_id").val()},success:function(t){var e,a;$("#customerSearchRowTotal").empty().html(t),e=t,a=Math.ceil(e/10),$("#customerSearchPageTotal").empty().text(a),$("#customerSearchCurrentPageNum").attr("max",a),$("#customerSearchCurrentPageNum").on("input",function(){""==$("#customerSearchCurrentPageNum").val()?console.log("empty customer search"):$("#customerSearchCurrentPageNum").val()<a?o($("#customerSearchCurrentPageNum").val()):o(a)})}}),$(".customer-search-results").click(function(){$("#search-customer_name").val($(this).find(".customerName").text()),$("#search-customer_id").val($(this).find(".customerID").text()),$("#customer-search").empty().removeClass("border")}),$("#itemSearchCurrentPageNum").focusout(function(){o(parseInt($(this).val()))}))}})},1e3)):($("#customer-search").empty().removeClass("border"),n=!1)}function r(e){var t,a;""!=$("#search-item").val()?(clearTimeout(t),t=setTimeout(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowItem",search:$("#search-item").val(),pageNum:e},success:function(t){"No result"==t?1==c&&($("#item-search").empty().html('\n                                <div class="row">\n                                    <div class="col-6">\n                                        <h5>'.concat(t,'</h5>\n                                    </div>\n                                    <div class="col-6 text-right">\n                                        <a class="btn btn-primary" href="./itemMaintenance.php">Go add new item</a>\n                                    </div>\n                                </div>\n                                ')),c=!1):""==t?($("#item-search").empty().removeClass("border"),c=!1):(a='\n                            <div class="sticky-top bg-white">\n                                <div class="row px-3 py-2 ">\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="itemSearchRowTotal"></span></p>\n                                    </div>\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <div class="d-flex flex-row justify-content-end">\n                                            <p class="my-auto">Page : </p>\n                                            <input type="number" id="itemSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="'.concat(e,'">\n                                            <p class="my-auto"> of <span id="itemSearchPageTotal"></span></p>\n                                        </div>\n                                    </div>\n                                </div>\n                                <hr class="p-0 m-0">\n                            </div>\n                            <div class="overflow-auto" style="max-height:200px;">\n                            '),$.each(JSON.parse(t),function(t,e){e.qty_available;a+='\n                                <a class="item-search-results" data-id="'.concat(e.item_id,'">\n                                    <div class="view overlay  ').concat(0==e.qty_available?"red lighten-4":"",'">\n                                        <div class="row px-3 py-2">\n                                            <div class="col-8 d-flex flex-row">\n                                                <h5 class="my-auto">').concat(e.description,'</h5>\n                                                <small class="my-auto px-2 text-muted">').concat(e.item_no,'</small>\n                                            </div>\n                                            <div class="col-4 d-flex flex-row justify-content-end">\n                                                <strong class="my-auto">Qty: </strong>\n                                                <p class="my-auto px-1 ').concat(0==e.qty_available?"text-danger":"",'">').concat(e.qty_available,'</p>\n                                            </div>\n                                            <div class="mask flex-center ').concat(0==e.qty_available?"rgba-red-strong":"rgba-grey-slight",'"></div>\n                                        </div>\n                                    </div>\n                                </a>\n                                <hr class="p-0 m-0">\n                                ')}),a+="</div>",$("#item-search").empty().html(a),c=!1,$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCountItem",search:$("#search-item").val()},success:function(t){var e,a;$("#itemSearchRowTotal").empty().html(t),e=t,a=Math.ceil(e/10),$("#itemSearchPageTotal").empty().text(a),$("#itemSearchCurrentPageNum").attr("max",a),$("#itemSearchCurrentPageNum").on("input",function(){""==$("#itemSearchCurrentPageNum").val()?console.log("empty item search"):$("#itemSearchCurrentPageNum").val()<a?r($("#itemSearchCurrentPageNum").val()):r(a)})}}),$(".item-search-results").click(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowItemAdd",itemID:$(this).data("id")},success:function(t){var s,n;$.each(JSON.parse(t),function(t,e){var a;n=e.item_id,e.item_id==$(".item-row").data("id")?(a=$("[data-id="+e.item_id+"]").find(".itemQuantity").val(),$("[data-id="+e.item_id+"]").find(".itemQuantity").val(parseInt(a)+1)):s+='\n                                <tr class="item-row" data-id="'.concat(e.item_id,'">\n                                    <td>\n                                        <button class="btn btn-danger deleteItemBtn py-md-3 px-md-4 p-sm-3">\n                                            <i class="fas fa-trash-alt"></i>\n                                        </button>\n                                    </td>\n                                    <td class="item_no">').concat(e.item_no,'</td>\n                                    <td class="description">').concat(e.description,'</td>\n                                    <td>\n                                        <input type="number" class="form-control itemQuantity" min="1" value="1">\n                                    </td>\n                                    <td>\n                                        <input type="text" class="form-control itemUnit" value="unit">\n                                    </td>\n                                    <td class="selling_price">').concat(e.selling_price1,'</td>\n                                    <td class="unit_cost">').concat(e.unit_cost,'</td>\n                                    <td>\n                                        <input type="number" class="form-control itemDiscount" value="0" min="0" max="100" step="1">\n                                    </td>\n                                    <td class="total_price"></td>\n                                </tr>\n                                ')}),0<$("#item-bucket").find(".noResultText").length&&$("#item-bucket").empty(),""!=s&&$("#item-bucket").append(s),$("#item-search").empty().removeClass("border"),$("#search-item").val(""),d(n),u(),m(),$(".itemQuantity").change(function(){$(this).val()>parseInt($(this).attr("max"))&&$(this).val($(this).attr("max")),$(this).val()<parseInt($(this).attr("min"))&&$(this).val($(this).attr("min")),d($(this).closest("tr").data("id")),u(),m()}),$(".itemDiscount").change(function(){$(this).val()>parseInt($(this).attr("max"))&&$(this).val($(this).attr("max")),$(this).val()<parseInt($(this).attr("min"))&&$(this).val($(this).attr("min")),d($(this).closest("tr").data("id")),u(),m()}),$(".deleteItemBtn").click(function(){$(this).closest("tr").remove(),0==$.trim($("#item-bucket").html()).length&&$("#item-bucket").html('\n                    <tr class="noResultText">\n                        <td colspan="9" class="text-center">\n                            <h5>No item added yet</h5>\n                        </td>\n                    </tr>\n                ')})}})}),$("#updateitemSearchCurrentPageNum").focusout(function(){updateCustomerSearchResults(parseInt($(this).val()))}))}})},1e3)):($("#item-search").empty().removeClass("border"),c=!1)}function d(t){var e=$("[data-id='"+t+"']").find(".itemQuantity").val(),a=$("[data-id='"+t+"']").find(".itemDiscount").val(),s=$("[data-id='"+t+"']").find(".selling_price").text();0<a&&(s-=s*(a/100)),$("[data-id='"+t+"']").find(".total_price").text((e*s).toFixed(2))}function m(){var s=0;$.each($(".item-row"),function(t,e){var a=$(".item-row:nth-child("+(t+1)+")").find(".total_price").text();s+=parseFloat(a)}),$("#total_cost").empty().html(s.toFixed(2))}function u(){var c=0;$.each($(".item-row"),function(t,e){var a=$(".item-row:nth-child("+(t+1)+")").find(".selling_price").text(),s=$(".item-row:nth-child("+(t+1)+")").find(".itemQuantity").val(),n=$(".item-row:nth-child("+(t+1)+")").find(".itemDiscount").val();0<n&&(c+=a*(n/100)*s)}),$("#total_discount").empty().html(c.toFixed(2))}function p(e){var a;""!=$("#update-search-customer_name").val()||""!=$("#update-search-customer_id").val()?setTimeout(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCustomer",searchCustomerName:$("#update-search-customer_name").val(),searchCustomerID:$("#update-search-customer_id").val(),pageNum:e},success:function(t){"No result"==t?1==i&&($("#update-customer-search").empty().html('\n                                <div class="row">\n                                    <div class="col-6">\n                                        <h5>'.concat(t,'</h5>\n                                    </div>\n                                    <div class="col-6 text-right">\n                                        <a class="btn btn-primary" href="./customerMaintenance.php">Go add new customer</a>\n                                    </div>\n                                </div>\n                                ')),i=!1):""==t?($("#update-customer-search").empty().removeClass("border"),i=!1):(a='\n                            <div class="sticky-top bg-white">\n                                <div class="row px-3 py-2">\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="updatecustomerSearchRowTotal"></span></p>\n                                    </div>\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <div class="d-flex flex-row justify-content-end">\n                                            <p class="my-auto">Page : </p>\n                                            <input type="number" id="updatecustomerSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="'.concat(e,'">\n                                            <p class="my-auto"> of <span id="updatecustomerSearchPageTotal"></span></p>\n                                        </div>\n                                    </div>\n                                </div>\n                                <hr class="p-0 m-0">\n                            </div>\n                            <div class="overflow-auto" style="max-height:200px;">\n                            '),$.each(JSON.parse(t),function(t,e){a+='\n                                <a class="update-customer-search-results">\n                                    <div class="view overlay">\n                                        <div class="row px-3 py-2">\n                                            <div class="col-6">\n                                                <h5 class="my-auto customerName">'.concat(e.name,'</h5>\n                                            </div>\n                                            <div class="col-6 text-right">\n                                                <p class="my-auto customerID">').concat(e.customer_account,'</p>\n                                            </div>\n                                            <div class="mask flex-center rgba-grey-slight"> </div>\n                                        </div>\n                                    </div>\n                                </a>\n                                <hr class="p-0 m-0">\n                                ')}),a+="</div>",$("#update-customer-search").empty().html(a),i=!1,$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCountCustomer",searchCustomerName:$("#update-search-customer_name").val(),searchCustomerID:$("#update-search-customer_id").val()},success:function(t){var e,a;$("#update-customerSearchRowTotal").empty().html(t),e=t,a=Math.ceil(e/10),$("#updatecustomerSearchPageTotal").empty().text(a),$("#updatecustomerSearchCurrentPageNum").attr("max",a),$("#updatecustomerSearchCurrentPageNum").on("input",function(){""==$("#updatecustomerSearchCurrentPageNum").val()?console.log("Empty update customer search"):$("#updatecustomerSearchCurrentPageNum").val()<a?p($("#updatecustomerSearchCurrentPageNum").val()):p(a)})}}),$(".update-customer-search-results").click(function(){$("#update-search-customer_name").val($(this).find(".customerName").text()),$("#update-search-customer_id").val($(this).find(".customerID").text()),$("#update-customer-search").empty().removeClass("border")}))}})},1e3):($("#update-customer-search").empty().removeClass("border"),i=!1)}function h(e){var t,a;""!=$("#update-search-item").val()?(clearTimeout(t),t=setTimeout(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowItem",search:$("#update-search-item").val(),pageNum:e},success:function(t){"No result"==t?1==l&&($("#update-item-search").empty().html('\n                                <div class="row">\n                                    <div class="col-6">\n                                        <h5>'.concat(t,'</h5>\n                                    </div>\n                                    <div class="col-6 text-right">\n                                        <a class="btn btn-primary" href="./itemMaintenance.php">Go add new item</a>\n                                    </div>\n                                </div>\n                                ')),l=!1):""==t?($("#update-item-search").empty().removeClass("border"),l=!1):(a='\n                            <div class="sticky-top bg-white">\n                                <div class="row px-3 py-2 ">\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <p class="my-auto">Search Result: <span class="font-weight-bold" id="updateitemSearchRowTotal"></span></p>\n                                    </div>\n                                    <div class=" col-6 py-2 py-md-0">\n                                        <div class="d-flex flex-row justify-content-end">\n                                            <p class="my-auto">Page : </p>\n                                            <input type="number" id="updateitemSearchCurrentPageNum" class="form-control w-25 mx-2 my-auto px-2 pageInput" min="1" value="'.concat(e,'">\n                                            <p class="my-auto"> of <span id="updateitemSearchPageTotal"></span></p>\n                                        </div>\n                                    </div>\n                                </div>\n                                <hr class="p-0 m-0">\n                            </div>\n                            <div class="overflow-auto" style="max-height:200px;">\n                            '),$.each(JSON.parse(t),function(t,e){a+='\n                                <a class="update-item-search-results" data-id="'.concat(e.item_id,'">\n                                    <div class="view overlay  ').concat(0==e.qty_available?"red lighten-4":"",'">\n                                        <div class="row px-3 py-2">\n                                            <div class="col-8 d-flex flex-row">\n                                                <h5 class="my-auto">').concat(e.description,'</h5>\n                                                <small class="my-auto px-2 text-muted">').concat(e.item_no,'</small>\n                                            </div>\n                                            <div class="col-4 d-flex flex-row justify-content-end">\n                                                <strong class="my-auto">Qty: </strong>\n                                                <p class="my-auto px-1 ').concat(0==e.qty_available?"text-danger":"",'">').concat(e.qty_available,'</p>\n                                            </div>\n                                            <div class="mask flex-center ').concat(0==e.qty_available?"rgba-red-strong":"rgba-grey-slight",'"></div>\n                                        </div>\n                                    </div>\n                                </a>\n                                <hr class="p-0 m-0">\n                                ')}),a+="</div>",$("#update-item-search").empty().html(a),l=!1,$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowCountItem",search:$("#update-search-item").val()},success:function(t){var e,a;$("#updateitemSearchRowTotal").empty().html(t),e=t,a=Math.ceil(e/10),$("#updateitemSearchPageTotal").empty().text(a),$("#updateitemSearchCurrentPageNum").attr("max",a),$("#updateitemSearchCurrentPageNum").on("input",function(){""==$("#updateitemSearchCurrentPageNum").val()?console.log("empty update item search"):$("#updateitemSearchCurrentPageNum").val()<a?h($("#updateitemSearchCurrentPageNum").val()):h(a)})}}),$(".update-item-search-results").click(function(){$.ajax({type:"POST",url:"./backend/invoice/viewCustmrItem.php",data:{postType:"searchRowItemAdd",itemID:$(this).data("id")},success:function(t){var s,n;$.each(JSON.parse(t),function(t,e){var a;n=e.item_id,e.item_id==$(".update-item-row").data("id")?(a=$("[data-id="+e.item_id+"]").find(".update-itemQuantity").val(),$("[data-id="+e.item_id+"]").find(".update-itemQuantity").val(parseInt(a)+1)):s+='\n                                <tr class="update-item-row" data-id="'.concat(e.item_id,'">\n                                    <td>\n                                        <button class="btn btn-danger update-deleteItemBtn py-md-3 px-md-4 p-sm-3">\n                                            <i class="fas fa-trash-alt"></i>\n                                        </button>\n                                    </td>\n                                    <td class="update-item_no">').concat(e.item_no,'</td>\n                                    <td class="update-description">').concat(e.description,'</td>\n                                    <td>\n                                        <input type="number" class="form-control update-itemQuantity" min="1"  value="1">\n                                    </td>\n                                    <td>\n                                        <input type="text" class="form-control update-itemUnit" value="unit">\n                                    </td>\n                                    <td class="update-selling_price">').concat(e.selling_price1,'</td>\n                                    <td class="update-unit_cost">').concat(e.unit_cost,'</td>\n                                    <td>\n                                        <input type="number" class="form-control update-itemDiscount" value="0" min="0" max="100" step="1">\n                                    </td>\n                                    <td class="update-total_price"></td>\n                                </tr>\n                                ')}),0<$("#update-item-bucket").find(".update-noResultText").length&&$("#update-item-bucket").empty(),""!=s&&$("#update-item-bucket").append(s),$("#update-item-search").empty().removeClass("border"),$("#update-search-item").val(""),v(n),g(),y(),$(".update-itemQuantity").change(function(){$(this).val()>parseInt($(this).attr("max"))&&$(this).val($(this).attr("max")),$(this).val()<parseInt($(this).attr("min"))&&$(this).val($(this).attr("min")),v($(this).closest("tr").data("id")),g(),y()}),$(".update-itemDiscount").change(function(){$(this).val()>parseInt($(this).attr("max"))&&$(this).val($(this).attr("max")),$(this).val()<parseInt($(this).attr("min"))&&$(this).val($(this).attr("min")),v($(this).closest("tr").data("id")),g(),y()}),$(".update-deleteItemBtn").click(function(){$(this).closest("tr").remove(),0==$.trim($("#update-item-bucket").html()).length&&$("#update-item-bucket").html('\n                    <tr class="update-noResultText">\n                        <td colspan="9" class="text-center">\n                            <h5>No item added yet</h5>\n                        </td>\n                    </tr>\n                ')})}})}))}})},1e3)):($("#update-item-search").empty().removeClass("border"),l=!1)}function v(t){var e=$("[data-id='"+t+"']").find(".update-itemQuantity").val(),a=$("[data-id='"+t+"']").find(".update-itemDiscount").val(),s=$("[data-id='"+t+"']").find(".update-selling_price").text();0<a&&(s-=s*(a/100)),$("[data-id='"+t+"']").find(".update-total_price").text((e*s).toFixed(2))}function y(){var s=0;$.each($(".update-item-row"),function(t,e){var a=$(".update-item-row:nth-child("+(t+1)+")").find(".update-total_price").text();s+=parseFloat(a)}),$("#update-total_cost").empty().html(s.toFixed(2))}function g(){var c=0;console.log("triggered"),$.each($(".update-item-row"),function(t,e){var a=$(".update-item-row:nth-child("+(t+1)+")").find(".update-selling_price").text(),s=$(".update-item-row:nth-child("+(t+1)+")").find(".update-itemQuantity").val(),n=$(".update-item-row:nth-child("+(t+1)+")").find(".update-itemDiscount").val();0<n&&(c+=a*(n/100)*s)}),$("#update-total_discount").empty().html(c.toFixed(2))}function f(t,e){$("#failedToModal").modal("show"),$("#failedModalHeadline").empty().append(t),$("#failedModalBody").empty().append(e)}function _(t){var e=Math.ceil(t/10);return $("#pageTotalSalesOrder").empty().text(e),$("#currentPageNumSalesOrder").val()>e&&$("#currentPageNumSalesOrder").val(e),e}function b(){var t;totalRow=countRow(),totalPage=paginate(totalRow),t=0!=$("#currentPageNum").val()?$("#currentPageNum").val()>totalPage?totalPage:$("#currentPageNum").val():1,$("#currentPageNum").val(t),$.ajax({type:"POST",url:"./backend/invoice/invoice.php",data:{postType:"viewHeader",pageNum:t},success:function(t){"0 results"==t||"No Result"==t?(S("salesorder"),x("salesorder"),S("salespayment"),x("salespayment")):(w(t=t.includes("Success")?JSON.parse(t.replace("Success","")):JSON.parse(t),"salesorder"),w(t,"salespayment"),$(".editBtn").click(function(){var t=$(this).attr("id").split("-"),o=0==parseFloat($("#payment-".concat(t[1])).text())?"":"readonly";$("#update-invoice_id").val(t[1]),$("#update-search-customer_name").val($("#in_name-"+t[1]).text()),$("#update-search-customer_id").val($("#in_account-"+t[1]).text()),$("#update-invoice_number").val($("#invoice_num-"+t[1]).text()),$("#update-doc_no").val($("#doc_no-"+t[1]).text()),$("#update-invoice_date").val($("#invoice_date-"+t[1]).text()),$("#update-due_date").val($("#due_date-"+t[1]).text()),$("#update-invoice_remark").val($("#invoice_remark-"+t[1]).text()),$.ajax({type:"POST",url:"./backend/invoice/invoice.php",data:{postType:"viewDetail",invoice_id:t[1]},success:function(t){var c,i=0,l=0;$.each(JSON.parse(t),function(t,e){var a=(0==e.discount?100:e.discount)/100,s=1==a?0:e.price*a,n=(e.price-s)*e.quantity;i+=n,l+=s,c+='\n                                    <tr class="update-item-row" data-id="'.concat(e.item_id,'">\n                                        <td>\n                                            <button class="btn btn-danger update-deleteItemBtn py-md-3 px-md-4 p-sm-3">\n                                                <i class="fas fa-trash-alt"></i>\n                                            </button>\n                                        </td>\n                                        <td class="update-item_no">').concat(e.item_no,'</td>\n                                        <td class="update-description">').concat(e.description,'</td>\n                                        <td>\n                                            <input type="number" ').concat(o,' class="form-control update-itemQuantity" min="1" value="').concat(e.quantity,'">\n                                        </td>\n                                        <td>\n                                            <input type="text" ').concat(o,' class="form-control update-itemUnit" placeholder="unit" val="').concat(e.uom,'">\n                                        </td>\n                                        <td class="update-selling_price">').concat(e.price,'</td>\n                                        <td class="update-unit_cost">').concat(e.base_cost,'</td>\n                                        <td>\n                                            <input type="number" ').concat(o,' class="form-control update-itemDiscount" value="').concat(e.discount,'" min="0" max="100" step="1">\n                                        </td>\n                                        <td class="update-total_price">').concat(n.toFixed(2),"</td>\n                                    </tr>\n                                    ")}),$("#update-item-bucket").empty().append(c),$("#update-total_discount").empty().text(l.toFixed(2)),$("#update-total_cost").empty().text(i.toFixed(2)),$(".update-deleteItemBtn").click(function(){$(this).closest("tr").remove(),0==$.trim($("#update-item-bucket").html()).length&&$("#update-item-bucket").html('\n                                            <tr class="update-noResultText">\n                                                <td colspan="7" class="text-center">\n                                                    <h5>No item added yet</h5>\n                                                </td>\n                                            </tr>\n                                        ')}),$(".update-itemQuantity").change(function(){$(this).val()>parseInt($(this).attr("max"))&&$(this).val($(this).attr("max")),$(this).val()<parseInt($(this).attr("min"))&&$(this).val($(this).attr("min")),v($(this).closest("tr").data("id")),g(),y()}),$(".update-itemDiscount").change(function(){$(this).val()>parseInt($(this).attr("max"))&&$(this).val($(this).attr("max")),$(this).val()<parseInt($(this).attr("min"))&&$(this).val($(this).attr("min")),v($(this).closest("tr").data("id")),g(),y()})}})}),$(".deleteBtn").click(function(){var t=$(this).attr("id").split("-");$("#delete_id").val(t[1]),$("#deleteInvoiceName").empty().text(t[1])}),$(".printBtn").click(function(){var t=$(this).attr("id").split("-");$("#print_id").val(t[1]),$("#printInvoiceName").empty().text(t[1])}))},error:function(t){f("Failed","Unexpected error occur : "+t)}})}function x(t){switch(t){case"salesorder":$("#salesorderTable").DataTable({searching:!1,paginate:!1,lengthChange:!1,info:!1,scrollX:!0,scrollY:"1000px",scrollCollapse:!0}).columns.adjust();$(".dataTables_length").addClass("bs-select");break;case"salespayment":$("#salespaymentTable").DataTable({searching:!1,paginate:!1,lengthChange:!1,info:!1,scrollX:!0,scrollY:"1000px",scrollCollapse:!0}).columns.adjust();$(".dataTables_length").addClass("bs-select")}}function S(t){switch(t){case"salesorder":$("#salesorder-table").empty().append('<table id="salesorderTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" >  <thead class="grey lighten-2  ">  <tr>  <th scope="col">#</th>  <th scope="col" class="text-center th-lg">Action</th>  <th scope="col" class="th-lg">Sale Order ID</th>  <th scope="col" class="th-lg">Customer ID</th>  <th scope="col" class="th-lg">Customer Name</th>  <th scope="col" class="th-lg">Sale Date</th>  <th scope="col" class="th-lg">Sale Phone Number</th>  <th scope="col" class="th-lg">Sale Subtotal</th>  <th scope="col" class="th-lg">Sale Discount Header</th>  <th scope="col" class="th-lg">Sale Total Amount</th>  <th scope="col" class="th-lg">Payment Status</th>  </tr>  </thead>  <tbody id="salesorderContent">  </tbody>  <tfoot class="grey lighten-2">  <tr>  <th scope="col">#</th>  <th scope="col" class="text-center th-lg">Action</th>  <th scope="col" class="th-lg">Sale Order ID</th>  <th scope="col" class="th-lg">Customer ID</th>  <th scope="col" class="th-lg">Customer Name</th>  <th scope="col" class="th-lg">Sale Date</th>  <th scope="col" class="th-lg">Sale Phone Number</th>  <th scope="col" class="th-lg">Sale Subtotal</th>  <th scope="col" class="th-lg">Sale Discount Header</th>  <th scope="col" class="th-lg">Sale Total Amount</th>  <th scope="col" class="th-lg">Payment Status</th>  </tr>  </tfoot>  </table>');break;case"salespayment":$("#salespayment-table").empty().append('<table id="salespaymentTable" class="table table-hover table-bordered table_fullwidth text-center" cellspacing="0" >  <thead class="grey lighten-2  ">  <tr>  <th scope="col">#</th>  <th scope="col" class="text-center th-lg">Action</th>  <th scope="col" class="th-lg">Sale Payment ID</th>  <th scope="col" class="th-lg">Sale Order ID</th>  <th scope="col" class="th-lg">Sale Payment Date</th>  <th scope="col" class="th-lg">Sale Payment Time</th>  <th scope="col" class="th-lg">Payment Method</th>  <th scope="col" class="th-lg">Customer Name</th>  <th scope="col" class="th-lg">Sale Amount</th>  <th scope="col" class="th-lg">Sale Payment</th>  <th scope="col" class="th-lg">Reference</th>  </tr>  </thead>  <tbody id="salespaymentContent">  </tbody>  <tfoot class="grey lighten-2">  <tr>  <th scope="col">#</th>  <th scope="col" class="text-center th-lg">Action</th>  <th scope="col" class="th-lg">Sale Payment ID</th>  <th scope="col" class="th-lg">Sale Order ID</th>  <th scope="col" class="th-lg">Sale Payment Date</th>  <th scope="col" class="th-lg">Sale Payment Time</th>  <th scope="col" class="th-lg">Payment Method</th>  <th scope="col" class="th-lg">Customer Name</th>  <th scope="col" class="th-lg">Sale Amount</th>  <th scope="col" class="th-lg">Sale Payment</th>  <th scope="col" class="th-lg">Reference</th>  </tr>  </tfoot>  </table>')}}function w(t,e){switch(e){case"salesorder":S("salesorder"),$.each(t,function(t,e){t++,$("#salesorderContent").append('<tr> <th scope="row">'+t+'</th> <td> <button id="edit-'+e.sale_id+'" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editPaymentModal"> <i class="fas fa-edit"></i> </button> <button id="delete-'+e.sale_id+'" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deletePaymentModal"> <i class="fas fa-trash-alt"></i> </button> </td> <td id=\'sale_id-'+e.sale_id+"'>"+e.sale_id+"</td> <td id='customer_account-"+e.sale_id+"'>"+e.customer_account+"</td> <td id='customer_name-"+e.sale_id+"'>"+e.customer_name+"</td> <td id='total_amount-"+e.sale_id+"'>"+e.total_amount+"</td> <td id='sale_date-"+e.sale_id+"'>"+e.sale_date+"</td> <td id='sale_phone_num-"+e.sale_id+"'>"+e.sale_phone_num+"</td> <td id='sale_salesperson-"+e.sale_id+"'>"+e.sale_salesperson+"</td> <td id='sale_subtotal-"+e.sale_id+"'>"+e.sale_subtotal+"</td> <td id='sale_discount_header-"+e.sale_id+"'>"+e.sale_discount_header+"</td> <td id='sale_total_amount-"+e.sale_id+"'>"+e.sale_total_amount+"</td> <td id='payment_status-"+e.sale_id+"'>"+e.payment_status+"</td></tr>")}),x("salesorder");break;case"salespayment":S("salespayment"),$.each(t,function(t,e){t++,$("#salespaymentContent").append('<tr> <th scope="row">'+t+'</th> <td> <button id="edit-'+e.sale_payment_id+'" class="btn btn-warning editBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#editModal"> <i class="fas fa-edit"></i> </button> <button id="delete-'+e.sale_payment_id+'" class="btn btn-danger deleteBtn py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#deleteModal"> <i class="fas fa-trash-alt"></i> </button> </td> <td id=\'sale_payment_id-'+e.sale_payment_id+"'>"+e.isale_payment_id+"</td> <td id='sale_id_header-"+e.invoice_id+"'>"+e.sale_id_header+"</td> <td id='sale_payment_date-"+e.invoice_id+"'>"+e.sale_payment_date+"</td> <td id='sale_payment_time-"+e.invoice_id+"'>"+e.sale_payment_time+"</td> <td id='payment_method-"+e.invoice_id+"'>"+e.payment_method+"</td> <td id='customer_name-"+e.invoice_id+"'>"+e.customer_name+"</td> <td id='sale_amount-"+e.invoice_id+"'>"+e.sale_amount+"</td> <td id='sale_payment-"+e.invoice_id+"'>"+e.sale_payment+"</td> <td id='reference-"+e.invoice_id+"'>"+e.reference+"</td></tr>")}),x("salespayment")}}generateTableSalesOrder(),generateTableSalesPayment(),$("#currentPageNum").focusout(function(){(""!=$("#searchRow").val()?searchTable:b)()}),$("#search-customer_name, #search-customer_id").on("keyup",function(){clearTimeout(t),n||($("#customer-search").empty().addClass("border").html('\n            <div class="d-flex justify-content-center">\n                <div class="spinner-border" role="status">\n                    <span class="sr-only">Loading...</span>\n                </div>\n            </div>\n            '),n=!0),$(this).val()?t=setTimeout(function(){o(1)},1e3):($("#customer-search").empty().removeClass("border"),n=!1)}),$("#search-item").on("keyup",function(){clearTimeout(e),c||($("#item-search").empty().addClass("border").html('\n            <div class="d-flex justify-content-center">\n                <div class="spinner-border" role="status">\n                    <span class="sr-only">Loading...</span>\n                </div>\n            </div>\n            '),c=!0),$(this).val()?e=setTimeout(function(){r(1)},1e3):($("#item-search").empty().removeClass("border"),n=!1)}),$("#update-search-customer_name, #update-search-customer_id").on("keyup",function(){clearTimeout(a),i||($("#update-customer-search").empty().addClass("border").html('\n            <div class="d-flex justify-content-center">\n                <div class="spinner-border" role="status">\n                    <span class="sr-only">Loading...</span>\n                </div>\n            </div>\n            '),i=!0),$(this).val()?a=setTimeout(function(){p(1)},1e3):($("#update-customer-search").empty().removeClass("border"),isSpinnerOn=!1)}),$("#update-search-item").on("keyup",function(){clearTimeout(s),l||($("#update-item-search").empty().addClass("border").html('\n            <div class="d-flex justify-content-center">\n                <div class="spinner-border" role="status">\n                    <span class="sr-only">Loading...</span>\n                </div>\n            </div>\n            '),l=!0),$(this).val()?s=setTimeout(function(){h(1)},1e3):($("#item-search").empty().removeClass("border"),l=!1)}),$("#addModalBtn").click(function(){$("#search-customer_name").val(""),$("#search-customer_id").val(""),$("#invoice_number").val(""),$("#doc_no").val(""),$("#invoice_date").val(""),$("#due_date").val(""),$("#invoice_remark").val(""),$("#search-item").val(""),$("#customer-search").removeClass("border").empty(),$("#item-search").removeClass("border").empty(),$("#item-bucket").empty().html('\n            <tr class="noResultText">\n                <td colspan="9" class="text-center">\n                    <h5>No item added yet</h5>\n                </td>\n            </tr>\n        ')}),$("#addInvoiceSubmitBtn").click(function(){addInvoice()}),$("#updateInvoiceSubmitBtn").click(function(){updateInvoice()}),$("#deleteInvoiceSubmitButton").click(function(){deleteInvoice()})});