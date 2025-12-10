<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where('code', 'like', "%{$q}%");
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->get('is_active'));
        }

        $vouchers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('admin.vouchers.listVoucher', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.createVoucher');
    }

    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|string|unique:vouchers,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount_value' => 'nullable|numeric|min:0',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'after_or_equal' => ':attribute phải sau hoặc bằng ngày bắt đầu.',
        ];
        $attributes = [
            'code' => 'Mã',
            'discount_type' => 'Loại giảm giá',
            'discount_value' => 'Giá trị giảm',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'min_order_value' => 'Giá trị đơn tối thiểu',
            'max_discount_value' => 'Giá trị giảm tối đa',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        $data['code'] = Str::upper($data['code']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Tạo mã giảm giá thành công.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.editVoucher', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $rules = [
            'code' => 'required|string|unique:vouchers,code,' . $voucher->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount_value' => 'nullable|numeric|min:0',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'after_or_equal' => ':attribute phải sau hoặc bằng ngày bắt đầu.',
        ];
        $attributes = [
            'code' => 'Mã',
            'discount_type' => 'Loại giảm giá',
            'discount_value' => 'Giá trị giảm',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'min_order_value' => 'Giá trị đơn tối thiểu',
            'max_discount_value' => 'Giá trị giảm tối đa',
        ];

        $data = $request->validate($rules, $messages, $attributes);
        $data['code'] = Str::upper($data['code']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Đã xóa mã giảm giá.');
    }
}
