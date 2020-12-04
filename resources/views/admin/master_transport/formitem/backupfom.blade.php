  <form class="form-horizontal" id="add_item" method="post" action="{{url('transport_item_customer')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                        <br />
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Item Code</label>
                            <div class="controls">
                                <input class="input-larg validate[required]" readonly="enabled" type="text" maxlength="30" name="itemcode" value="{{ $jobs_order_idx }}" />
                                {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Customer</label>
                            <div class="controls">
                                <select class="dtcstmers input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="customerx" name="customerx">
                                </select>
                        </div>
                    </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Sub Service</label>
                            <div class="controls">
                                <select class="dtsubservices input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="sub_service_id" name="sub_service_id">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Shipment category</label>
                        <div class="controls">
                            <select class="dtshipmentctgry input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="shipmentx" name="shipmentx">
                        </select>
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Moda</label>
                        <div class="controls">
                            <select class="dtmoda input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="moda_x" name="moda_x">
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Origin</label>
                    <div class="controls">
                        <select class="citys input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="originx" name="originx">
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Destination</label>
                <div class="controls">
                        <select class="citys input-large m-wrap validate[required]" style="width:224px" tabindex="1" id="destination_x" name="destination_x">
                        </select>
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Item Description</label>
                            <div class="controls">
                                <textarea class="input-large validate[required]" type="text" maxlength="105" id="itemovdesc" name="itemovdesc"></textarea>
                                    {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                        </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Unit</label>
                                <div class="controls">
                                {{-- <input class="input-large validate[required]" type="text" maxlength="30" name="unit" /> --}}
                                <select class="input-small m-wrap units" data-trigger="hover" data-content="WOM" style="width:224px" data-original-title="Information" id="unit" name="unit">
                                        <option value="Rit">Rit</option>
                                        <option value="M³">M³</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Koli">Koli</option>
                                    </select>
                                    {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Price</label>
                            <div class="controls">
                            <input class="input-large validate[required]" type="text" maxlength="30" name="price" />
                                {{-- <span class="help-inline">Some hint here</span> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>