<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $data = array(
            'title' => 'Add Agent | ',
        );
        return view('backend.agent.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_agent' => 'required|string|max:255',
            'alamat' => 'required|string',
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
            'alamat' => 'required|string',
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

    public function exportExcel()
    {
        $agents = Agent::select('nama_agent', 'alamat', 'contact_person', 'telepon')->get();

        // Create a new PhpSpreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Nama Agent')
            ->setCellValue('B1', 'Alamat')
            ->setCellValue('C1', 'Contact Person')
            ->setCellValue('D1', 'Telepon');
        // Style for header row
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        // Apply header styles
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

        // Populate data
        $row = 2;
        foreach ($agents as $agent) {
            $sheet->setCellValue('A' . $row, $agent->nama_agent)
                ->setCellValue('B' . $row, $agent->alamat)
                ->setCellValue('C' . $row, $agent->contact_person)
                ->setCellValue('D' . $row, $agent->telepon);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Apply borders to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A1:D' . ($row - 1))->applyFromArray($styleArray);

        // Prepare the Excel file response
        $filename = 'agents_' . date('Ymd') . '.xlsx';

        // Stream the file directly to the browser
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename);
    }

    public function exportPDF()
    {
        $agents = Agent::all();

        $pdf = PDF::loadView('backend.agent.exportpdf', compact('agents'));

        return $pdf->download('agents_' . date('Ymd') . '.pdf');
    }
}
