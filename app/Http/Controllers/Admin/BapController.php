<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class BapController extends Controller
{
    public function index()
    {
        // Get all approved laporans (BAP ready)
        $laporans = Laporan::with(['pekerjaan.lokasi', 'pekerjaan.client', 'pencairan'])
                    ->where('status', 'disetujui')
                    ->latest()
                    ->get();

        $hariIni = \Carbon\Carbon::now()->startOfDay();

        $kritis = \App\Models\Pekerjaan::where('status', '!=', 'Selesai')
                    ->whereDate('tanggal', '<', $hariIni)
                    ->count();

        $peringatan = \App\Models\Pekerjaan::where('status', '!=', 'Selesai')
                    ->whereDate('tanggal', '=', $hariIni)
                    ->count();

        $aman = Laporan::where('status', 'disetujui')->count();

        return view('admin.bap.index', compact('laporans', 'kritis', 'peringatan', 'aman'));
    }

    public function cetak(Request $request, $id)
    {
        $laporan = Laporan::with(['pekerjaan.lokasi', 'pekerjaan.client', 'user', 'fotos'])->findOrFail($id);
        
        $inputFileName = storage_path('app/template_bap.xlsx');
        if (!file_exists($inputFileName)) {
            return back()->with('error', 'File template_bap.xlsx tidak ditemukan di folder storage/app. Pastikan sudah menyimpannya dalam format .xlsx (Excel Workbook).');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

        // Fill BAP Sheet
        $bapSheet = $spreadsheet->getSheetByName('BAP ');
        if ($bapSheet) {
            // Hari & Tanggal
            $bapSheet->setCellValue('F14', \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->translatedFormat('l'));
            $bapSheet->setCellValue('H14', \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y'));

            // Lokasi
            $bapSheet->setCellValue('C17', $laporan->pekerjaan->lokasi->nama_lokasi ?? '-');
            
            // Kontraktor
            $bapSheet->setCellValue('C18', $request->input('kontraktor', 'CV ASA KARYA ALAM'));
            
            // No PO
            $bapSheet->setCellValue('C19', $request->input('no_po', '-'));
            
            // Tanggal PO
            if ($request->input('tanggal_po')) {
                // Menggunakan format yang sama dengan Excel (seperti 3-Jan-25)
                $bapSheet->setCellValue('C20', \Carbon\Carbon::parse($request->input('tanggal_po'))->locale('id')->format('j-M-y'));
            }

            // Waktu pelaksanaan
            $bapSheet->setCellValue('C25', \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->format('j F Y'));
        }

        // Fill Foto Sheet
        $fotoSheet = $spreadsheet->getSheetByName('Foto ');
        if ($fotoSheet) {
            $beforePhotos = $laporan->fotos->where('tipe', 'before')->values();
            $afterPhotos = $laporan->fotos->where('tipe', 'after')->values();

            // Insert Before Photos (around A12)
            $colBefore = 'B';
            foreach ($beforePhotos as $index => $foto) {
                if ($index >= 4) break; // max 4
                $path = storage_path('app/public/' . $foto->file_path);
                if (file_exists($path)) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Before ' . ($index+1));
                    $drawing->setDescription('Foto Sebelum Pekerjaan');
                    $drawing->setPath($path);
                    $drawing->setCoordinates($colBefore . '12');
                    $drawing->setHeight(180); // Set height for visibility
                    $drawing->setWorksheet($fotoSheet);
                    // shift column to the right for next photo (B, F, J...)
                    $colBefore = chr(ord($colBefore) + 4); 
                }
            }

            // Insert After Photos (around A29)
            $colAfter = 'B';
            foreach ($afterPhotos as $index => $foto) {
                if ($index >= 4) break; // max 4
                $path = storage_path('app/public/' . $foto->file_path);
                if (file_exists($path)) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('After ' . ($index+1));
                    $drawing->setDescription('Foto Sesudah Pekerjaan');
                    $drawing->setPath($path);
                    $drawing->setCoordinates($colAfter . '29');
                    $drawing->setHeight(180);
                    $drawing->setWorksheet($fotoSheet);
                    $colAfter = chr(ord($colAfter) + 4);
                }
            }
        }

        // Clean output buffer to prevent corrupted file
        if (ob_get_length()) ob_end_clean();

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $filename = 'BAP_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $laporan->pekerjaan->nama_pekerjaan) . '.xlsx';
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
