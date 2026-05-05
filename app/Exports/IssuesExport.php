<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Issue;
use App\Models\Issue_jenis_buku;
use App\Models\Issue_level_publikasi;
use App\Models\Issue_jenis_hak_cipta;
use App\Models\Issue_Penulis;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IssuesExport implements FromView
{
    public function view(): View
    {
        $dt = Issue::with('join_penulis')->get();
        // $dt2 = Issue_penulis::with('join_issue')->get();
        // dd($dt2);
        foreach ($dt as $key => $value) {
            // dd($value['join_penulis'][0]->koresponden);

            // BENTUK LUARAN NAME
            $bentuk_luaran = $value->bentuk_luaran;
            if ($bentuk_luaran == 1) {
                $dt[$key]->bentuk_luaran_name = "Buku";
            }
            if ($bentuk_luaran == 2) {
                $dt[$key]->bentuk_luaran_name = "Publikasi Artikel";
            }
            if ($bentuk_luaran == 3) {
                $dt[$key]->bentuk_luaran_name = "Prosiding";
            }
            if ($bentuk_luaran == 4) {
                $dt[$key]->bentuk_luaran_name = "Hak Kekayaan Intelektual";
            }

            // JENIS BUKU NAME
            $jenis_buku = $value->jenis_buku;
            if ($jenis_buku == 1) {
                $dt[$key]->jenis_buku_name = "Buku Referensi Internasional";
            }
            if ($jenis_buku == 2) {
                $dt[$key]->jenis_buku_name = "Buku Referensi Nasional";
            }
            if ($jenis_buku == 3) {
                $dt[$key]->jenis_buku_name = "Buku Monograf Internasional";
            }
            if ($jenis_buku == 4) {
                $dt[$key]->jenis_buku_name = "Buku Monograf Nasional";
            }
            if ($jenis_buku == 5) {
                $dt[$key]->jenis_buku_name = "Book Chapter Internasional";
            }
            if ($jenis_buku == 6) {
                $dt[$key]->jenis_buku_name = "Book Chapter Nasional";
            }
            if (is_null($jenis_buku)) {
                $dt[$key]->jenis_buku_name = "-";
            }

            // JENIS PUBLIKASI
            $jenis_publikasi = $value->jenis_publikasi;
            if ($jenis_publikasi == 1) {
                $dt[$key]->jenis_publikasi_name = "Artikel di Jurnal Internasional Open Access";
            }
            if ($jenis_publikasi == 2) {
                $dt[$key]->jenis_publikasi_name = "Artikel di Jurnal Internasional Close Access";
            }
            if ($jenis_publikasi == 3) {
                $dt[$key]->jenis_publikasi_name = "Artikel di Jurnal Nasional Terakreditasi";
            }
            if ($jenis_publikasi == 4) {
                $dt[$key]->jenis_publikasi_name = "rtikel di Prosiding Nasional dan Internasional";
            }
            if ($jenis_publikasi == 5) {
                $dt[$key]->jenis_publikasi_name = "Prosiding Internasional Terindeks Scopus dan Scimagojr";
            }
            if ($jenis_publikasi == 6) {
                $dt[$key]->jenis_publikasi_name = "Prosiding Internasional Terindeks Scopus, IEEE, SPIE";
            }
            if ($jenis_publikasi == 7) {
                $dt[$key]->jenis_publikasi_name = "Prosiding (ISSN atau ISBN) Nasional";
            }
            if (is_null($jenis_publikasi)) {
                $dt[$key]->jenis_publikasi_name = "-";
            }

            // LEVEL PUBLIKASI
            $level_publikasi = $value->level_publikasi;
            if ($level_publikasi == 1) {
                $dt[$key]->level_publikasi_name = "Q1 (Open Access)";
            }
            if ($level_publikasi == 2) {
                $dt[$key]->level_publikasi_name = "Q2 (Open Access)";
            }
            if ($level_publikasi == 3) {
                $dt[$key]->level_publikasi_name = "Q3 (Open Access)";
            }
            if ($level_publikasi == 4) {
                $dt[$key]->level_publikasi_name = "Q4 (Open Access)";
            }
            if ($level_publikasi == 5) {
                $dt[$key]->level_publikasi_name = "Q1 (Close Access)";
            }
            if ($level_publikasi == 6) {
                $dt[$key]->level_publikasi_name = "Q2 (Close Access)";
            }
            if ($level_publikasi == 7) {
                $dt[$key]->level_publikasi_name = "Q3 (Close Access)";
            }
            if ($level_publikasi == 8) {
                $dt[$key]->level_publikasi_name = "Q4 (Close Access)";
            }
            if ($level_publikasi == 9) {
                $dt[$key]->level_publikasi_name = "SINTA 1";
            }
            if ($level_publikasi == 10) {
                $dt[$key]->level_publikasi_name = "SINTA 2";
            }
            if ($level_publikasi == 11) {
                $dt[$key]->level_publikasi_name = "SINTA 3";
            }
            if ($level_publikasi == 12) {
                $dt[$key]->level_publikasi_name = "SINTA 4";
            }
            if ($level_publikasi == 13) {
                $dt[$key]->level_publikasi_name = "SINTA 5";
            }
            if ($level_publikasi == 14) {
                $dt[$key]->level_publikasi_name = "SINTA 6";
            }
            if ($level_publikasi == 15) {
                $dt[$key]->level_publikasi_name = "Prosiding Terindeks Scopus, Scimagojr";
            }
            if ($level_publikasi == 16) {
                $dt[$key]->level_publikasi_name = "Prosiding Terindeks Scopus, IEEE, SPIE";
            }
            if ($level_publikasi == 17) {
                $dt[$key]->level_publikasi_name = "Prosiding (ISSN atau ISBN) Nasional";
            }
            if (is_null($level_publikasi)) {
                $dt[$key]->level_publikasi_name = "-";
            }

            // JENIS HAK CIPTA
            $jenis_hak_cipta = $value->jenis_hak_cipta;
            if ($jenis_hak_cipta == 1) {
                $dt[$key]->jenis_hak_cipta_name = "Paten Desain Industri";
            }
            if ($jenis_hak_cipta == 2) {
                $dt[$key]->jenis_hak_cipta_name = "Paten Sederhana";
            }
            if ($jenis_hak_cipta == 3) {
                $dt[$key]->jenis_hak_cipta_name = "Hak Cipta dan Merek Produk Dagang";
            }
            if (is_null($jenis_hak_cipta)) {
                $dt[$key]->jenis_hak_cipta_name = "-";
            }

            // ISBN BUKU
            if (is_null($value->isbn_buku)) {
                $dt[$key]->isbn_buku_name = "-";
            }

            // LINK PUBLIKASI
            if (is_null($value->link_publikasi)) {
                $dt[$key]->link_publikasi = "-";
            }
            if (is_null($value->no_hak_cipta)) {
                $dt[$key]->no_hak_cipta = "-";
            }


            $kum = 100;
            $jumlah_penulis = count($value['join_penulis']);
            $dt[$key]->total_penulis = $jumlah_penulis;
            $jumlah_penulis_internal = Issue_Penulis::where('issue_id', $dt[$key]->id)
                ->Where('issue_penulis_jabatan_id', '!=', '3')
                ->get();
            $dt[$key]->total_penulis_internal = count($jumlah_penulis_internal);

            // JIKA BENTUK LUARAN 1 = BUKU DAN PENULIS PERTAMA KORESPONDEN
            if ($value->bentuk_luaran == 1) {
                $dt_apresiasi = Issue_jenis_buku::find($value->jenis_buku);
                $dt[$key]['nominal_apresiasi'] = $dt_apresiasi->nominal_jenis_buku;
                $kum = 100;
                for ($i = 0; $i < $jumlah_penulis; $i++) {
                    // JIKA PENULIS HANYA 1
                    if ($jumlah_penulis == 1) {
                        $value['join_penulis'][$i]->kum = $kum;
                    } elseif ($jumlah_penulis == 2) {
                        $value['join_penulis'][0]->kum = 60;
                        $value['join_penulis'][1]->kum = 40;
                    } elseif ($jumlah_penulis > 2) {
                        $value['join_penulis'][0]->kum = 60;
                        $value['join_penulis'][1]->kum = 40;
                        if ($i > 1) {
                            $value['join_penulis'][$i]->kum = 20 / ($jumlah_penulis - 2);
                        }
                        $value = $value;
                    }
                    $value = $value;
                }
                $value = $value;
                // dd($value['join_penulis']);
            }

            // PUBLIKASI JIKA PENULIS PERTAMA ADALAH KORESPONDEN
            if (($value->bentuk_luaran == 2 & $value['join_penulis'][0]->koresponden == 1) or ($value->bentuk_luaran == 3 & $value['join_penulis'][0]->koresponden == 1)) {
                $dt_apresiasi = Issue_level_publikasi::find($value->level_publikasi);
                $dt[$key]['nominal_apresiasi'] = $dt_apresiasi->nominal_level_publikasi;
                $kum = 100;
                for ($i = 0; $i < $jumlah_penulis; $i++) {
                    // JIKA PENULIS HANYA 1
                    if ($jumlah_penulis == 1) {
                        $value['join_penulis'][$i]->kum = $kum;
                    } elseif ($jumlah_penulis == 2) {
                        $value['join_penulis'][0]->kum = 60;
                        $value['join_penulis'][1]->kum = 40;
                    } elseif ($jumlah_penulis > 2) {
                        $value['join_penulis'][0]->kum = 60;
                        if ($i > 0) {
                            $value['join_penulis'][$i]->kum = 40 / ($jumlah_penulis - 1);
                        }
                        $value = $value;
                    }
                    $value = $value;
                }
                $value = $value;
            }

            // PUBLIKASI JIKA PENULIS PERTAMA BUKAN KORESPONDEN
            if (($value->bentuk_luaran == 2 & $value['join_penulis'][0]->koresponden != 1) or ($value->bentuk_luaran == 3 & $value['join_penulis'][0]->koresponden != 1)) {
                $dt_apresiasi = Issue_level_publikasi::find($value->level_publikasi);
                $dt[$key]['nominal_apresiasi'] = $dt_apresiasi->nominal_level_publikasi;
                $kum = 100;
                for ($i = 0; $i < $jumlah_penulis; $i++) {
                    // JIKA PENULIS HANYA 1
                    if ($jumlah_penulis == 1) {
                        $value['join_penulis'][$i]->kum = $kum;
                    } elseif ($jumlah_penulis == 2) {
                        $value['join_penulis'][0]->kum = 50;
                        $value['join_penulis'][1]->kum = 50;
                    } elseif ($jumlah_penulis > 2) {
                        $value['join_penulis'][0]->kum = 40;
                        $value['join_penulis'][1]->kum = 40;
                        if ($i > 1) {
                            $value['join_penulis'][$i]->kum = 20 / ($jumlah_penulis - 2);
                        }
                        $value = $value;
                    }
                    $value = $value;
                }
                $value = $value;
            }

            // HKI
            if ($value->bentuk_luaran == 4) {
                $dt_apresiasi = Issue_jenis_hak_cipta::find($value->jenis_hak_cipta);
                $dt[$key]['nominal_apresiasi'] = $dt_apresiasi->nominal_jenis_hak_cipta;
                $kum = 100;
                for ($i = 0; $i < $jumlah_penulis; $i++) {
                    // JIKA PENULIS HANYA 1
                    if ($jumlah_penulis == 1) {
                        $value['join_penulis'][$i]->kum = $kum;
                    } elseif ($jumlah_penulis == 2) {
                        $value['join_penulis'][0]->kum = 50;
                        $value['join_penulis'][1]->kum = 50;
                    } elseif ($jumlah_penulis > 2) {
                        $value['join_penulis'][0]->kum = 50;
                        if ($i > 0) {
                            $value['join_penulis'][$i]->kum = 50 / ($jumlah_penulis - 2);
                        }
                        $value = $value;
                    }
                    $value = $value;
                }
                $value = $value;
            }
            $value = $value;
        }

        // dd($dt);

        return view('admin.exports.issues', [
            'datas' => $dt
        ]);
    }
}
