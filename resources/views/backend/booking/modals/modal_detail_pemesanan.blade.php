<div class="modal fade" id="detailPemesananModal" tabindex="-1" role="dialog" aria-labelledby="detailPemesananModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPemesananModalLabel">Add Detail Pemesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="detailPemesananForm" method="POST" action="{{ route('bookingdetail.store') }}">
                @csrf
                @auth
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                @endauth
                <div class="modal-body">
                    <!-- Table for adding detail pemesanan -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Tipe Kamar</th>
                                <th>Quantity</th>
                                <th>Tarif</th>
                                <th>Diskon</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataroom as $room)
                            <tr>
                                <td>
                                    <input type="checkbox" class="room-select" data-room-id="{{ $room->id_kamar }}">
                                </td>
                                <td>
                                    {{ $room->keterangan }}
                                    <input type="hidden" name="room_id[]" value="{{ $room->id_kamar }}" class="form-control" disabled>
                                </td>
                                <td><input type="number" name="qty[]" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" name="tarif[]" class="form-control" placeholder="Tarif" disabled></td>
                                <td><input type="number" name="discount[]" class="form-control" placeholder="0" value="0" disabled></td>
                                <td><input type="number" name="subtotal[]" class="form-control" placeholder="Sub Total" value="0" readonly disabled></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <input type="hidden" id="booking_id" class="form-control" name="booking_id" value="{{ $autoId }}" readonly />
                    <input type="hidden" id="malam1" name="malam">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>