<?php

namespace warehouse\Http\Requests\Vendor_validation;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class vendorsValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function attributes()
    {
        return [
            'tahun' => 'Tahun berdiri perusahaan',
            'ops_email' => 'E-mail'
            // 'tax_nomor' => 'Npwp',
            // 'tax_kota' => '[Informasi NPWP]City',
            // 'tax_alamat' => '[Informasi NPWP]Alamat',
            // 'ops_kota' => '[Informasi Oprasonal]City',
            // 'alamat' => '[Informasi Oprasonal]address',
            // 'nama_bank' => '[Informasi Finance]Nama bank',
            // 'atas_nama_bank' => '[Informasi Finance]Atas nama rekening',
            // 'nomor_rekening' => '[Informasi Finance]Nomor rekening',
            // 'kebijakan_pembayaran' => '[Informasi Finance]Term',
            // 'tipe_bisnis' => '[Informasi Customer]Jenis usaha'
        ];
    }
    
    public function messages()
    {
        return [
            'project.required' => 'Customer wajib diisi',
            'tax_nomor.required'  => 'Npwp wajib diisi',
            'tax_kota.required'  => 'City wajib diisi',
            'tax_alamat.required'  => 'Address wajib diisi',
            'ops_kota.required'  => 'City wajib diisi',
            'alamat.required'  => 'Address wajib diisi',
            'nama_bank.required'  => 'Nama bank wajib diisi',
            'atas_nama_bank.required'  => 'Atas nama bank wajib diisi',
            'nomor_rekening.required'  => 'Nomor rekening wajib diisi',
            'kebijakan_pembayaran.required'  => 'Term wajib diisi',
            'tax_no.required'  => 'Npwp wajib diisi',
            'tax_no.string'  => 'Npwp wajib diisi & minimal 15 karakter(string)',
            'tax_no.min:15'  => 'Npwp wajib diisi & minimal 15 karakter',
            'tipe_bisnis.required'  => 'Tipe Bisnis wajib diisi',
            'CustomertaxType.required'  => 'Customer Type Tax wajib diisi',
            'ops_kodepos.required'  => 'Kode pos wajib diisi',
            'ops_email.required'  => 'Email wajib diisi',
            'ops_email.unique'  => 'Email sudah ada sebelumnya',
            'provinceops.required'  => 'Provinsi wajib diisi',
            'PNGHN_alamat.required'  => 'Alamat Pengihan wajib diisi',
            'PNGHcty.required'  => 'Kota Penagihan wajib diisi',
            'pengihanPRV.required'  => 'Provinsi Harus isi',
        ];
    }

    public function rules(){

        $sekarang = Carbon::now();

        $yearsBefore = $sekarang->subYears(1);

        $start =  Carbon::parse($this->start);
        
        return [
                    'tahun' =>  'required|date_format:d/m/Y|before:' . $yearsBefore . '', // tahun berdiri perusahaan tidak boleh kurang dari tanggal 2018-11-11
                    'project' => 'required',
                    'tax_nomor' => 'required',
                    'ops_email' => 'required|email|unique:vendors,email',
                    'tax_kota' => 'required',
                    'tax_alamat' => 'required',
                    'ops_kota' => 'required',
                    'alamat' => 'required',
                    'nama_bank' => 'required',
                    'atas_nama_bank' => 'required',
                    'nomor_rekening' => 'required',
                    'kebijakan_pembayaran' => 'required',
                    'tax_no' => ['required','string','min:15'],
                    'CustomertaxType' => 'required',
                    'ops_kodepos' => 'required',
                    'provinceops' => 'required',
                    'PNGHN_alamat' => 'required',
                    'PNGHcty' => 'required',
                    'pengihanPRV' => 'required'
         ];
    }
   
}