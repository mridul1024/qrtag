<?php

namespace App\Http\Controllers;


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

            for ($row = 3; $row <= $highestRow; ++$row) {
                //for category
                $catvalue = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                if (!in_array($catvalue, $cat_name)) {
                    if($catvalue != ''){
                    $cat_name[] = $catvalue;
                    $cat_name_final[] = [
                        'name' => $catvalue,
                        'created_by' => 'superadmin@example.com',
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
                    $category = DB::table('categories')->where('name',$worksheet->getCellByColumnAndRow(2, $row)->getValue())->first();
                    //ddd($category->id);
                    if($subcatvalue != ''){
                    $subcat_name[] = $subcatvalue;
                    $subcat_name_final[] = [
                        'category_id'=> $category->id,
                        'name' => $subcatvalue,
                        'created_by' => 'superadmin@example.com',
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
                    $subcategory = DB::table('subcategories')->where('name',$worksheet->getCellByColumnAndRow(4, $row)->getValue())->first();
                    //ddd($category->id);
                    if($subcattypevalue != ''){
                    $subcattype_name[] = $subcattypevalue;
                    $subcattype_name_final[] = [
                        'subcategory_id'=> $subcategory->id,
                        'name' => $subcattypevalue,
                        'created_by' => 'superadmin@example.com',
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
                    if($attributevalue != ''){
                        $attribute_name[] = $attributevalue;
                        $attribute_name_final[] = [
                        'name' => $attributevalue,
                        'created_by' => 'superadmin@example.com',
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                }
                $subcategorytype = DB::table('subcategorytypes')->where('name',$worksheet->getCellByColumnAndRow(6, $row)->getValue())->first();
                    if($attributevalue != ''){
                        $attribute_name_final2[] = [
                        'name' => $attributevalue,
                        'subcategorytype_id' => $subcategorytype->id,
                        'published' => 'Y',
                        'created_by' => 'superadmin@example.com',
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
            }

            if (!empty($attribute_name_final)) {
                $insertData1 = DB::table('attribute_masters')->insertOrIgnore($attribute_name_final);
                if (!empty($attribute_name_final2)) {
                    foreach (array_chunk($attribute_name_final2,1000) as $t)
                        {
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
