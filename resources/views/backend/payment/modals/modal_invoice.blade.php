<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table w-100" id="invoiceTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Pemesanan</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Agen</th>
                                <th>Total Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datainvoice as $invoice)
                            <tr>
                                <td>
                                    <a class="btn btn-primary selectInvoiceBtn" data-invoice-id="{{ $invoice->id_booking }}" data-invoice-kode="{{ $invoice->booking_id }}" data-invoice-matauang="{{ $invoice->mata_uang }}" data-invoice-subtotal="{{ $invoice->total_subtotal }}">
                                        <i class="fas fa-hand-point-right"></i> Pilih
                                    </a>
                                </td>
                                <td>{{ $invoice->booking_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->tgl_booking)->format('d M Y') }}</td>
                                <td>{{ $invoice->agent->nama_agent }}</td>
                                <td>{{ $invoice->total_subtotal }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>