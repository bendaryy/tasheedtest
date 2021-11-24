<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function invoice(Request $request)
    {

        $invoice =
            [
            "issuer" => array(
                "address" => array(
                    "branchID" => "0",
                    "country" => "EG",
                    "governate" => auth()->user()->details->governate,

                    "regionCity" => auth()->user()->details->regionCity,
                    "street" => auth()->user()->details->street,
                    "buildingNumber" => auth()->user()->details->buildingNumber,
                ),
                "type" => auth()->user()->details->issuerType,
                "id" => auth()->user()->details->company_id,
                "name" => auth()->user()->details->company_name,
            ),
            "receiver" => array(
                "address" => array(
                    "country" => "EG",
                    "governate" => "-",
                    "regionCity" => "-",
                    "street" => $request->street,
                    "buildingNumber" => "-",
                ),
                "type" => $request->receiverType,
                "id" => $request->receiverId,
                "name" => $request->receiverName,
            ),
            "documentType" => $request->DocumentType,
            "documentTypeVersion" => "0.9",
            "dateTimeIssued" => $request->date . "T" . date("h:i:s") . "Z",
            "taxpayerActivityCode" => $request->taxpayerActivityCode,
            "internalID" => $request->internalId,
            "invoiceLines" => [

            ],
            "totalDiscountAmount" => floatval($request->totalDiscountAmount),
            "totalSalesAmount" => floatval($request->TotalSalesAmount),
            "netAmount" => floatval($request->TotalNetAmount),
            "taxTotals" => array(
                array(
                    "taxType" => "T4",
                    "amount" => floatval($request->totalt4Amount),
                ),
                array(
                    "taxType" => "T1",
                    "amount" => floatval($request->totalt2Amount),
                ),
            ),
            "totalAmount" => floatval($request->totalAmount2),
            "extraDiscountAmount" => floatval($request->ExtraDiscount),
            "totalItemsDiscountAmount" => floatval($request->totalItemsDiscountAmount),
        ];

        for ($i = 0; $i < count($request->quantity); $i++) {
            $Data = [
                "description" => $request->invoiceDescription[$i],
                "itemType" => "GS1",
                "itemCode" => $request->itemCode[$i],
                // "itemCode" => "10003834",
                "unitType" => "EA",
                "quantity" => floatval($request->quantity[$i]),
                "internalCode" => "100",
                "salesTotal" => floatval($request->salesTotal[$i]),
                "total" => floatval($request->totalItemsDiscount[$i]),
                "valueDifference" => 0.00,
                "totalTaxableFees" => 0.00,
                "netTotal" => floatval($request->netTotal[$i]),
                "itemsDiscount" => floatval($request->itemsDiscount[$i]),

                "unitValue" => [
                    "currencySold" => "EGP",
                    "amountSold" => 0.00,
                    "currencyExchangeRate" => 0.00,
                    "amountEGP" => floatval($request->amountEGP[$i]),
                ],
                "discount" => [
                    "rate" => 0.00,
                    "amount" => floatval($request->discountAmount[$i]),
                ],
                "taxableItems" => [
                    [

                        "taxType" => "T4",
                        "amount" => floatval($request->t4Amount[$i]),
                        "subType" => "W010",
                        "rate" => floatval($request->t4rate[$i]),
                    ],
                    [
                        "taxType" => "T1",
                        "amount" => floatval($request->t2Amount[$i]),
                        "subType" => "V009",
                        "rate" => floatval($request->rate[$i]),
                    ],
                ],

            ];
            $invoice['invoiceLines'][$i] = $Data;
        }

        // $storeAll = new Invoice();
        // $storeAll->invoice = json_encode($invoice, JSON_UNESCAPED_UNICODE);
        // $storeAll->save();

        // return ($invoice);

        // return new ProductResource($invoice);
        // return $datasave;

        $trnsformed = json_encode($invoice, JSON_UNESCAPED_UNICODE);
        $myFileToJson = fopen("D:\laragon\www/tasheedtest\EInvoicing\SourceDocumentJson.json", "w") or die("unable to open file");
        fwrite($myFileToJson, $trnsformed);
        return redirect()->route('cer');

    }
    public function openBat()
    {

        shell_exec('D:\laragon\www/tasheedtest\EInvoicing\SubmitInvoices2.bat');

        $path = "D:\laragon\www/tasheedtest\EInvoicing\FullSignedDocument.json";
        $path2 = "D:\laragon\www/tasheedtest\EInvoicing\Cades.txt";
        $path3 = "D:\laragon\www/tasheedtest\EInvoicing\CanonicalString.txt";
        $path4 = "D:\laragon\www/tasheedtest\EInvoicing\SourceDocumentJson.json";

        $fullSignedFile = file_get_contents($path);

        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $invoice = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Content-Type" => "application/json",
        ])->withBody($fullSignedFile, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1/documentsubmissions');

        if ($invoice['submissionId'] == !null) {
            unlink($path);
            unlink($path2);
            unlink($path3);
            unlink($path4);
            return redirect()->route('dashboard')->with('success', $invoice['acceptedDocuments'][0]['uuid'] . ' تم تسجيل الفاتورة بنجاح برقم');
        } else {
            unlink($path);
            unlink($path2);
            unlink($path3);
            unlink($path4);
            return redirect()->route('dashboard')->with('error', "يوجد خطأ فى الفاتورة من فضلك اعد تسجيلها");
        }
    }

    public function getData()
    {

        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');

        $getData = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get("https://api.preprod.invoicing.eta.gov.eg/api/v1/documents/" . "5H20HGH0EVPHSMTVEYT0B3EF10" . "/details");
        // $publicUrl = $getData['publicUrl'];
        // return redirect($publicUrl);
        return $getData->getBody();

        // return view('invoice.cancelled',compact());
    }

    public function showInvoices()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');

        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];

        return view('invoice.showissuer', compact('allInvoices', 'allMeta'));
    }
    public function showInvoices2()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');

        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.showreciever', compact('allInvoices', 'allMeta'));
    }

    public function showPdfInvoice($uuid)
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showPdf = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Accept-Language" => 'ar',
        ])->get("https://api.preprod.invoicing.eta.gov.eg/api/v1/documents/" . $uuid . "/pdf");

        return response($showPdf)->header('Content-Type', 'application/pdf');
    }

    public function create()
    {
        $allCompanies = Company::all();
        return view('invoice.create2', compact('allCompanies'));
    }

    public function cancelDocument($uuid)
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $cancel = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->put(
            'https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/state/' . $uuid . '/state',
            array(
                "status" => "cancelled",
                "reason" => "يوجد خطأ بالفاتورة",
            )
        );
        // return ($cancel);
        if ($cancel->ok()) {
            return redirect()->route('showAllInvoices')->with('success', 'تم تقديم طلب الغاء الفاتورة بنجاح سيتم الموافقة او الرفض فى خلال 3 ايام');
        } else {
            return redirect()->route('showAllInvoices')->with('error', $cancel['error']['details'][0]['message']);
        }
    }

    public function RejectDocument($uuid)
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $cancel = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->put(
            'https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/state/' . $uuid . '/state',
            array(
                "status" => "rejected",
                "reason" => "يوجد خطأ بالفاتورة",
            )
        );
        // return ($cancel);
        if ($cancel->ok()) {
            return redirect()->route('showAllInvoices2')->with('success', 'تم تقديم طلب رفض الفاتورة بنجاح سيتم الموافقة او الرفض فى خلال 3 ايام');
        } else {
            return redirect()->route('showAllInvoices2')->with('error', $cancel['error']['details'][0]['message']);
        }
    }


    public function DeclineRejectDocument($uuid)
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $cancel = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->put(
            'https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/state/' . $uuid . '/decline/rejection');
        // return ($cancel);
        if ($cancel->ok()) {
            return redirect()->back()->with('success', 'تم الغاء الرفض بنجاح');
        } else {
            return redirect()->back()->with('error', $cancel['error']['details'][0]['message']);
        }
    }


    public function DeclineCancelDocument($uuid)
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $cancel = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->put(
            'https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/state/' . $uuid . '/decline/cancelation');
        // return ($cancel);
        if ($cancel->ok()) {
            return redirect()->back()->with('success', 'تم الغاء الإلغاء بنجاح');
        } else {
            return redirect()->back()->with('error', $cancel['error']['details'][0]['message']);
        }
    }

    public function RequestcancelledDoc()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');

        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.requestCancelled', compact('allInvoices', 'allMeta'));
    }


    public function companiesRequestcancelledDoc()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');

        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.companiesRequestCancelled', compact('allInvoices', 'allMeta'));
    }


    public function cancelledDoc()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');


        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.showCancelled', compact('allInvoices', 'allMeta'));
    }


    public function companyCancelledDoc()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');


        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.showCompanyCancelled', compact('allInvoices', 'allMeta'));
    }



    public function rejected()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');


        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.showRejected', compact('allInvoices', 'allMeta'));
    }


    public function companyRejected()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');


        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.companyRejected', compact('allInvoices', 'allMeta'));
    }



    public function requestCompanyRejected()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');


        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.RequestCompanyRejected', compact('allInvoices', 'allMeta'));
    }


    public function requestRejected()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => auth()->user()->details->client_id,
            'client_secret' => auth()->user()->details->client_secret,
            'scope' => "InvoicingAPI",
        ]);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=2000000000');


        $allInvoices = $showInvoices['result'];

        $allMeta = $showInvoices['metadata'];
        return view('invoice.RequestRejected', compact('allInvoices', 'allMeta'));
    }





    public function create3(Request $request)
    {
        $allCompanies = Company::all();
        $companies = Company::where('id', $request->receiverName)->get();
        return view('invoice.create3', compact('companies', 'allCompanies'));
    }

    // public function testApi()
    // {

    //     $getData = Http::get("https://solochain.info/test-app/trips/list_cars.php");

    //     $tests = ($getData->json()['cars']);

    //     return view('test', compact('tests'));
    // }

    public function allUsers()
    {
        return User::all();
    }

    public function showAllInvoice()
    {
        $invoice = (Invoice::all());
        $hamada = response()->json($invoice);
        return $hamada;
    }


}
