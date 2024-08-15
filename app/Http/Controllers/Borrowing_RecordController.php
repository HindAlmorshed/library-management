<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrowing_Record;
use Illuminate\Http\Request;

use Carbon\Carbon;

class Borrowing_RecordController extends Controller
{
    use ApiResponseTrait;


    public function borrow_book(Request $request, $book_id, $patron_id)
    {

        try {
            $validator = Validator([
                'book_id' => 'required',
                'patron_id' => 'required',
                'borrowing_date' => 'required',
                // 'return_date' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            $borrow = new Borrowing_Record(); 
            $borrow->book_id = $book_id;
            $borrow->patron_id = $patron_id;
            $borrow->borrowing_date = Carbon::parse($request->borrowing_date)->format('Y-m-d');
            // $borrow->return_date = Carbon::parse($request->return_date)->format('Y-m-d');
            $borrow->save();

            if($borrow){
                return $this->apiResponse($borrow, 'Allow a patron to borrow a book', 201);
            }
            return $this->apiResponse(null, 'The borrowing process was not completed', 400);

        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    


    public function return_book(Request $request, $book_id, $patron_id)
    {
        try{
            $validator = Validator([
                'book_id' => 'required',
                'patron_id' => 'required',
                // 'borrowing_date' => 'required',
                'return_date' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            // $return = Borrowing_Record::findOrFail($id); 
            $return = Borrowing_Record::where('book_id', $book_id)->where('patron_id', $patron_id)->where('return_date', null)->first();

            if ($return) {
                
                $return->return_date = Carbon::parse($request->return_date)->format('Y-m-d');
                $return->update();

                return $this->apiResponse($return, 'Return of the borrowed book', 201);
            }
            return $this->apiResponse(null, 'No borrowing', 400);
        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
}
