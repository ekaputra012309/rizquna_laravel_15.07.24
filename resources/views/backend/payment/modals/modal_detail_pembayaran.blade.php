<div class="modal fade" id="detailPembayaranModal" tabindex="-1" role="dialog" aria-labelledby="detailPembayaranModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPembayaranModal">Add Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="detailPembayaranForm" method="POST" action="{{ route('paymentdetail.store') }}">
                @csrf
                @auth
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                @endauth
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="tgl_payment" class="form-label">Tgl Pembayaran</label>
                                <div class="input-group">
                                    <input type="hidden" id="id_payment" class="form-control" name="id_payment" value="{{ $datapayment->id_payment }}" readonly />
                                    <input type="date" id="tgl_payment" name="tgl_payment" class="form-control" placeholder="Tgl Pembayaran" value="{{ date('Y-m-d') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="deposit" class="form-label">Deposit</label>
                                <input type="number" id="deposit" name="deposit" class="form-control" placeholder="0.00" step="0.01" data-parsley-required="true" autofocus />
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="metode_bayar_toggle" class="form-label">Pembayaran</label>
                                <div class="theme-toggle d-flex align-items-center mt-2">
                                    <label class="me-2" for="customSwitch1">Tunai</label>
                                    &nbsp; &nbsp;
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <input type="hidden" id="metode_bayar" name="metode_bayar" value="Tunai">
                                        <label class="custom-control-label" for="customSwitch1">Kredit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>