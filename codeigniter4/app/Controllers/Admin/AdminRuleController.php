<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RuleModel;
use App\Models\RiskFactorModel;
use App\Models\RiskLevelModel;
use Dompdf\Dompdf;

class AdminRuleController extends BaseController
{
    protected $ruleModel;
    protected $factorModel;
    protected $levelModel;

    public function __construct()
    {
        $this->ruleModel = new RuleModel();
        $this->factorModel = new RiskFactorModel();
        $this->levelModel = new RiskLevelModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Aturan',
            'rules' => $this->ruleModel->getRulesWithRelations(),
        ];
        return view('Admin/rules/index', $data);
    }

    public function new()
    {
        $data = [
            'title'   => 'Tambah Aturan',
            'code'    => $this->ruleModel->generateCode(),
            'factors' => $this->factorModel->findAll(),
            'levels'  => $this->levelModel->findAll(),
        ];
        return view('Admin/rules/create', $data);
    }

    public function create()
    {
        if (!$this->validate([
            'risk_level_id'     => 'required',
            'min_other_factors' => 'required|numeric',
            'priority'          => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ruleModel->save([
            'code'               => $this->ruleModel->generateCode(),
            'risk_level_id'      => $this->request->getPost('risk_level_id'),
            'required_factor_id' => $this->request->getPost('required_factor_id') ?: null, // Bisa NULL
            'min_other_factors'  => $this->request->getPost('min_other_factors'),
            'max_other_factors'  => $this->request->getPost('max_other_factors') ?: 99,
            'priority'           => $this->request->getPost('priority'),
        ]);

        return redirect()->to('/admin/rules')->with('message', 'Aturan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rule = $this->ruleModel->find($id);
        if (!$rule) return redirect()->to('/admin/rules')->with('error', 'Data tidak ditemukan');

        $data = [
            'title'   => 'Edit Aturan',
            'rule'    => $rule,
            'factors' => $this->factorModel->findAll(),
            'levels'  => $this->levelModel->findAll(),
        ];
        return view('Admin/rules/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'risk_level_id'     => 'required',
            'min_other_factors' => 'required|numeric',
            'priority'          => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ruleModel->update($id, [
            'risk_level_id'      => $this->request->getPost('risk_level_id'),
            'required_factor_id' => $this->request->getPost('required_factor_id') ?: null,
            'min_other_factors'  => $this->request->getPost('min_other_factors'),
            'max_other_factors'  => $this->request->getPost('max_other_factors') ?: 99,
            'priority'           => $this->request->getPost('priority'),
        ]);

        return redirect()->to('/admin/rules')->with('message', 'Aturan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->ruleModel->delete($id);
        return redirect()->to('/admin/rules')->with('message', 'Aturan berhasil dihapus.');
    }

    public function printPDF()
    {
        $data = ['rules' => $this->ruleModel->getRulesWithRelations()];
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('Admin/rules/print', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-aturan.pdf', ['Attachment' => 0]);
    }
}