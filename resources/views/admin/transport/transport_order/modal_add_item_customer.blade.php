<div class="modal fade" id="add_item" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
aria-labelledby="add_item" aria-hidden="true" style="margin:-35px -340px;width:690px;height: 650px;display: none">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel1">Add Item Customers</h3>
</div>
@php
    $dx = isset($datax) ? 'true' : 'false';    
@endphp
{{-- {{ $dx }} --}}
        <div class="modal-body" style="max-height:560px;">
              <!-- BEGIN ACCORDION PORTLET-->
            <form class="form-horizontal" id="form_item_sub_services">
              <div class="span6">
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Pilih Metode</label>
                        <div class="controls">
                            <select class="metodeX input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="metode">
                                <option value="dflt">Metode default</option>
                                <option value="metode2">Metode minimal Qty</option>
                                <option value="metode3">Metode Rate Selanjutnya</option>
                        </select>
                    </div>
                </div>
                <div class="accordion" id="accordion1">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            {{--  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1">  --}}
                                <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse_1">
                                Metode add item customer (default)
                            </a>
                        </div>
                        {{--  <div id="collapse_1" class="accordion-body collapse in">  --}}
                            <div id="collapse_1" class="accordion-body collapse">
                            <div class="accordion-inner">
                                    <br />
                                    {{-- in progress updated vendor --}}
                                    <div class="control-group hidden">
                                        <label class="control-label" style="text-align: end"></label>
                                        <div class="controls">
                                            <input class="input-large validate[required]" readonly="enabled" type="hidden" maxlength="30" id="itemcode" name="itemcode" value="{{ $jobs_order_idx }}"/>
                                            {{-- <span class="help-inline">Some hint here</span> --}}
                                        </div>
                                    </div>
                                    @if ($dx == "true")
                                        <div class="control-group">
                                            <label class="control-label" style="text-align: end">Customer</label>
                                            <div class="controls">
                                                <select class="customerload input-large m-wrap" style="width:350px" tabindex="1" id="customerx_id" name="customerx_id">
                                                </select>
                                        </div>
                                    </div>
                                        @else
                                        <div class="control-group">
                                            <label class="control-label" style="text-align: end">Customer</label>
                                            <div class="controls">
                                                <input class="input-large validate[required]" readonly="enabled" type="text" style="width:345px" maxlength="30" id="customerx" name="customerx"/>
                                                <input class="input-large validate[required]" readonly="enabled" type="hidden" maxlength="30" id="customerx_id" name="customerx_id"/>
                                                {{-- <select class="dtcstmers input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="customerx" name="customerx">
                                                </select> --}}
                                        </div>
                                    </div> 
                                    @endif
                                    <div class="control-group">
                                        <label class="control-label" style="text-align: end">Sub Service</label>
                                        <div class="controls">
                                            <select class="dtsubservices input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="sub_service_id" name="sub_service_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" style="text-align: end">Shipment category</label>
                                    <div class="controls">
                                        <select class="dtshipmentctgry input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="shipmentx" name="shipmentx">
                                    </select>
                                </div>
                            </div>
                                <div class="control-group">
                                    <label class="control-label" style="text-align: end">Moda</label>
                                    <div class="controls">
                                        <select class="dtmoda input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="moda_x" name="moda_x">
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Origin</label>
                                <div class="controls">
                                    <select class="citys input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="originx" name="originx">
                                </select>
                            </div>
                            </div>
                            <div class="control-group">
                            <label class="control-label" style="text-align: end">Destination</label>
                            <div class="controls">
                                    <select class="citys input-large m-wrap validate[required]" style="width:350px" tabindex="1" id="destination_x" name="destination_x">
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Unit</label>
                                <div class="controls">
                                {{-- <input class="input-large validate[required]" type="text" maxlength="30" id="unit" name="unit" /> --}}
                                    {{-- <span class="help-inline">Some hint here</span> --}}
                                    <select class="input-small m-wrap units" data-trigger="hover" style="width:350px" data-content="WOM" data-original-title="Information" id="unit" name="unit">
                                        <option value="Rit">Rit</option>
                                        <option value="M³">M³</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Koli">Koli</option>
                                    </select>
                                </div>
                            </div>
                                <div id="tab2">
                                    <div class="control-group">
                                        <label class="control-label" style="text-align: end">Minimal Quantity</label>
                                        <div class="controls">
                                            <input class="input-large validate[required]" type="text" maxlength="30" id="minimalQty" style="width:350px" />
                                            {{-- <span class="help-inline">Some hint here</span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div id="tab3">
                                    <div class="control-group">
                                        <label class="control-label" style="text-align: end">Kg Pertama</label>
                                        <div class="controls">
                                            <input class="input-large validate[required]" type="text" maxlength="30" id="qtyFirst" style="width:350px" />
                                            {{-- <span class="help-inline">Some hint here</span> --}}
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" style="text-align: end">Rate pertama</label>
                                        <div class="controls">
                                            <input class="input-large" type="text" maxlength="30" id="rateFirsts" name="rateFirsts" style="width:350px" />
                                            {{-- <span class="help-inline">Some hint here</span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label id="ratex" class="control-label" style="text-align: end">Rate</label>
                                    <div class="controls">
                                    <input class="input-large validate[required]" type="text" maxlength="30" id="price" style="width:350px" name="price" />
                                        {{-- <span class="help-inline">Some hint here</span> --}}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Item Description</label>
                                    <div class="controls">
                                        <textarea class="input-large validate[required]" style="width:350px" type="text" id="itemovdesc" name="itemovdesc"></textarea>
                                            {{-- <span class="help-inline">Some hint here</span> --}}
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="modal-footer">
                <div style="text-align: left">
                    <span id="spinner_loading_processing" class=""></span>
                    <span id="Notes" class=""></span>&nbsp;
                    <span id="resend" class=""></span>&nbsp;
                    <span id="wait-loading"></span>
                </div>
                <div style="text-align: left">
                    <span id="MessageResponseRest" class=""></span>
                </div><br/>
                <div style="text-align: center">
                    <span id="x" class=""></span>
                </div>
        <div style="text-align: right">
            {{--  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>  --}}
            <button id="add_item_customer" class="btn btn-primary">Save</button>
        </div>
    </div>
    </div>
    </form>
</div>