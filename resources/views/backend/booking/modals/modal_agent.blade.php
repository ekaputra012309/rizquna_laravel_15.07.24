<div class="modal fade" id="agentModal" tabindex="-1" role="dialog" aria-labelledby="agentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agentModalLabel">Agent List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table w-100" id="agentTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Agen</th>
                                <th>Contact Person</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataagent as $agent)
                            <tr>
                                <td>
                                    <a class="btn btn-primary selectAgentBtn" data-agent-id="{{ $agent->id_agent }}" data-agent-name="{{ $agent->nama_agent }}" data-agent-contact="{{ $agent->contact_person }}" data-agent-phone="{{ $agent->telepon }}" data-agent-address="{{ $agent->alamat }}">
                                        <i class="fas fa-hand-point-right"></i> Pilih
                                    </a>
                                </td>
                                <td>{{ $agent->nama_agent }}</td>
                                <td>{{ $agent->contact_person }}</td>
                                <td>{{ $agent->telepon }}</td>
                                <td>{{ $agent->alamat }}</td>
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