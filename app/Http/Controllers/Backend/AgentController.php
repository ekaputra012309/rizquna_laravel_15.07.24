<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use RealRashid\SweetAlert\Facades\Alert;

class AgentController extends Controller
{
    public function index()
    {
        $agent = Agent::all();
        $data = array(
            'title' => 'Agent | ',
            'dataagent' => $agent,
        );
        $title = 'Delete Agent!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.agent.index', $data);
    }

    public function create()
    {
        $lantai = Agent::all();
        $data = array(
            'title' => 'Add Agent | ',
            'datalantai' => $lantai,
        );
        return view('backend.agent.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_agent' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Agent::create($request->all());
        Alert::success('Success', 'agent created successfully.');

        return redirect()->route('agent.index');
    }

    public function show(Agent $agent)
    {
        $data = array(
            'title' => 'View Agent | ',
        );
        return view('backend.agent.show', $data);
    }

    public function edit(Agent $agent)
    {
        $data = array(
            'title' => 'Edit Agent | ',
            'agent' => $agent,
        );
        return view('backend.agent.edit', $data);
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'nama_agent' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $agent->update($request->all());
        Alert::success('Success', 'agent updated successfully.');

        return redirect()->route('agent.index');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        Alert::success('Success', 'agent deleted successfully.');

        return redirect()->route('agent.index');
    }
}
