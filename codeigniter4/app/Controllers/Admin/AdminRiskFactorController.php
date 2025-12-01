<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RiskFactorModel;
use Dompdf\Dompdf;

class AdminRiskFactorController extends BaseController
{
    protected $riskFactorModel;

    public function __construct()
    {
        $this->riskFactorModel = new RiskFactorModel();
    }

    public function printPDF()
    {
        $data = [
            'factors' => $this->riskFactorModel->findAll(),
        ];

        $dompdf = new Dompdf();
        $html = view('Admin/risk_factors/print', $data);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Portrait karena kolomnya sedikit
        $dompdf->render();
        
        $dompdf->stream('laporan-faktor-risiko.pdf', ['Attachment' => 0]);
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $this->riskFactorModel->groupStart()
                ->like('name', $keyword)
                ->orLike('code', $keyword)
                ->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen Faktor Risiko',
            'factors' => $this->riskFactorModel->findAll(),
            'keyword' => $keyword
        ];
        return view('Admin/risk_factors/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Faktor Risiko',
            'code'  => $this->riskFactorModel->generateCode(),
        ];
        return view('Admin/risk_factors/create', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $code = $this->riskFactorModel->generateCode();

        $this->riskFactorModel->save([
            'code'          => $code,
            'name'          => $this->request->getPost('name'),
            'question_text' => $this->request->getPost('question_text'),
        ]);

        return redirect()->to('/admin/risk-factors')->with('message', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $factor = $this->riskFactorModel->find($id);
        if (!$factor) {
            return redirect()->to('/admin/risk-factors')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Faktor Risiko',
            'factor'  => $factor,
        ];
        return view('Admin/risk_factors/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->riskFactorModel->update($id, [
            'name'          => $this->request->getPost('name'),
            'question_text' => $this->request->getPost('question_text'),
        ]);

        return redirect()->to('/admin/risk-factors')->with('message', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->riskFactorModel->delete($id);
        return redirect()->to('/admin/risk-factors')->with('message', 'Data berhasil dihapus.');
    }
}
