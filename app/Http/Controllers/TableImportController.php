<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TableImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx|max:100000'
        ]);
        //ddd($request->hasFile('file'));

        if ($request->hasFile('file')) {

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(request('file'));
            $worksheet = $spreadsheet->getActiveSheet();

            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
            $cat_name = array();
            $subcat_name = array();
            $subcattype_name = array();
            $attribute_name = array();
            $col1attr = array();
            $col3attr = array();
            $col5attr = array();
            $col7attr = array();
            $subtypearray = array();


            for ($row = 3; $row <= $highestRow; ++$row) {
                //for category
                $catvalue = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                if (!in_array($catvalue, $cat_name)) {
                    if ($catvalue != '') {
                        $cat_name[] = $catvalue;
                        $cat_name_final[] = [
                            'name' =>  strtoupper(Str::of($catvalue)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
            }
            // ddd($cat_name_final);
            if (!empty($cat_name_final)) {
                $insertData = DB::table('categories')->insertOrIgnore($cat_name_final);
            }

            for ($row = 3; $row <= $highestRow; ++$row) {
                $subcatvalue = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                if (!in_array($subcatvalue, $subcat_name)) {
                    $category = DB::table('categories')->where('name', $worksheet->getCellByColumnAndRow(2, $row)->getValue())->first();
                    //ddd($category->id);
                    if ($subcatvalue != '') {
                        $subcat_name[] = $subcatvalue;
                        $subcat_name_final[] = [
                            'category_id' => $category->id,
                            'name' =>  strtoupper(Str::of($subcatvalue)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
            }

            if (!empty($subcat_name_final)) {
                $insertData = DB::table('subcategories')->insertOrIgnore($subcat_name_final);
            }

            for ($row = 3; $row <= $highestRow; ++$row) {
                $subcattypevalue = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                if (!in_array($subcattypevalue, $subcattype_name)) {
                    $subcategory = DB::table('subcategories')->where('name', $worksheet->getCellByColumnAndRow(4, $row)->getValue())->first();
                    //ddd($category->id);
                    if ($subcattypevalue != '') {
                        $subcattype_name[] = $subcattypevalue;
                        $subcattype_name_final[] = [
                            'subcategory_id' => $subcategory->id,
                            'name' => strtoupper(Str::of($subcattypevalue)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
            }
            //ddd($subcat_name_final);
            if (!empty($subcat_name_final)) {
                $insertData = DB::table('subcategorytypes')->insertOrIgnore($subcattype_name_final);
            }


            for ($row = 3; $row <= $highestRow; ++$row) {
                $attributevalue = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                if (!in_array($attributevalue, $attribute_name)) {
                    if ($attributevalue != '') {
                        $attribute_name[] = $attributevalue;
                        $attribute_name_final[] = [
                            'name' =>  strtoupper(Str::of($attributevalue)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
                $col6 = $worksheet->getCellByColumnAndRow(6, $row)->getValue(); //subcategory type

                $col1 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $col3 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $col5 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $col7 = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                $subcategorytype = DB::table('subcategorytypes')->where('name', $worksheet->getCellByColumnAndRow(6, $row)->getValue())->first();
                if ($attributevalue != '') {
                    $attribute_name_final2[] = [
                        'name' =>    strtoupper(Str::of($attributevalue)->trim()),
                        'subcategorytype_id' => $subcategorytype->id,
                        'published' => 'Y',
                        'created_by' =>Auth::user()->email,
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ];
                }

                if (!in_array($col1, $col1attr)) { //tracking attribute master
                    if ($col1 != '') {
                        $col1attr[] = $col1;
                        $attribute_name_final[] = [
                            'name' =>  strtoupper(Str::of($col1)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
              unset($row_attr );
              $row_attr = array();

                if (!in_array($col6, $subtypearray)) {  // tracking if
                    $subtypearray[] = $col6;
                    if (!in_array($col1, $row_attr) && ($col1 != '') ) {
                        $row_attr[] = $col1;
                        $attribute_name_final2[] = [
                            'name' =>    strtoupper(Str::of($col1)->trim()),
                            'subcategorytype_id' => $subcategorytype->id,
                            'published' => 'Y',
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                    if (!in_array($col3, $row_attr) && ($col3 != '') ) {
                        $row_attr[] = $col3;
                        $attribute_name_final2[] = [
                            'name' =>    strtoupper(Str::of($col3)->trim()),
                            'subcategorytype_id' => $subcategorytype->id,
                            'published' => 'Y',
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                    if (!in_array($col5, $row_attr) && ($col5 != '') ) {
                        $row_attr[] = $col5;
                        $attribute_name_final2[] = [
                            'name' =>    strtoupper(Str::of($col5)->trim()),
                            'subcategorytype_id' => $subcategorytype->id,
                            'published' => 'Y',
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                    if (!in_array($col7, $row_attr) && ($col7 != '') ) {
                        $row_attr[] = $col7;
                        $attribute_name_final2[] = [
                            'name' =>    strtoupper(Str::of($col7)->trim()),
                            'subcategorytype_id' => $subcategorytype->id,
                            'published' => 'Y',
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
                if (!in_array($col3, $col3attr)) { //tracking attribute master
                    if ($col3 != '') {
                        $col3attr[] = $col3;
                        $attribute_name_final[] = [
                            'name' =>  strtoupper(Str::of($col3)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];

                    }
                }
                if (!in_array($col5, $col5attr)) { //tracking attribute master
                    if ($col5 != '') {
                        $col5attr[] = $col5;
                        $attribute_name_final[] = [
                            'name' =>  strtoupper(Str::of($col5)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];

                    }
                }

                if (!in_array($col7, $col7attr)) { //tracking attribute master
                    if ($col7 != '') {
                        $col7attr[] = $col7;
                        $attribute_name_final[] = [
                            'name' =>  strtoupper(Str::of($col7)->trim()),
                            'created_by' => Auth::user()->email,
                            "created_at" =>  date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];

                    }
                }
            }

            if (!empty($attribute_name_final)) {
                $insertData1 = DB::table('attribute_masters')->insertOrIgnore($attribute_name_final);
                if (!empty($attribute_name_final2)) {
                    foreach (array_chunk($attribute_name_final2, 1000) as $t) {
                        $insertData2 = DB::table('attributes')->insert($t);
                    }
                }
            }
            //  return back();
            return back()->with('success', 'Successfully imported!');
        } else {
            return back()->with('error', ' Please upload a valid xls/csv file..!!');
        }
    }
}
