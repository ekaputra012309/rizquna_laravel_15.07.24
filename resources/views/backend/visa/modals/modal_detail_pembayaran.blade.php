<div class="modal fade" id="detailPembayaranModal" tabindex="-1" role="dialog" aria-labelledby="detailPembayaranModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPembayaranModal">Add Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="detailPembayaranForm" method="POST" action="{{ route('visadetail.store') }}">
                @csrf
                @auth
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                @endauth
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="tgl_payment_visa" class="form-label">Tgl Pembayaran</label>
                                <div class="input-group">
                                    <input type="hidden" id="id_visa" class="form-control" name="id_visa" value="{{ $datavisa->id_visa }}" readonly />
                                    <input type="date" id="tgl_payment_visa" name="tgl_payment_visa" class="form-control" placeholder="Tgl Pembayaran" value="{{ date('Y-m-d') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mandatory">
                                <label for="deposit" class="form-label">Deposit</label>
                                <input type="number" id="deposit" name="deposit" class="form-control" placeholder="0.00" step="0.01" data-parsley-required="true" autofocus />
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