<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Booking;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

    public function reportAgent()
    {
        $agents = Agent::all();
        $data = array(
            'title' => 'Report Agent | ',
            'dataagent' => $agents,
        );
        return view('backend.agent.reportagent', $data);
    }

    public function filterReport(Request $request)
    {
        $query = Booking::query();

        if ($request->filled('tgl_from')) {
            $query->whereDate('tgl_booking', '>=', $request->tgl_from);
        }

        if ($request->filled('tgl_to')) {
            $query->whereDate('tgl_booking', '<=', $request->tgl_to);
        }

        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }

        $databooking = $query->with('agent', 'user')->get();

        return response()->json($databooking);
    }

    public function export(Request $request)
    {
        $type = $request->query('type');
        $tglFrom = $request->query('tgl_from');
        $tglTo = $request->query('tgl_to');
        $agentId = $request->query('agent_id');

        $query = Booking::query();

        if ($tglFrom && $tglTo) {
            $query->whereBetween('tgl_booking', [$tglFrom, $tglTo]);
        }

        if ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $bookings = $query->get();

        if ($type == 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $startCol = 'A';
            $endCol = 'E';

            // Add title and date range, merge cells for the title
            $sheet->mergeCells("{$startCol}1:{$endCol}1");
            $sheet->setCellValue("{$startCol}1", 'Report Agent');
            $sheet->mergeCells("{$startCol}2:{$endCol}2");
            $sheet->setCellValue("{$startCol}2", 'Dari ' . \Carbon\Carbon::parse($tglFrom)->format('d F Y') . ' s/d ' . \Carbon\Carbon::parse($tglTo)->format('d F Y'));

            // Add header
            $header = ['Nama Agent', 'Invoice', 'Tgl Pemesanan', 'Sub Total', 'Status'];
            $sheet->fromArray($header, null, 'A4');

            // Add data
            $row = 5; // Start data row after header and title
            foreach ($bookings as $booking) {
                $sheet->setCellValue('A' . $row, $booking->agent->nama_agent);
                $sheet->setCellValue('B' . $row, $booking->booking_id);
                $sheet->setCellValue('C' . $row, \Carbon\Carbon::parse($booking->tgl_booking)->format('d F Y'));
                $sheet->setCellValue('D' . $row, $booking->total_subtotal);
                $sheet->setCellValue('E' . $row, $booking->status);
                $row++;
            }

            // Auto width
            foreach (range('A', 'E') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Add borders
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $sheet->getStyle('A4:E' . ($row - 1))->applyFromArray($styleArray);

            // Add header styling
            $sheet->getStyle('A4:E4')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFF00'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Add title styling
            $sheet->getStyle('A1:A2')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            $writer = new Xlsx($spreadsheet);
            $filename = 'report-agent-' . date('Ymd') . '.xlsx';
            $writer->save($filename);

            return response()->download($filename)->deleteFileAfterSend(true);
        } elseif ($type == 'pdf') {
            $data = array(
                'tgl_from' => $tglFrom,
                'tgl_to' => $tglTo,
                'bookings' => $bookings,
            );
            $pdf = PDF::loadView('backend.agent.exportspdf', $data);
            return $pdf->download('report-agent-' . date('Ymd') . '.pdf');
        }
    }
}
