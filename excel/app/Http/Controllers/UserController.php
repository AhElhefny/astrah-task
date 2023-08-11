<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('welcome',['users' => $users]);
    }

    public function getHeadings(Request $request): JsonResponse
    {
        $this->validate($request,
            ['file' => ['required','mimes:csv,xlsx,xls']],
        );

        $file = $request->file('file')->getRealPath();
        HeadingRowFormatter::default('none');
        $columns = (new HeadingRowImport())->toArray($file)[0][0];
        return response()->json(['columns' => $columns]);
    }

    public function import(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'column_mappings' => 'required|array',
            'column_mappings.full_name' => 'required',
            'column_mappings.phone_number' => 'required',
            'column_mappings.email' => 'required',
        ]);

        $columnMappings = $request->input('column_mappings');
        Excel::import(new UsersImport($columnMappings),$request->file('file'));
        return redirect('/')->with(['success' => 'all records imported successfully']);
    }
}
