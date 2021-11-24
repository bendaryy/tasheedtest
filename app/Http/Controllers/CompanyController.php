<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function create()
    {
        return view('companies.store');
    }
    public function store(Request $request)
    {
        $company = Company::create([
            "name" => $request->name,
            "BetakaDriba" => $request->BetakaDriba,
            "AddrCo" => $request->AddrCo,
        ]);
        $company->save();

        return redirect()->route('showCustomers')->with('success', ' تم اضافة العميل ' . $request->name . ' بنجاح');

    }
    public function showAllCustomers()
    {
        $customers = Company::all();
        return view('companies.allCustomers', compact('customers'));
    }
    public function deleteCustomer($id)
    {
        $company = Company::find($id);
        $company->delete();
        return redirect()->back()->with('danger', 'تم مسحه بنجاح');
    }
    public function editCustomer($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.editCustomer', compact('company'));
    }
    public function updateCustomer(Request $request, $id)
    {

        $customer = Company::find($id);
        $customer->name = $request->name;
        $customer->BetakaDriba = $request->BetakaDriba;
        $customer->AddrCo = $request->AddrCo;

        $customer->save();
        return redirect()->route('showCustomers')->with('success','تم التعديل بنجاح');
    }
}
