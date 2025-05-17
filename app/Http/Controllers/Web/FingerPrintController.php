<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Router;
use App\Repositories\CompanyRepository;
use App\Repositories\FingerPrintRepository;
use App\Requests\FingerprintScanner\FingerprintScannerRequest;
use App\Requests\Router\RouterRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class FingerPrintController extends Controller
{
    private $view = 'admin.finger-print-scanners.';

    public function __construct(
        public FingerPrintRepository $fingerPrintRepository,
        public CompanyRepository $companyRepo
    )
    {
    }

    public function index()
    {
        $this->authorize('list_fingerprint_scanner');
        try {
            $with = ['branch:id,name', 'company:id,name'];
            $select = ['id', 'branch_id', 'company_id', 'ip', 'port'];
            $scanners = $this->fingerPrintRepository->getAllFingerPrintScanners($select, $with);
            return view($this->view . 'index', compact('scanners'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function create()
    {
        $this->authorize('create_fingerprint_scanner');
        try {
            $with = ['branches:company_id,id,name'];
            $select = ['id', 'name'];
            $companyDetail = $this->companyRepo->getCompanyDetail($select, $with);
            return view($this->view . 'create', compact('companyDetail'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function store(FingerprintScannerRequest $request)
    {
        $this->authorize('create_fingerprint_scanner');
        try {
            $validatedData = $request->validated();
            $validatedData['company_id'] = AppHelper::getAuthUserCompanyId();
            $validatedData['is_active'] = 1;
            DB::beginTransaction();
            $this->fingerPrintRepository->store($validatedData);
            DB::commit();
            return redirect()->route('admin.finger-print-scanners.index')
                ->with('success', __('message.finger_print_scanner_add'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('danger', $e->getMessage())
                ->withInput();
        }
    }

    public function show(Router $router)
    {
        //
    }

    public function edit($id)
    {
        $this->authorize('edit_fingerprint_scanner');
        try {
            $with = ['branches:company_id,id,name'];
            $select = ['id', 'name'];
            $companyDetail = $this->companyRepo->getCompanyDetail($select, $with);
            $fingerprintScannerDetail = $this->fingerPrintRepository->findFingerPrintScannerById($id);
            return view($this->view . 'edit', compact('fingerprintScannerDetail', 'companyDetail'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function update(FingerprintScannerRequest $request, $id)
    {
        $this->authorize('edit_fingerprint_scanner');
        try {
            $validatedData = $request->validated();
            $scanner = $this->fingerPrintRepository->findFingerPrintScannerById($id);
            if (!$scanner) {
                throw new Exception(__('message.finger_print_scanner_detail_not_found'), 404);
            }
            DB::beginTransaction();
            $this->fingerPrintRepository->update($scanner, $validatedData);
            DB::commit();
            return redirect()
                ->route('admin.finger-print-scanners.index')
                ->with('success', __('message.finger_print_scanner_update'));
        } catch (Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage())
                ->withInput();
        }

    }

    public function delete($id)
    {
        $this->authorize('delete_fingerprint_scanner');
        try {
            $scanner = $this->fingerPrintRepository->findFingerPrintScannerById($id);
            if (!$scanner) {
                throw new Exception(__('message.finger_print_scanner_detail_not_found'), 404);
            }
            DB::beginTransaction();
            $this->fingerPrintRepository->delete($scanner);
            DB::commit();
            return redirect()->back()->with('success', __('message.finger_print_scanner_delete'));
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }
}
