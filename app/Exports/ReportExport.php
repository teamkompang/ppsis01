<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class ReportExport implements FromView
{

	public function __construct(array $data)
	{
		$this->data = $data;
	}

	public function view(): View
	{
		$title = $this->data['title'];
		$com_vlo = $this->data['com_vlo'];
		// dd($com_vlo);
		return view('report.pdf.reportPdf', compact('title', 'com_vlo'));
	}
}
