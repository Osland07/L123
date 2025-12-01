<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RiskLevelModel;
use Dompdf\Dompdf;

class AdminRiskLevelController extends BaseController
{
    protected $riskLevelModel;

    public function __construct()
    {
        $this->riskLevelModel = new RiskLevelModel();
    }

    public function printPDF()
    {
        $data = [
            'risks' => $this->riskLevelModel->findAll(),
        ];

        $dompdf = new Dompdf();
        $html = view('Admin/risk_levels/print', $data);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // Stream PDF ke browser (Attachment: 0 artinya preview di tab baru)
        $dompdf->stream('laporan-tingkat-risiko.pdf', ['Attachment' => 0]);
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        
        if ($keyword) {
            $this->riskLevelModel->groupStart()
                ->like('name', $keyword)
                ->orLike('code', $keyword)
                ->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen Tingkat Risiko',
            'risks'   => $this->riskLevelModel->findAll(),
            'keyword' => $keyword
        ];
        return view('Admin/risk_levels/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Tingkat Risiko',
            'code'  => $this->riskLevelModel->generateCode(), // Generate kode di awal untuk ditampilkan
        ];
        return view('Admin/risk_levels/create', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate kode lagi saat save untuk menghindari duplikasi jika ada user lain yg input bersamaan
        $code = $this->riskLevelModel->generateCode();

        $this->riskLevelModel->save([
            'code'        => $code,
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'suggestion'  => $this->request->getPost('suggestion'),
        ]);

        return redirect()->to('/admin/risk-levels')->with('message', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $risk = $this->riskLevelModel->find($id);
        if (!$risk) {
            return redirect()->to('/admin/risk-levels')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Tingkat Risiko',
            'risk'  => $risk,
        ];
        return view('Admin/risk_levels/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->riskLevelModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'suggestion'  => $this->request->getPost('suggestion'),
        ]);

        return redirect()->to('/admin/risk-levels')->with('message', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->riskLevelModel->delete($id);
        return redirect()->to('/admin/risk-levels')->with('message', 'Data berhasil dihapus.');
    }
}
