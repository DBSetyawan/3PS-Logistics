<body onload="LoaderLoading()">
    <div class="modal fade" id="add_customer" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="Add Customer" aria-hidden="true" aria-hidden="true" 
        style="margin:-25px -625px;width:1260px;height:698px;overflow: auto;pointer-events:none;display: none">
            <div class="modal-header">
                <pre><h3 id="LabelCustomer">Add Customer</h3></pre>
            </div>
            <div id="loader"></div>
            <div style="display:none;" id="myDiv" class="animate-bottom">
            <div class="modal-body" style="pointer-events: all;max-height:586px;">
                {{-- <div style="max-height:650px"> --}}
                <form class="form-horizontal" id="form_add_customer">
                    <br />
                    {{-- in progress updated vendor --}}
                    <input type="hidden" name="statusid" value="1" class="span12" />
                    {{-- <input type="hidden" name="customerid" value="{{ $id_customers }}" class="span12 " />
                    <input type="hidden" name="customeridx" value="{{ $id_customersx }}" class="span12 " />
                    <input type="hidden" name="customer_id" value="{{$customers}}" class="span12 " /> --}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" class="span12 " />
                    
                  <div class="row-fluid">
                      <div class="span12">
                          <div class="control-group">
                              <label class="control-label"><strong>Informasi Customer</strong></label>
                              <div class="controls">
                                  {{--  <input type="text" class="span12 " />  --}}
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row-fluid">
                    <div class="span12">
                        <hr>
                    </div>
                </div>   
                {{-- <div class="row-fluid">
                    <div class="controls">
                        
                    </div>
                </div> --}}
                        @if ($api_v1 == "true")
                                <div class="row-fluid">
                                    <div class="span6">
                                    <div class="control-group">
                                    <label class="control-label">Code Customer</label>
                                        <div class="controls">
                                        {{-- <input readonly="enabled" type="text" maxlength="35" id="code_project"  name="code_project" value="{{ $data['content'] }}" class="span12 " /> <span style="margin:-23px 412px" class="span12"><i class="fa fa-circle text-success"></i> {{ __("Connected with izzy transport")  }}</span> --}}
                                        <input readonly="enabled" type="text" maxlength="35" style="width:385px;" id="code_project"  name="code_project" value="{{ $data['content'] }}" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                    <div class="span12">
                                        <hr>
                                    </div>
                                </div>   
                                @else
                            {{-- <input readonly="enabled" type="text" placeholder="Maaf tidak tersambung API izzy" class="span12 " /> --}}
                        @endif
                      <div class="row-fluid">
                          <div class="span6">
                              <div class="control-group">
                                  <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Nama Customer</label>
                                  <div class="controls">
                                      <input autofocus type="text" id="project_name" name="project_name" style="width:385px;" value="{{ old('project_name') }}"/>
                                      <div style="position: absolute;margin:-30px 400px" class="Customer"></div>
                                      {{-- @if ($errors->has('project_name')) --}}
                                        {{-- <div class="Customer label-danger"></div> --}}

                                    {{-- @endif --}}
                                  </div>
                              </div>
                          </div>
                          <div class="span6">
                              <div class="control-group">
                                <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Tahun Berdiri</label>
                                  <div class="controls">
                                    <div style="position: absolute;margin:-33px 4px" class="StartEnd"></div>

                                      <input type="text" name="since" id="since" value="{{ old('since') }}" style="width:375px;" />
                                      <div style="position: absolute;margin:-33px 392px" class="Sinces"></div>
                                  </div>
                              </div>
                          </div>
                    </div>
                      <div class="row-fluid">
                              <div class="span6">
                                      <div class="control-group">
                                          <label class="control-label">Direktur</label>
                                          <div class="controls">
                                              <input type="text" id="director" name="director" value="{{ old('director') }}" style="width:385px;" />
                                          </div>
                                      </div>
                                  </div>
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label">Jenis Usaha</label>
                                      <div class="controls">
                                        <select class="type_of_business form-control" maxlength="20" style="width:385px;" value="{{ old('type_of_business') }}" id="type_of_business" name="type_of_business"></select>
                                        <div style="position: absolute;margin:-30px 400px" class="tipe_bisnisss"></div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row-fluid">
                              <div class="span12">
                                  <hr>
                              </div>
                          </div>
                          <div class="row-fluid">
                              <div class="span12">
                                      <label class="control-label"><strong>Informasi NPWP</strong></label>
                                      <div class="controls">
                                      </div>
                              </div>
                          </div>
                          {{-- <div class="row-fluid">
                                <div class="controls">
                                    <div class="npwp"></div>
                                </div>
                            </div> --}}
                          <div class="row-fluid">
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;No. NPWP</label>
                                      <div class="controls">
                                        {{-- <div class="npwp"></div> --}}
                                        <div style="position: absolute;margin:-33px 4px" class="inputNpwp"></div>

                                          <input type="text" class="npwps" maxlength="20" name="tax_no" id="tax_no" style="width:385px;" />
                                          <div style="position: absolute;margin:-30px 400px" class="npwp"></div>
                                          {{-- <input type="text" maxlength="15" name="tax_no" id="tax_no" style="width:398px;" class="span12" /> --}}
                                      </div>
                                  </div>
                              </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Provinsi</label>
                                    <div class="controls">
                                        <select class="provins" id="provincenpwp" style="width:385px;" name="province" data-placeholder="Choose a Province" tabindex="1">
                                        </select>
                                    </div>
                                </div>
                            </div>
                          </div>
                              <div class="row-fluid">
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Alamat</label>
                                      <div class="controls">
                                          <input type="text" maxlength="200" name="tax_address" style="width:385px;" id="tax_address" value="{{ old('tax_address') }}" />
                                            <div style="position: absolute;margin:-30px 400px" class="tax_alamatss"></div>
                                      </div>
                                  </div>
                              </div>
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Kota</label>
                                      <div class="controls">
                                          <select class="kotaNPWP" style="width:385px;" value="{{old('tax_city')}}" id="tax_city" name="tax_city" data-placeholder="Choose a City" tabindex="1">
                                          </select>
                                            <div style="position: absolute;margin:-30px 400px" class="tax_citys"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row-fluid">
                                  <div class="span6">
                                      <div class="control-group">
                                          <label class="control-label">No Telepon</label>
                                          <div class="controls" >
                                              <input type="text" style="width:385px;" class="input-phone-origin-address-customer" id="tax_phone" name="tax_phone" value="{{ old('tax_phone') }}" />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="span6">
                                      <div class="control-group">
                                          <label class="control-label">Fax</label>
                                          <div class="controls">
                                              <input type="text" id="tax_fax" name="tax_fax" value="{{ old('tax_fax') }}" class="span12 input-phone-origin-address-customer-x" />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row-fluid">
                                  <div class="span6">
                                      <div class="control-group">
                                          <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Tipe Pajak</label>
                                          <div class="controls">
                                              <select class="CustomerTaxTypes" id="CustomerTaxType" style="width:398px;" name="CustomerTaxType">
                                            </select>
                                            <div style="position: absolute;margin:-30px 400px" class="CustomertaxTypess"></div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row-fluid">
                                  <div class="span12">
                                      <hr>
                                  </div>
                              </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <label class="control-label"><strong>Informasi Penagihan</strong></label>
                                    <div class="controls">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Provinsi</label>
                                    <div class="controls"><span class="add-on">
                                        <select class="provinsOps" id="penagihanPRV" style="width:398px" name="provinceops" data-placeholder="Choose a Province" tabindex="1">
                                        </select></span>
                                        <div style="position: absolute;margin:-30px 400px" class="pengihanPRVss"></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row-fluid">
                        <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Kota</label>
                                    <div class="controls">
                                        <select class="kotaOps" id="penagihanKOTA" style="width:398px" name="provinceops" data-placeholder="Choose a City" tabindex="1">
                                        </select>
                                        <div style="position: absolute;margin:-30px 400px" class="PNGHctyss"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Kode Pos</label>
                                    <div class="controls">
                                        <input type="text" id="ops_kodepos" name="ops_kodepos" value="{{ old('ops_kodepos') }}" class="span2" maxlength="6" />
                                        <div style="position: absolute;margin:-30px 65px" class="ops_kodeposss"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                            <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Alamat</label>
                                <div class="control-group">
                                    <textarea class="span12" style="width:180%;height:80px" id="alamatpenagihan" placeholder="Alamat penagihan Customer" name="alamatpenagihan" rows="3"></textarea>
                                    <div style="position: absolute;margin:-55px 1075px" class="PNGHN_alamatss"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <hr>
                            </div>
                        </div>
                      <div class="row-fluid">
                              <div class="span12">
                                  <div class="control-group">
                                      <label class="control-label"> <strong>Informasi Operasional</strong></label>
                                      <div class="controls">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row-fluid">
                              <div class="span6">
                                  <div class="control-group">
                                      <div class="controls">
                                      </div>
                                  </div>
                              </div>
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label">Provinsi</label>
                                      <div class="controls">
                                        <div class="provinceopsss"></div>
                                          <select class="provinsOps" id="provinceops" style="width:398px" name="provinceopsX" data-placeholder="Choose a Province" tabindex="1">
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                            <div class="row-fluid">
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Alamat</label>
                                      <div class="controls">
                                          <input type="text" name="address" id="address" value="{{ old('address') }}" style="width:385px" />
                                          <div style="position: absolute;margin:-30px 400px" class="alamatops"></div>
                                      </div>
                                  </div>
                              </div>
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Kota</label>
                                      <div class="controls">
                                          <select class="kotaOps" style="width:395px;" name="kota" id="kota" data-placeholder="Choose a City" tabindex="1">
                                          </select>
                                            <div style="position: absolute;margin:-30px 400px" class="ops_kotass"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row-fluid">
                              <div class="span6">
                                  <div class="control-group">
                                      <label class="control-label">No Telepon</label>
                                      <div class="controls">
                                          <input type="text" class="input-phone-origin-address-customer-telf" id="phone" name="phone" value="{{ old('phone') }}" style="width:385px" />
                                      </div>
                                  </div>
                              </div>
                              <div class="span6">
                              <div class="control-group">
                                      <label class="control-label">Fax</label>
                                      <div class="controls">
                                          <input type="text" id="fax" name="fax" value="{{ old('fax') }}" class="span12 input-phone-origin-address-customer-v" />
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row-fluid">
                                  <div class="span6">
                                      <div class="control-group">
                                          {{--  <label class="control-label">Email</label>  --}}
                                          <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Email</label>
                                          <div class="controls">
                                            <div class="input-prepend">
                                              <span class="add-on">@</span><input type="text" maxlength="50" style="width:160%;" id="email" name="email" value="{{ old('email') }}" class="span12" />
                                          </div>
                                          <div style="position: absolute;margin:-30px 367px" class="Emails"></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">Website</label>
                                        <div class="controls">
                                            <input type="text" name="website" id="website" value="{{ old('website') }}" class="span12" />
                                        </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="row-fluid">
                                      <div class="span12">
                                          <hr>
                                      </div>
                                  </div>
                          <div class="row-fluid">
                                  <div class="span12">
                                      <div class="control-group">
                                          <label class="control-label"> <strong>Informasi Finance</strong></label>
                                          <div class="controls">
                                              {{--  <input type="text" class="span12 " />  --}}
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row-fluid">
                                  <div class="span6">
                                      <div class="control-group">
                                          <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Nama Bank</label>
                                          <div class="controls">
                                            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" style="width:395px;" class="span12" />
                                            <div style="position: absolute;margin:-30px 400px" class="nama_bankss"></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="span6">
                                          <div class="control-group">
                                              <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;No rekening</label>
                                              <div class="controls">
                                                  <input type="text" id="no_rek" name="no_rek" value="{{ old('no_rek') }}"  style="width:380px;" />
                                                <div style="position: absolute;margin:-30px 400px"  class="nomor_rekeningss"></div>
                                              </div>
                                          </div>
                                      </div>
                              </div>
                              <div class="row-fluid">
                                  <div class="span6">
                                      <div class="control-group">
                                          <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Atas Nama Rekening</label>
                                          <div class="controls">
                                              <input type="text" name="an_bank" id="an_bank" value="{{ old('an_bank') }}" style="width:380px;" />
                                            <div style="position: absolute;margin:-30px 400px" class="atas_nama_bankss"></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="span6">
                                          <div class="control-group">
                                            <label class="control-label"><label style="font-size: 20px; color:darkred;position:absolute">*</label>&nbsp;&nbsp;&nbsp;Term Of Payment</label>
                                            <div class="controls">
                                                <input type="text" maxlength="2" id="term_of_payment" name="term_of_payment" value="{{ old('term_of_payment') }}"  class="span2" /> Day(s)
                                                <div style="position: absolute;margin:-30px 110px" class="kebijakan_pembayaranss"></div>
                                            </div>
                                        </div>
                                  </div>
                              </div>
                              <div class="modal-footer" style="padding-bottom: 25px;">
                                {{-- <div class="row-fluid">
                                <div class="span12" style="text-align:right;" >
                                        <div class="form-actions" style=""   >
                                        <button type="submit" class="btn btn-success">Register Customer</button>
                                    <a class="btn btn-warning" href="{{ route('master.customer.list', session()->get('id')) }}">Cancel</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row-fluid">
                                <div class="span12">
                                <button id="add_master_customer" type="submit" class="btn btn-success">Save</button>
                                {{-- <a href="#myModal3" role="button" type="submit" class="btn btn-primary" data-toggle="modal">Confirm</a> --}}
                                <a class="btn btn-warning" data-dismiss="modal">Cancel</a>
                                {{-- <a class="btn btn-warning" href="{{ route('transport.static', $some) }}">Cancel</a> --}}
                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    </body>
{{-- @section('javascript') --}}
{{-- @endsection --}}
