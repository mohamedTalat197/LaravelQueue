<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NumberHelper;
use App\Models\Vendor;
use App\Jobs\changeVendorStatus;
use App\Repos\QrCodeRepo;
use App\Repos\VendorRepo;
use App\Http\Resources\VendorResource;
use App\Validations\VendorValidation;
use App\Http\Collections\VendorCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\Http\Resources\UserResource;
use App\Models\User;

class VendorController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    use \App\Traits\ApiResponseTrait;
    private $vendorRepo;
    private $qrCodeRepo;
    private $vendorValidation;


    /**
     * @param VendorRepo $vendorRepo
     * @param QrCodeRepo $qrCodeRepo
     * @param VendorValidation $vendorValidation
     */
    public function __construct(VendorRepo $vendorRepo
        , QrCodeRepo $qrCodeRepo,
        VendorValidation $vendorValidation)
    {
        $this->vendorRepo=$vendorRepo;
        $this->qrCodeRepo=$qrCodeRepo;
        $this->vendorValidation=$vendorValidation;

    }

    public function get(Request $request)
    {
        $parent=Auth::user();
        $request['parent_id']=$parent->id;
        $vendors = $this->vendorRepo->get($request);
        return $this->apiResponseData(new VendorCollection($vendors));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        App::setLocale($request->header('lang'));
        $user_id = Auth::user()->id;
        $request['$user_id'] = $user_id;
        $qrCode = $this->qrCodeRepo->single($request->qr_id);
        if ($qrCode->vendor()->exists())
            return $this->apiResponseMessage(0, __('validationMessage.qr_id_already_selected'), 200);
        $qrCode_id =$qrCode->id;
        $request['$qrCode_id'] = $qrCode_id;
        $validateVendor = $this->vendorValidation->validate($request);
        if ($validateVendor->operationType == ERROR)
            return $this->apiResponseMessage(0, $validateVendor->error, 200);
        $vendor = $this->vendorRepo->create($request, $qrCode_id);
        return $this->apiResponseData(new VendorResource($vendor));
    }


    public function changeStatus()
    {
        dispatch(new changeVendorStatus());
        return response()->json(['message' => 'status will update']);
    }

}
