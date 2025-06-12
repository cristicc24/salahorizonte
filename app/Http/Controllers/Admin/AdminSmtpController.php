<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;

class AdminSmtpController extends Controller
{
    public function edit()
    {
        $smtp = SmtpSetting::first() ?? new SmtpSetting();
        return view('admin.smtp.edit', compact('smtp'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required|integer',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'nullable',
            'from_address' => 'required|email',
            'from_name' => 'required',
        ]);

        SmtpSetting::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Configuración SMTP actualizada.');
    }
}
