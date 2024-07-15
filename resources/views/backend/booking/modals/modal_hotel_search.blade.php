<div class="modal fade" id="hotelSearchModal" tabindex="-1" role="dialog" aria-labelledby="hotelSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hotelSearchModalLabel">Search Hotel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table w-100" id="hotelTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Hotel</th>
                                <th>Contact Person</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datahotel as $hotel)
                            <tr>
                                <td>
                                    <a class="btn btn-primary selectHotelBtn" data-hotel-id="{{ $hotel->id_hotel }}" data-hotel-name="{{ $hotel->nama_hotel }}" data-hotel-contact="{{ $hotel->contact_person }}" data-hotel-phone="{{ $hotel->telepon }}" data-hotel-address="{{ $hotel->alamat }}">
                                        <i class="fas fa-hand-point-right"></i> Pilih
                                    </a>
                                </td>
                                <td>{{ $hotel->nama_hotel }}</td>
                                <td>{{ $hotel->contact_person }}</td>
                                <td>{{ $hotel->telepon }}</td>
                                <td>{{ $hotel->alamat }}</td>
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