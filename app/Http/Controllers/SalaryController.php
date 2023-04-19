<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalary;
use App\Http\Requests\UpdateSalary;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SalaryController extends Controller
{
    // index
    public function index()
    {
        if (!Auth::user()->can('view_salary')) {
            abort(403, 'Unauthorized Action');
        }
        return view('salary.index');
    }

    // salary DataTable
    public function salaryDatatable(Request $request)
    {
        if (!Auth::user()->can('view_salary')) {
            abort(403, 'Unauthorized Action');
        }

        $salaries = Salary::with('employee');

        return Datatables::of($salaries)
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('employee_name', function ($each) {
                return $each->employee ? $each->employee->name : '-';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('month', function ($each) {
                return Carbon::parse('2023-' . $each->month . '-01')->format('M');
            })
            ->editColumn('amount', function ($each) {
                return number_format($each->amount) . ' MMK';
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (Auth::user()->can('edit_salary')) {
                    $edit_icon = '<a href="' . route('salary.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }
                if (Auth::user()->can('delete_salary')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }

                return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';

            })
            ->rawColumns(['action'])
            ->make(true);

    }

    // salary Create
    public function create()
    {
        if (!Auth::user()->can('create_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('employee_id')->get();
        return view('salary.create', compact('employees'));
    }

    // Store salary data
    public function store(StoreSalary $request)
    {
        if (!Auth::user()->can('create_salary')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $salary = [
            'user_id' => $request->user_id,
            'month' => $request->month,
            'year' => $request->year,
            'amount' => $request->amount,
        ];
        // dd($salary);
        Salary::create($salary);

        return redirect()->route('salary.index')->with(['createSuccess' => 'Salary Successfully create']);
    }

    // salary Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_salary')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('employee_id')->get();
        $salary = Salary::findOrFail($id);
        return view('salary.edit', compact('employees', 'salary'));
    }

    // salary Update
    public function update($id, UpdateSalary $request)
    {
        if (!Auth::user()->can('edit_salary')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $data = [
            'user_id' => $request->user_id,
            'month' => $request->month,
            'year' => $request->year,
            'amount' => $request->amount,
        ];

        Salary::where('id', $id)->update($data);
        return redirect()->route('salary.index')->with(['createSuccess' => 'Salary Successfully Update']);
    }

    // Delete salary
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_salary')) {
            abort(403, 'Unauthorized Action');
        }

        Salary::findOrFail($id)->delete();
        return 'success';
    }

    // User Validation Check
    private function validationRule($request)
    {

        Validator::make($request->all(), [
            'user_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required',
        ], [
            'user_id.required' => 'The Employee field is required.',
        ])->validate();

    }
}
