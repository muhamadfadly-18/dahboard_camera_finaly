<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;

use App\Models\worker;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use App\Exports\WorkersExport;
use PDF;
use Excel;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index(Request $request)
    {
        $worker = worker::all();
        return view('backend.admin.worker.index',compact('worker'));
    }
    public function data(Request $request)
    {

        if ($request->ajax()) {
                
            $view = View::make('backend.admin.worker.data')->render();
            return response()->json(['html' => $view]);
        
    } else {
        return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    }
    }
    
    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $workers = worker::orderBy('created_at', 'desc')->get();
            return Datatables::of($workers)
            ->addColumn('status', function ($worker) {
                return $worker->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
             })
                ->addColumn('action', function ($worker) {
                    $html = '<div class="btn-group">';
                    // $html .= '<button data-toggle="tooltip" class="btn btn-xs btn-info mr-1 view" title="View" data-id="' . $worker->id . '"><i class="fa fa-eye"></i></button>';
                   
                    $html .= '<button data-toggle="tooltip" class="btn btn-xs btn-warning mr-1 edit" title="Edit" data-id="' . $worker->id . '"><i class="fa fa-edit"></i></button>';
                    $html .= '<a href="worker/'. $worker->id . '/cetakpdf" data-toggle="tooltip" data-id="' .$worker->id . '" class="btn btn-xs btn-success mr-1 cetakpdf" title="PDF" target="_blank"><i class="fa fa-print"></i> </a>';
                    // $html .= '<button data-toggle="tooltip" class="btn btn-xs btn-danger delete" title="Delete" data-id="' . $worker->id . '"><i class="fa fa-trash"></i></button>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['action','status'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
           
          
           
                
                $view = View::make('backend.admin.worker.create')->render();
                return response()->json(['html' => $view]);
            
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            
                $rules = [
                    'id' => 'required',
                    'name' => 'required',
                    
                  
                    
                ];
    
                $validator = Validator::make($request->all(), $rules);
               
    
                    // Lakukan hashing pada password sebelum disimpan
                    $hashedPassword = bcrypt($request->input('password'));
    
                    $worker = new worker;
                    $worker->name = $request->input('name');
                    $worker->id = $request->input('id');
                 
                    $worker->save();
    
                    return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                
           
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show(worker $worker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
       if ($request->ajax()) {
          
        $worker = worker::find($id);
        
             $view = View::make('backend.admin.worker.edit', compact('worker'))->render();
             return response()->json(['html' => $view]);
         
       } else {
          return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, worker $worker)
    {
       if ($request->ajax()) {
         
 
        $rules = [
            'id' => 'required',
            'name' => 'required',
            
          
            
        ];

        $validator = Validator::make($request->all(), $rules);
       

                $worker = worker::findOrFail($worker->id);
                  $worker->name = $request->input('name');
                  $worker->id = $request->input('id');
                  
                  $worker->save();
                   return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                
             
          
       } else {
          return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, worker $worker)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('notice-delete');
            if ($haspermision) {
                $worker->delete();
                
                // Tambahkan key "reload" dengan nilai true pada respon JSON
                return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
    public function cetakpdf($id)
    {
        // $pdf = PDF::loadview('backend.admin.worker.worker_pdf');
        // return $pdf->download('tanda-terima-pdf');
        // return view('backend.admin.worker.worker_pdf');
        $worker  = worker::find($id);
        //  $dataPrintSetting = PrintSetting::find(1);
        $data = [
            'data' => $worker,
            //    'dataprintsetting' => $dataPrintSetting
            // Add more data as needed
        ];

        // Generate the PDF
    
        $pdf = PDF::loadView('backend.admin.worker.worker_pdf', $data);
    
        return $pdf->stream('test.pdf');
    }
    public function cetakpdfall()
    {
        // $pdf = PDF::loadview('backend.admin.worker.worker_pdf');
        // return $pdf->download('tanda-terima-pdf');
        // return view('backend.admin.worker.worker_pdf');
        $worker  = worker::all();
        //  $dataPrintSetting = PrintSetting::find(1);
        $data = [
            'data' => $worker,
            //    'dataprintsetting' => $dataPrintSetting
            // Add more data as needed
        ];

        // Generate the PDF
    
        $pdf = PDF::loadView('backend.admin.worker.worker_pdfall', $data);
    
        return $pdf->stream('test.pdf');
    }
    public function import(Request $request)
    {
        return view('import');
       
    }


    public function import_proses(Request $request)
    {

       
        $validatedData = $request->validate([
            'file' => 'required',
         ]);
         Excel::import(new UsersImport,$request->file('file'));
         return redirect()->back();
    }
    
    public function excelworker()
    {
        //pas download nama file nya mau apa
        //bisa mengunakan csv
        $file_name = 'data'.'.xlsx';
        //panggil pakege excel lakukan preoses download , logic export nya ada fi OrdersExport
        return Excel::download(new WorkersExport, $file_name);
        
    }
}
