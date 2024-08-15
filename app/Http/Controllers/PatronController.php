<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patron;
use Illuminate\Http\Request;

class PatronController extends Controller
{
    use ApiResponseTrait;


    public function index(){

        $patrons = Patron::orderBy('created_at','Desc')->get();
        return $this->apiResponse($patrons, 'ok', 200);
    }


    public function patron_details($id)
    {
      $patron = Patron::where('id', $id)->first();

      if($patron){
        return $this->apiResponse($patron, 'This details of the patron', 201);
      }
      else{
        return $this->apiResponse(null, 'This patron is not found', 404);
      }
    }


    public function store(Request $request)
    {
        try{
            $validator = Validator([
                'name' => 'required|max:255',
                'phone' => 'required|number|min:10|max:10',
                'email' => 'required|string|unique',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            $patron = new Patron(); 
            $patron->name = $request->name;
            $patron->phone = $request->phone;
            $patron->email = $request->email;
            $patron->save();

            if($patron){
                return $this->apiResponse($patron, 'The patron save', 201);
            }
            return $this->apiResponse(null, 'This patron not save', 400);

        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id){
        try{
            $validator = Validator([
                'name' => 'required|max:255',
                'phone' => 'required|string|min:10|max:10|unique:patrons',
                'email' => 'required|string|unique',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            $patron = Patron::findOrFail($id); 
            if(!$patron){
                return $this->apiResponse(null, 'This patron not found', 404);
            }

            $patron->name = $request->name;
            $patron->phone = $request->phone;
            $patron->email = $request->email;
            $patron->update();

            if($patron){
                return $this->apiResponse($patron, 'The patron update', 201);
            }
        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id){

        $patron = Patron::find($id); 
        if(!$patron){
            return $this->apiResponse(null, 'This patron not found', 404);
        }

        $patron->delete($id);
        if($patron){
            return $this->apiResponse(null, 'This patron deleted', 200);
        }
    }

}
