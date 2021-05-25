<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financings = DB::table('ld_ststrackingheader')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->where('TYPE','=','STL')
        ->distinct()
        ->paginate(5);

        // view list in the dropdown menu for status
        $status = DB::table('parameters')
        ->where('group','=','case_status')
        ->distinct()
        ->get();

        // view list in the dropdown menu for applicant
        $applicant_list = DB::table('ld_ststrackingheader')
        ->selectRaw('DISTINCT cf_custmaster.CUSTNO, cf_custmaster.FULLNAME')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->where('ld_ststrackingheader.TYPE','=','STL')
        // ->distinct()
        ->get();

        $types = DB::table('parameters')
        ->select('value_details', 'description')
        ->where('group','Type')
        ->whereIn('param_value', ['rst', 'vlo', 'rin', 'stl'])
        ->orderBy('description')
        ->pluck('description', 'value_details');
        // dd($applicant_list);

        $solicitors = DB::table('ld_ststrackingheader')
        ->selectRaw('DISTINCT ICode, Name')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->where('ld_ststrackingheader.TYPE','=','STL')
        // ->distinct()
        ->get();

        return view('report.index', compact('financings', 'applicant_list', 'status', 'types', 'solicitors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $memo_date = ($request->memo_date) ? Carbon::createFromFormat('d M Y', $request->memo_date)->format('Y-m-d') : "";
        // $title = $request->type;
        $title = ($request->type) ? DB::table('parameters')
        ->select('value_details', 'description')
        ->where('group','Type')
        ->pluck('description', 'value_details')[$request->type] : "View All";

        $com_finan = DB::table('financings')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'financings.header_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
        ->when($request['type'], function ($query, $type) {
            return $query->where('TYPE', $type);
        })
        ->when($request['status'], function ($query, $status) {
            return $query->where('status_case', $status);
        })
        ->when($request['applicants'], function ($query, $applicants) {
            return $query->where('cf_custmaster.CUSTNO', $applicants);
        })
        ->when($request['facility'], function ($query, $facility) {
            // return $query->where('', $facility);
        })
        ->when($request['memo_date'], function ($query, $memo_date) {
            return $query->where('DTMINUTES', $memo_date);
        })
        ->when($request['solicitors'], function ($query, $solicitors) {
            return $query->where('ICode', $solicitors);
        })
        ->where('status_comment','=','Active');

        $com_restruc = DB::table('restructures')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'restructures.header_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
        ->when($request['type'], function ($query, $type) {
            return $query->where('TYPE', $type);
        })
        ->when($request['status'], function ($query, $status) {
            return $query->where('status_case', $status);
        })
        ->when($request['applicants'], function ($query, $applicants) {
            return $query->where('cf_custmaster.CUSTNO', $applicants);
        })
        ->when($request['facility'], function ($query, $facility) {
            // return $query->where('', $facility);
        })
        ->when($request['memo_date'], function ($query, $memo_date) {
            return $query->where('DTMINUTES', $memo_date);
        })
        ->when($request['solicitors'], function ($query, $solicitors) {
            return $query->where('ICode', $solicitors);
        })
        ->where('status_comment','=','Active');

        $com_reins = DB::table('reinstates')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'reinstates.header_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
        ->when($request['type'], function ($query, $type) {
            return $query->where('TYPE', $type);
        })
        ->when($request['status'], function ($query, $status) {
            return $query->where('status_case', $status);
        })
        ->when($request['applicants'], function ($query, $applicants) {
            return $query->where('cf_custmaster.CUSTNO', $applicants);
        })
        ->when($request['facility'], function ($query, $facility) {
            // return $query->where('', $facility);
        })
        ->when($request['memo_date'], function ($query, $memo_date) {
            return $query->where('DTMINUTES', $memo_date);
        })
        ->when($request['solicitors'], function ($query, $solicitors) {
            return $query->where('ICode', $solicitors);
        })
        ->where('status_comment','=','Active');

        $com_vlo = DB::table('vlos')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'vlos.header_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
        ->when($request['type'], function ($query, $type) {
            return $query->where('TYPE', $type);
        })
        ->when($request['status'], function ($query, $status) {
            return $query->where('status_case', $status);
        })
        ->when($request['applicants'], function ($query, $applicants) {
            return $query->where('cf_custmaster.CUSTNO', $applicants);
        })
        ->when($request['facility'], function ($query, $facility) {
            // return $query->where('', $facility);
        })
        ->when($request['memo_date'], function ($query, $memo_date) {
            return $query->where('DTMINUTES', $memo_date);
        })
        ->when($request['solicitors'], function ($query, $solicitors) {
            return $query->where('ICode', $solicitors);
        })
        ->where('status_comment','=','Active')
        // ->where('ID','=', $id )
        ->union($com_finan)
        ->union($com_restruc)
        ->union($com_reins)
        ->get();
        // dd($com_finan);

        if ($id === 'excel') {
            return Excel::download(new ReportExport([
                'com_vlo' => $com_vlo,
                'title' => $title,
            ]), 'invoices.xlsx');
        }

        $pdf = \PDF::loadView('report.pdf.reportPdf', compact('com_vlo', 'title'));
        return $pdf->stream();
        // return view('report.pdf.reportPdf', compact('com_vlo', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request) 
    {
        
    }
}
