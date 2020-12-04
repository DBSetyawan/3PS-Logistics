{{-- start process --}}
<div class="modal fade" id="add_address_book" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
aria-labelledby="add_address_book" aria-hidden="true" style="margin:-10px -310px;height:489px;width:610px;display:none">
<div class="modal-header">
    <pre><h3 id="myModalLabel1">Add address book</h3></pre>
</div>
    <div class="modal-body" style="max-height: 410px;">
        <form class="form-horizontal" id="add_address_book">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                {!! csrf_field() !!}
                {{-- <br /> --}}
                <div class="row-fluid">
                        <div class="span6 hidden">
                        <div class="control-group hidden">
                            <label class="control-label hidden">Customer</label>
                                <div class="controls hidden">
                                    <select class="dtcstmers validate[required] hidden" tabindex="-1" name="customer" id="customer">
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="span6">
                            <div class="control-group" style="margin:35px;position:absolute">
                                <label class="control-label" style="margin:-5px -2px;font-family: 'Courier', monospace;font-size:16px;font: bold;"><strong style="margin-left:-41px">Address&nbsp;Destination</strong></label>
                                <div class="controls">
                                    <hr style="margin:10px;position:absolute;width:225%;left:136px">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label" style="font-family: 'Courier', monospace;font-size:16px;font: bold;"><strong>Address Book</strong></label>
                                    <div class="controls">
                                        <hr style="width:101%">
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="row-fluid">
                    <div class="row-fluid">
                            <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Name</label>
                                        <div class="controls controls-row">
                                            <input type="text" style="width:390px" class="input-block-level validate[required]" maxlength="500" placeholder="Enter place name" id="origin_names"  name="origin_names" required>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" >Destination name</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level validate[required]" placeholder="Enter place name" id="destination_names"  name="destination_names" required>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Origin City</label>
                                            <div class="controls">
                                                <select class="citys validate[required]" tabindex="-1" style="width:390px" name="origin_citys" id="origin_citys">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Destination City</label>
                                        <div class="controls">
                                            <select style="width:405px;" class="citys validate[required]" tabindex="-1" name="destination_citys" id="destination_citys">
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    <div class="row-fluid hidden">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" >Origin Details</label>
                                    <div class="controls controls-row">
                                        <input type="text" class="input-block-level validate[required]" style="width:390px" placeholder="Empty" id="origin_detil"  name="origin_detil" required>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="span6">
                                <div class="control-group">
                                    <label class="control-label" >Destination Details</label>
                                    <div class="controls controls-row">
                                        <input type="text" class="input-block-level validate[required]" placeholder="Empty" id="destination_detil"  name="destination_detil" required>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row-fluid hidden">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label" >Origin Contact</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level validate[required]" style="width:390px" placeholder="Enter Contact" id="origin_contacts"  name="origin_contacts" required>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label" >Destination Contact</label>
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level validate[required]" placeholder="Enter Contact" id="destination_contacts"  name="destination_contacts" required>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row-fluid" style="position: relative">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Origin Address</label>
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level validate[required]" style="width:390px" placeholder="Enter Address" id="origin_add_boo" maxlength="200" name="origin_add_boo" required>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Destination Address</label>
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level validate[required]" placeholder="Enter Address" id="destination_add_boo" maxlength="34" name="destination_add_boo" required>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Origin Phone</label>
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level input-phone-origin-address" style="width:390px" placeholder="Enter Phone" id="origin_fone"  name="origin_fone" required>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Destination Phone</label>
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level input-phone-destination-address" placeholder="Enter Phone" id="destination_fone"  name="destination_fone" required>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row-fluid" style="display: block">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >PIC NAME</label>
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level validate[required]" style="width:390px" placeholder="Enter ORIGIN PIC NAME" id="origin_pic"  name="origin_pic" required>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >PIC NAME</label>
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level validate[required]" placeholder="Enter DESTINATION PIC NAME" id="destination_pic"  name="destination_pic" required>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                    <div class="modal-footer">
                    <button type="submit" id="m_add_address_book" class="btn btn-primary">Save</button>
                    <a class="btn btn-warning" data-dismiss="modal">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>