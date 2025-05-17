

<div class="row">
    <div class="col-lg-6 col-md-6 mb-4">
        <label for="exampleFormControlSelect1" class="form-label">@lang('index.branch') <span style="color: red">*</span></label>
        <select class="form-select" id="exampleFormControlSelect1" name="branch_id" required>
            <option value="" {{isset($fingerprintScannerDetail) ? '': 'selected'}}  disabled >@lang('index.select_branch')</option>
            @foreach($companyDetail->branches()->get() as $key => $branch)
                <option value="{{ $branch->id }}" {{ ((isset($fingerprintScannerDetail) && ($fingerprintScannerDetail->branch_id ) == $branch->id) || (isset(auth()->user()->branch_id) && auth()->user()->branch_id == $branch->id)) ? 'selected': old('branch_id') }}> {{ucfirst($branch->name)}}</option>
            @endforeach
        </select>
    </div>


    <div class="col-lg-6 col-md-6 mb-4">
        <label for="scanner_ip_address" class="form-label">@lang('index.ip_address')  <span style="color: red">*</span></label>
        <input type="text" class="form-control" id="scanner_ip_address" required name="ip" value="{{ ( isset($fingerprintScannerDetail) ? ($fingerprintScannerDetail->ip): old('ip') )}}" autocomplete="off" placeholder="192.168.1.4">
    </div>

    <div class="col-lg-6 col-md-6 mb-4">
        <label for="scanner_port" class="form-label">@lang('index.port')  <span style="color: red">*</span></label>
        <input type="text" class="form-control" id="scanner_port" required name="port" value="{{ ( isset($fingerprintScannerDetail) ? ($fingerprintScannerDetail->port): old('port') )}}" autocomplete="off" placeholder="4370">
    </div>

    <div class="col-lg-12 text-start mb-4">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="{{isset($fingerprintScannerDetail)? 'edit-2':'plus'}}"></i> {{isset($fingerprintScannerDetail)? __('index.update'):__('index.add')}} @lang('index.finger_print_scanner')</button>
    </div>
</div>
